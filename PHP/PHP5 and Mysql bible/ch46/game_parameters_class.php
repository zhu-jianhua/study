<?php
include_once("certainty_utils.php");
include_once("dbvars.php");  // should really be moved out of the web tree

class GameParameters {

  // PRIVATE VARIABLES
  var $_dbConnection = NULL;
  var $_startingLevel = 1;
  var $_maximumLevel = 10;
  var $_startingCredit = 5.0;
  var $_maximumCredit = 15.0;
  var $_questionsPerLevel = 3;
  var $_rightAnswerCredit = 1.0;
  var $_wrongAnswerDebit = 4.0;
  var $_answerSpreadDebit = 4.0;

  // CONSTRUCTOR
  function GameParameters () {
    // all fields set by default values
  }

  // PUBLIC FUNCTIONS
  // accessors

  function getStartingLevel () {
    return($this->_startingLevel);
  }

  function getMaximumLevel () {
    return($this->_maximumLevel);
  }

  function getStartingCredit () {
    return($this->_startingCredit);
  }

  function getMaximumCredit () {
    return($this->_maximumCredit);
  }

  function getRightAnswerCredit () {
    return($this->_rightAnswerCredit);
  }

  function getWrongAnswerDebit () {
    return($this->_wrongAnswerDebit);
  }

  function getAnswerSpreadDebit () {
    return($this->_answerSpreadDebit);
  }

  function getQuestionsPerLevel () {
    return($this->_questionsPerLevel);
  }  

  function getDbConnection () {
    global $host, $user, $pass, $db;  // included from dbvars.inc
    if ($this->_dbConnection &&
        is_resource($this->dbConnection)) {
      return($_dbConnection);
    }
    else {
      // suppress warnings about connection,
      // will handle at higher level if failed
      $connection = 
        @mysql_connect($host, $user, $pass);
      if ($connection &&
          mysql_select_db($db, $connection)) {
        return($connection);
      }
      else {
        return(FALSE);
      }
    }
  }

  function __sleep () {
    return(array('_startingLevel',
                 '_startingCredit',
                 '_rightAnswerCredit',
                 '_maximumCredit',
                 '_wrongAnswerDebit',
                 '_answerSpreadDebit',
                 '_questionsPerLevel'));
  }
}
?>
