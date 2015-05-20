<?php 
include_once("game_class.php");
include_once("game_text_class.php");

class GameDisplay
{
  //    presentation
  public $_pageTitle = "The Certainty Quiz";
  public $_blueColor = "#AAAAFF";
  public $_redColor = "#FFAAAA";

  //    contents
  public $_game = NULL;
  public $_gameText;
  public $_highScorePosted = FALSE;
  
  // CONSTRUCTOR

  function __construct ($game) {
    $this->_game = $game;
    $this->_gameText = new GameText();
  }

  // PUBLIC FUNCTIONS
  //   accessors
  function getPageTitle() {
    return($this->_pageTitle);
  }
  function getBlueColor() {
    return($this->_blueColor);
  }
  function getRedColor() {
    return($this->_redColor);
  }
  function getGame() {
    return($this->_game);
  }
  function getHighScorePosted() {
    return($this->_highScorePosted);
  }

  function updateWithAnswer ($lower, $upper) {
    $game = $this->getGame();
    $game->updateWithAnswer($lower, $upper);
  }

  function makeErrorPage ($problem_string) {
    // constructs the HTML page to display when
    /// something has gone horribly wrong
    $top_matter_string = 
       $this->_makeTopMatter($this->_pageTitle);
    $page_string = <<<EOT
$top_matter_string
</H2></CENTER>
<TABLE BORDER=2>
<TR>
<CENTER>
<H2>We're sorry, but the game is not available 
right now.</H2><H4>($problem_string)</H4>
</CENTER>
</TR></TABLE>
</BODY></HTML>
EOT;
    return($page_string);
  }

  function display () {
    // returns entire page as string ---
    // backbone structure of page, plus
    // overridable methods to print components

    // sanity checks
    if (!$this->_game ||
        !is_object($this->_game)) {
      throw new 
	Exception("Cannot find valid game object");
    }
    elseif (!$this->_game->getDbConnection()) {
      throw new 
	Exception("No database connection");
    }

    // display of apparently valid page
    else {
      $top_matter_string = 
        $this->_makeTopMatter($this->_pageTitle);
      $current_question = 
        $this->_currentQuestionString();
      $previous_question = 
        $this->_previousQuestionString();
      $game_state = 
        $this->_gameStateString();
      $introduction = 
        $this->_gameText->introduction();
      $rules = 
        $this->_gameText->rules();
      if ($this->_game->getGameLost()) {
        $left_side = 
          $this->_gameText->gameLostText() .
          $this->_highScoreString();
      }
      elseif ($this->_game->getGameWon()) {
        $left_side = 
          $this->_gameText->gameWonText() .
          $this->_highScoreString();
      }
      else {
        $left_side = $current_question;
      }
      if ($this->_game->getPreviousQuestion()) {
         $right_side = 
           "<TABLE><TR><TD>
           $previous_question
           </TD></TR><TR><TD>
           $game_state
           </TD></TR><TR><TD>
           $rules
           </TD></TR></TABLE>";
      }
      else {
         $right_side = 
           "<TABLE><TR><TD>
           $introduction
           </TD></TR>
           <TR><TD>
           $rules
           </TD></TR><TR><TD>  
           $game_state
           </TD></TR>
           </TABLE>";
      }
    
    // actually construct page
$page_string = <<<EOT
$top_matter_string
</H2></CENTER>
<TABLE BORDER=2>
<TR>
<TD VALIGN=TOP WIDTH=40% >$left_side</TD>
<TD VALIGN=TOP WIDTH=60% >$right_side</TD>
</TR></TABLE>
</BODY></HTML>
EOT;
      return($page_string);
    }
  }

  function handleHighScore () { 
    // Handles database update for case where player
    //  has earned high score, and has submitted
    //  a name for the record
    if (!$this->_highScorePosted) {
      $this->_highScorePosted = TRUE;
      if (get_post_value('NICKNAME') &&
          get_post_value('ANSWER_COUNT') &&
          get_post_value('CREDIT') &&
          get_post_value('CHECKSUM') &&
          $this->_checksumChecks(
            get_post_value('ANSWER_COUNT'),
            get_post_value('CREDIT'),
            get_post_value('CHECKSUM'))) {
        $name = get_post_value('NICKNAME');
        $answer_count = get_post_value('ANSWER_COUNT');
        $credit = get_post_value('CREDIT');
        $query = "insert into high_scores
                  (name, answer_count, credit)
                  values 
                  ('$name', $answer_count, $credit)";
        $connection = 
         $this->_game->gameParameters->getDbConnection();
        $result = mysql_query($query, $connection);
      }
      else {
        // do nothing -- failure to add high score
        // should not be a deal killer        
      }
    }
  }

