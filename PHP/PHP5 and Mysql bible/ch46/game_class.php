<?php
include_once("certainty_utils.php");
include_once("game_parameters_class.php");
include_once("question_class.php");

class Game 
{

  public $currentQuestion = NULL;
  public $previousQuestion = NULL;
  public $gameParameters;

  public $_dbConnection = NULL;
  public $_credit = 0.0;
  public $_level;
  public $_questionIdsAtLevel;  // an array of ids
  public $_questionsAskedAtLevel = 0; // a count
  public $_totalQuestions = 0;
  public $_correctAnswers = 0;
  public $_gameLost = FALSE;
  public $_gameWon = FALSE;

  // CONSTRUCTOR
  function __construct () {
    $this->gameParameters = new GameParameters();
    $this->_dbConnection =
      $this->gameParameters->getDbConnection();
    if (!$this->_dbConnection) {
       throw new Exception("No database connection");
    }
    else {   
      $this->_correctAnswers = 0;
      $this->_level = 
        $this->gameParameters->getStartingLevel();
      $this->_credit = 
        $this->gameParameters->getStartingCredit();
      // make a list of questions to be asked at the
      //   starting level
      $this->_setupQuestionIds();
      // actually retrieve the first question
      $this->_installQuestion();
    }
  }

  // PUBLIC FUNCTIONS
  // accessors
  function getGameParameters() 
    {return($this->gameParameters);}

  function getCurrentQuestion() 
    {return($this->currentQuestion);}

  function getPreviousQuestion() 
    {return($this->previousQuestion);}

  function getCredit() {return($this->_credit);}

  function getLevel() {return($this->_level);}

  function getQuestionsAskedAtLevel()
    {return($this->_questionsAskedAtLevel);}

  function getTotalQuestions() 
    {return($this->_totalQuestions);}

  function getCorrectAnswers()
    {return($this->_correctAnswers);}

  function getGameLost()     
    {return($this->_gameLost);}

  function getGameWon()     
    {return($this->_gameWon);}

  function getCurrentQuestionText() {
    if (!is_object($this->currentQuestion)) {
      print("What is it?<BR>");
      print_r($this->currentQuestion);
    }
    else {
      return($this->currentQuestion->getQuestion());
    }
  }

  function previousQuestionCorrect() {
    return($this->previousQuestion->getCorrect());
  }

  function getDbConnection () {
    if (!$this->_dbConnection) {
      $this->_dbConnection =
        $this->gameParameters->getDbConnection();
    }
    return($this->_dbConnection);
  }

  function updateWithAnswer ($lower, $upper) {
    // The main modifying function for a game object.
    // Takes a player's upper and lower guess, determines
    //  correctness, updates scores, determines if the 
    //  player has graduated to the next level, and
    //  swaps in the next question.
    $this->previousQuestion = $this->currentQuestion; 
    $this->previousQuestion->updateWithAnswer($lower, 
                                              $upper);
    $this->_updateScores();    
    $this->_maybeChangeLevel();
    if (!($this->_gameLost || $this->_gameWon)) {
      $this->_installQuestion();
    }
  }

  // PRIVATE FUNCTIONS
  function _installQuestion () {
    // actually retrieve a question from the database
    //  and create a corresponding instance of Question
    if (count($this->_questionIdsAtLevel) > 0) {
      // pop a question off the randomized list
      $question_id = 
        array_pop($this->_questionIdsAtLevel);
      $query = 
        "select id, question, answer,
         upper_limit, lower_limit, scaling_type
         from question
         where id = $question_id";
      if (!$this->_dbConnection) {
        $this->_dbConnection =
          $this->gameParameters->getDbConnection();
      }
      if ($this->_dbConnection &&
          is_resource($this->_dbConnection)) {
          $result = mysql_query($query, 
                            $this->_dbConnection);
        if ($row = mysql_fetch_assoc($result)) {
          $this->currentQuestion =
             new Question(
               $row['id'],
               $row['question'],
               $row['answer'],
               $row['lower_limit'],
               $row['upper_limit'],
               10,
               $row['scaling_type']);
          $this->_questionsAskedAtLevel++;
        }
        else {
	  throw new 
            Exception("Problem retrieving question from database");
        }
      }
      else {
        throw new 
            Exception("Problem querying question database");
      }
    }
    else {
      throw new 
          Exception("Could not find any questions to ask");
    }
  }

  function _setupQuestionIds () {
    $this->_questionIdsAtLevel =
      $this->_getQuestionIdsAtLevel($this->_level);
  }

  function _getQuestionIdsAtLevel ($level) {
    // to be used at time of graduation to a new level -
    // retrieves the new ids (only) of all questions at
    // the level, and shuffles them into a random order.
    $return_array = array();
    $query = "select id from question 
              where level = $level";
    $this->getDbConnection();
    if (!$this->_dbConnection) {
      throw new 
          Exception("No database connection");
    }
    else {
      $result = mysql_query($query, 
                            $this->_dbConnection);
      while ($row = mysql_fetch_assoc($result)) {
        array_push($return_array, $row['id']);
      }
    }
    // randomize the order of the questions
    $return_array = create_randomized_array($return_array);
    return($return_array);
  }

  public function _updateScores () {
    // Change the current score based both on 
    //  whether the player got the answer right and on
    //  the spread between the player's upper and lower
    //  guess.  Calculations depend on settings from 
    //  the GameParameters class.
    if ($this->previousQuestion->rightAnswer()) {
      $this->_correctAnswers = 
        $this->_correctAnswers + 1;
      $this->_credit +=
        $this->gameParameters->getRightAnswerCredit() -
        ($this->previousQuestion->getAnswerSpread() *
         $this->gameParameters->getAnswerSpreadDebit());
    }
    else {
      $new_credit = 
      $this->_credit = 
        $this->_credit -
        $this->gameParameters->getWrongAnswerDebit();
    }
    // enforce cap on credit
    $this->_credit = 
      min($this->_credit, 
          $this->gameParameters->getMaximumCredit());
  }

  function _maybeChangeLevel () {
    if ($this->_credit < 0.0) {
      $this->_gameLost = TRUE;
    }
    else {
      $params = $this->gameParameters;
      $current_level = $this->_level;
      if ($current_level > 
          $params->getMaximumLevel()) {
        $this->_gameWon = TRUE;
      }
      else {
        // find out if questions remain to be 
        //  asked at this level
        if (($this->_questionsAskedAtLevel >=
             $params->getQuestionsPerLevel($current_level)) ||
            (count($this->_questionIdsAtLevel) == 0)) {
              // either we have asked the limit of 
              // questions per level, OR we have simply run out
              $this->_level++;
              $this->_questionsAskedAtLevel = 0;
              $this->_setupQuestionIds();
              // note recursive call --- it's possible
              //  that no questions were found, and we have
              //  to keep going
              $this->_maybeChangeLevel();
        }
      }   
    }
  }

  function __sleep () {
    // make sure to serialize all fields except
    //  the database connection (has to be recreated)
    //  and the previous question (no point).
    return(array(
           'gameParameters',
           'currentQuestion',
           '_credit',
           '_level',
           '_questionIdsAtLevel',
           '_questionsAskedAtLevel',
           '_correctAnswers',
           '_totalQuestions',
           '_gameLost',
           '_gameWon'));
  }
}
?>
