


specifying indices(index复数) using array()

$fruit_basket = array(0 => 'apple', 1 => 'orange',
2 => 'banana', 3 => 'pear');

instead,we can use exactly the same syntax to store these elements with different indices
$fruit_basket = array('red' => 'apple', 'orange' => 'orange',
'yellow' => 'banana', 'green' => 'pear');

so,we just evaluate the expression:
$fruit_basket['yellow'] // will be equal to 'banana'

create an empty array
$my_empty_array = array();

functions returning arrays
$my_array = range(1,5);
is equivalent to:
$my_array = array(1,2,3,4,5);

the list() construct
$fruit_basket = array('apple','orange','banana');
list($red_fruit,$orange_fruit) = $fruit_basket;

deleting from arrays
$my_array[0] = ‘wanted’;
$my_array[1] = ‘unwanted’;
$my_array[2] = ‘wanted again’;
unset($my_array[1]);
at the end if has two values:'wanted','wanted again'



