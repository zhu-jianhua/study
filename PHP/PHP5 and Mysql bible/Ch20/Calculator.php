class Calculator 
{
  var $current = 0;
  function add($num) {
    $this->current += $num;
  } 
  function subtract($num) {
    $this->current -= $num;
  } 
  function getValue() {
    return($current);
  }
  function pi() {
    return(M_PI); // the PHP constant
  }
}
