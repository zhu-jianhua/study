$my_global = 3;

function my_function ($my_input) {
  global $my_global;
  return($my_global * $my_input);
}

class MyClass {
  var $my_member;
  function __construct($my_constructor_input) {
    $this->my_member =
      $my_constructor_input;
  }
  function myMemberFunction ($my_input) {
    global $my_global;
    return($my_global *
           $my_input *
           my_function($this->my_member));    
  }
}

$my_instance = new MyClass(4);
print("The answer is: " .
      $my_instance->myMemberFunction(5));
