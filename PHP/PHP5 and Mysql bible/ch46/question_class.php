<?php
include_once("certainty_utils.php");

class Question 
{
  // PRIVATE VARIABLES
  private $_id; // ID in database
  private $_question; // text of question
  private $_answer; // correct numeric answer
  private $_lowerLimit; // smallest value in distractors
  private $_upperLimit; // largest value in distractors
  private $_distractorCount; // number of dist. presented
  private $_scalingType;  // representing linear vs. geometric
  private $_distractorArray; // contains all dist presented
  private $_lowerGuess = NULL; // player's lower bound
  private $_upperGuess = NULL; // player's upper bound
  private $_correct = NULL;  // TRUE or FALSE after guess

  // CONSTRUCTOR
  function __construct($id, $question,
                       $answer, 
                       $lower_limit,
                       $upper_limit,
                       $distractor_count,
                       $scaling_type) {
    $this->_id = $id;
    $this->_question = $question;
    $this->_answer = $answer;
    $this->_lowerLimit = $lower_limit;
    $this->_upperLimit = $upper_limit;
    $this->_distractorCount = $distractor_count;
    $this->_scalingType = $scaling_type;
    $this->_distractorArray =
        $this->_makeDistractors($lower_limit, 
                   $upper_limit,
                   $distractor_count,
                   $scaling_type);
  }

  // PUBLIC FUNCTIONS

  // accessors

  function getId () {return($this->_id);}
  function getQuestion () {return($this->_question);}
  function getAnswer () {return($this->_answer);}
  function getCorrect() {return($this->_correct);}
  function rightAnswer() {return($this->_correct);}
  function getDistractorCount() {return($this->_correct);}
  function getScalingType() {return($this->_scalingType);}
  function getDistractorArray() {return($this->_distractorArray);}
  function getLowerGuess() {return($this->_lowerGuess);}
  function getUpperGuess() {return($this->_upperGuess);}

  function getAnswerSpread () {
    $answer_range = count($this->_distractorArray) - 1;
    if (IsSet($this->_lowerGuess) &&
        IsSet($this->_upperGuess)) {
      $lower = $this->_lowerGuess;
      $upper = $this->_upperGuess;
      if ($upper < $lower) {
	throw new Exception("Problem in range of answers");
      }
      else {
        $spread = 
               (max($upper - $lower, 1) - 1)
               / ($answer_range - 1);
        return($spread);
      }
    }
    else {
      throw new Exception("Answer variables not set");
    }
  }

  function updateWithAnswer($lower, $upper) {
    // takes a lower and upper guess from player, and
    //  determines if the guesses bound the right answer
    $this->_lowerGuess = $lower;
    $this->_upperGuess = $upper;
    $upper_value = NULL;
    $lower_value = NULL;
    $count = 1;
    foreach ($this->_distractorArray as $distractor) {
      if ($count == $lower) {
        $lower_value = $distractor;
      }
      if ($count == $upper) {
        $upper_value = $distractor;
      }
      $count++;
    }
    if (IsSet($lower_value) && IsSet($upper_value)) {
      $answer = $this->_answer;
      $lower_value_lowered = $lower_value -
        max(0.0001, abs($lower_value / 1000000.0));
      $upper_value_raised = $upper_value +
        max(0.0001, abs($upper_value / 1000000.0));
      if (($lower_value_lowered <= $this->_answer) &&
          ($upper_value_raised >= $this->_answer)) {
        $this->_correct = TRUE;        
      }
      else {
        $this->_correct = FALSE;
      }
    }
    else {
      $this->_correct = NULL;
    }
  }

  // PRIVATE FUNCTIONS
  private function _makeDistractors ($lower, $upper,
                             $distractor_count,
                             $linear_or_geometric)
  // Create the array of intermediate values between
  //  the upper bound and the lower bound on guesses
  //  that the player can choose from.  Depending on 
  //  a flag in each row of the question database,
  //  the scaling of possible answers ("distractors")
  //  can be linear (10, 20, 30 ...) or geometric
  //  (10, 20, 40, 80 ...)
  // Code for construction of geometric distractors can
  //   blow up for some arguments, so arguments are 
  //   checked before calls to make_distractors_geometric
  //   are allowed.  Failures default back to linear.
  {
    if (($linear_or_geometric == CERTAINTY_GEOMETRIC) &&
        ($this->safeGeometricArguments($upper, $lower))) {
       return($this->_makeDistractorsGeometric(
         $lower, $upper, $distractor_count));
    }
    else {
      return($this->_makeDistractorsLinear(
         $lower, $upper, $distractor_count));
    }
  }

  private function safeGeometricArguments ($upper, $lower) {
   // should probably really also include the number
   // of distractors as an argument.  Only tested for
   // # of distractors approx 10.
   return (($upper > 0) && ($lower > 0) &&
           ($upper > $lower) &&
           (($upper / $lower) < 10000000000));
  }

  private function _makeDistractorsLinear
           ($lower, $upper, $distractor_count) 
  {
    
    $return_array = array();
    array_push($return_array, round_to_digits($lower, 3));
    $current = $lower;
    $increment = (($upper - $lower) / $distractor_count);
    // add in all the intermediate values
    for ($x = 1; $x < $distractor_count; $x++) {
      array_push($return_array, 
                 round_to_digits($lower + 
  	                         ($x * $increment),
                                 3));
    }
    array_push($return_array, round_to_digits($upper, 3));
    return($return_array);
  }

  private function _makeDistractorsGeometric
           ($lower, $upper, $distractor_count) 
  {
    if (($lower >= $upper) ||
        ($distractor_count < 2)) {
      die("Args to _makeDistractorsGeometric should be " .
          "1) a lower limit, 2) an upper limit, " .
          "3) a count (>= 2) of divisions between them.<BR>" .
          "Args were 1) $lower, 2) $upper, 3) $distractor_count<BR>");
    }   
    $return_array = array();
    array_push($return_array, round_to_digits($lower, 3));
    $limit_ratio = $upper / $lower;
    $root = nth_root($limit_ratio, $distractor_count);
    $current = $lower;
    // add in the intermediate values
    for ($x = 1; $x < $distractor_count; $x++) {
      $distractor = round_to_digits(
                      $lower * pow($root, $x),
                      3);
      array_push($return_array, 
                 $distractor);
    }
    array_push($return_array, round_to_digits($upper, 3));
    return($return_array);
  }
}
?>