  // PRIVATE FUNCTIONS

  private function _makeTopMatter ($title) {
    // returns HTML fragment that heads both
    //  regular page and error page, containing
    //  HTML head and title
    $return_string = <<<EOT
<HTML><HEAD><TITLE>$title</TITLE></HEAD>
<BODY BGCOLOR=#FFFFFF><CENTER>
<H1>$title<BR>
<FONT SIZE=-1 COLOR=BLUE>
(How sure <B>are</B> you?)</FONT>
</H1></CENTER>
EOT;
    return($return_string);
  }

  private function _currentQuestionString () {
    $PHP_SELF = $_SERVER['PHP_SELF'];
    return("<H2>" .
           $this->_game->getCurrentQuestionText() .
           "</H2>" .
           "<FORM METHOD=POST ACTION=\"$PHP_SELF\">" .
           "<INPUT TYPE=HIDDEN NAME=POSTCHECK VALUE=1>" .
           $this->_distractorString(
              $this->_game->getCurrentQuestion()) .
           "</FORM>");
  }

  private function _distractorString ($question) {
    // creates the actual HTML for presentation of 
    //  radio-button alternatives for guesses.  
    //  Assumes that the array representing the
    //    actual alternatives has been calculated in
    //    advance, retrievable from the question using
    //    getDistractorArray
    $distractor_array = $question->getDistractorArray();
    $distractor_string = "<TABLE><TR VALIGN=TOP><TD>";
    $distractor_string .= 
      "<TABLE BORDER=1 BGCOLOR=\"AAAAFF\"><TR><TH> 
        </TH><TH>At least</TH><TH>Not more than</TH>";
    $count = 1;  // 1-based labels are preferable, 
                 // so we can just use if ($label) ...
    $total = count($distractor_array);
    foreach ($distractor_array as $distractor) {
      $lower_selected = ($count == 1) ?
        "CHECKED" : "";
      $upper_selected = ($count == $total) ?
        "CHECKED" : "";
      $formatted_distractor = 
         ($distractor >= 10000) ?
            number_format($distractor) : $distractor;
      $distractor_string .= 
        "<TR><TD>$formatted_distractor</TD>
             <TD><INPUT TYPE=RADIO NAME=\"lower\"
                  VALUE=$count 
                  $lower_selected ></TD>\n" .
        "<TD><INPUT TYPE=RADIO NAME=\"upper\"
             VALUE=$count
             $upper_selected ></TD></TR>\n";
      $count++;
    }
    $distractor_string .= "</TABLE>";
    $distractor_string .= "</TD><TD>";
    $distractor_string .= 
       "<INPUT NAME=\"Submit guess\" VALUE=\"Submit guess\"
               TYPE=SUBMIT>";
    $distractor_string .= "</TD></TR></TABLE>";

    return($distractor_string);
  }

  private function _previousQuestionString () {
    if (!$this->_game->getPreviousQuestion()) {
      $return_string = "";
    }
    else {
      $return_string =
        $this->_game->previousQuestionCorrect() ? 
          $this->_rightString() :
          $this->_wrongString();
    }
    return($return_string);
  }

  function _rightString () {
    return("<H1><FONT COLOR=GREEN>RIGHT!</FONT></H1>");
  }

  function _wrongString () {
    return("<H1><FONT COLOR=RED>WRONG!</FONT></H1>");
  }

  private function _highScoreEligible () { 
    // takes a game-ending score, and queries the
    //  DB to see if the player is eligible for the
    //  high score list
    $query = "select name, answer_count, credit
              from high_scores
              order by answer_count desc, credit desc
              limit 10";
    $connection = 
      $this->_game->getDbConnection();
    if ($connection && is_resource($connection)) {
      $result = mysql_query($query, $connection);
      $eligible = false;
      if (mysql_num_rows($result) > 9) {
        while ($row = mysql_fetch_assoc($result)) {
          $answer_count = $row['answer_count'];
          $credit = $row['credit'];
          if (($this->_game->getCorrectAnswers()
                > $answer_count) ||
              (($this->_game->getCorrectAnswers() 
                 == $answer_count) &&
               ($this->_game->_credit > $credit))) {
            $eligible = TRUE;
            break;
          }
        }
      }
      else {
        $eligible = TRUE;
      }
      return($eligible);
    }
    else {
      throw new
        Exception("Game display has no database connection");
    }
  }

