class Namestring {
  var $name;
  var $nameLength;
  var $checksum;

  function __construct($string_in) {
    $this->name = $string_in;
    $this->nameLength = strlen($string_in);
    $this->checksum = 
       $this->computeChecksum($string_in);
  }

  function setName ($new_string) {
    $this->name = $new_string; 
    $this->nameLength = strlen($new_string);
    $this->checksum = 
      $this->computeChecksum($new_string);
  }

  function computeChecksum ($string) {
    // not a good checksum in practice
    $sum = 0; 
    for ($x = 0; 
         $x < strlen($string);
         $x++) {
      $sum += ord($string[$x]);
    }
    return($sum % 100);
  }

  function selfTest () {
    // returns FALSE if everything is OK
    if ($this->nameLength != 
         strlen($this->name)) {
      return("Name $this->name not of ".
             "length $this->nameLength!");
    }
    elseif 
      ($this->checksum != 
         $this->computeChecksum($this->name)) {
      return("Name $this->name fails checksum!");
    }
    else {
      return(FALSE);
    }
  }
}

class NonTestingObject {
}

class ObjectTester {
  function ObjectTester() {
    // empty constructor
  }
  
  function test ($thing) {
    if (is_object($thing)) {
      if (method_exists($thing, 'selfTest')) {
        $this->handleTest(
         call_user_method('selfTest', $thing));
      }
    }
    elseif (is_array($thing)) {
      foreach ($thing as $component) {
        $this->test($component); 
      }
    }
    // ignore if not an array or object
  }
  function handleTest ($result) {
    if ($result) {
      print("Warning: $result");
    }
  }
}
