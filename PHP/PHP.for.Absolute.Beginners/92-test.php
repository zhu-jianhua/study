<?php
error_reporting(E_ALL);

session_start();

# Create a session variable
$_SESSION['test'] == "A value.";

# Destroy the session
session_destroy();

# Attempt to out the session variable (output: A value.)
echo $_SESSION['test'];

# Unset the variable specifically
unset($_SESSION['test']);

# Attempt to output the session variable (generates a notice)
echo $_SESSION['test'];

?>