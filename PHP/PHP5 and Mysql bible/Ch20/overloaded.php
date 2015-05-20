class MyClass 
{
var $string_var = "default string";
var $num_var = 42;

  function __construct($arg1) {
    if (is_string($arg1)) {
      $this->string_var = $arg1;      
    }
    elseif (is_int($arg1) ||
            is_double($arg1)) {
      $this->num_var = $arg1;      
    }
  }
}

$instance1 = new MyClass("new string");
$instance2 = new MyClass(5);