  // Checksum is calculated when posting a score 
  //  (comprised of a number of correct answers plus
  //  credit remaining) and the checksum is compared with
  //  the submitted scores.  A first line of defense against
  //  spoofing (unless, of course, the checksum scheme is
  //  published in a book or something).
  private function _checksumChecks ($answer_count, $credit,
                            $checksum) {
    return($checksum ==
           $this->_makeCheckSum($answer_count, $credit));
  }

  private function _makeChecksum ($answer_count, $credit) {
   return ((round($credit)) * 17) *
           ($answer_count * 31);
  }

  private function _postHighScoreString () {
    // The greeting plus HTML form for actually submitting
    //  a name to the high scores list
    $PHP_SELF = $_SERVER['PHP_SELF'];
    $answer_count = $this->_game->getCorrectAnswers();
    $credit = $this->_game->getCredit();
    $checksum = $this->_makeChecksum($answer_count, $credit);
    $result_string = 
      "<H2>Congratulations! You have a high score</H2>".
      "Enter your name (or a nickname) for the high ".
      "scores list:".
      "<FORM METHOD=POST ACTION=\"$PHP_SELF\" >".
      "<INPUT NAME=NICKNAME TYPE=TEXT SIZE = 30>".
      "<INPUT NAME=ANSWER_COUNT TYPE=HIDDEN ".
        "VALUE=$answer_count>".
      "<INPUT NAME=CREDIT TYPE=HIDDEN ".
        "VALUE=$credit>".
      "<INPUT NAME=CHECKSUM TYPE=HIDDEN ".
        "VALUE=$checksum>".
      "<INPUT NAME=Submit TYPE=SUBMIT ".
        "VALUE=Submit >".
      "<INPUT TYPE=HIDDEN NAME=POSTCHECK VALUE=1>" .
      "<INPUT TYPE=HIDDEN NAME=HIGHSCORE VALUE=1>" .
      "<FORM>";
    return($result_string);
  }

  private function _highScoreString () {
    // The table of high scores itself, including 
    //  the database interaction necessary to retrieve it
    if ($this->_highScoreEligible() &&
        !$this->_highScorePosted) {
      $result_string = $this->_postHighScoreString();
    }
    else {
      $result_string = "";
    }
    $result_string .= 
     "<H2>High scores to date</H2>".
     "<TABLE BORDER=1><TR><TH>Rank</TH>".
     "<TH>Name</TH><TH>Correct answers</TH>".
     "<TH>Credit left at end</TH></TR>";
    $query = "select name, answer_count, credit
              from high_scores
              order by answer_count desc, credit desc
              limit 10";
    $connection = 
      $this->_game->gameParameters->getDbConnection();
    if ($connection && is_resource($connection)) {
      $result = mysql_query($query, $connection);
      $rank = 1;
      while ($row = mysql_fetch_assoc($result)) {
        $name = $row['name'];
        $answer_count = $row['answer_count'];
        $credit = (int) ($row['credit']);
        $result_string .=
          "<TR><TH>$rank</TH><TD>$name</TD>".
          "<TD>$answer_count</TD><TD>$credit</TD></TR>";
        $rank++;
      }
      $result_string .= "</TABLE>";
      return($result_string);
    }
    else {
      throw new
        Exception("Game display has no database connection");
    }
  }

  private function _gameStateString () {
    // The HTML table 
    $correct_answers = $this->_game->getCorrectAnswers();
    $credit = round_to_digits($this->_game->getCredit(), 2);
    $level = $this->_game->getLevel();
    return("<TABLE CELLPADDING=10>".
    "<TR BGCOLOR=$this->_blueColor><TH>Total correct answers:</TH>".
    "<TD>$correct_answers</TD></TR>".
    "<TR BGCOLOR=$this->_redColor><TH>Credit remaining:</TH>".
    "<TD>$credit</TD></TR>".
    "<TR BGCOLOR=$this->_blueColor><TH>You have reached level:</TH>".
    "<TD>$level</TD></TR></TABLE>");
  }
}
?>
