class MyClass {

private $colorOfSky = "blue";
$nameOfShip = "Java Star";

function __construct($incomingValue) {
// Statements here run every time an instance of the class 
// is created.
}

function myPublicFunction ($my_input) {
    return("I'm visible!");    
  }

private function myPrivateFunction ($my_input) {
    global $my_global;
    return($my_global *
           $my_input *
           my_function($this->my_member));    
  }

}
