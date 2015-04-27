<?php
/**
 * Checks if the form was submitted
 */
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	# Displays the submitted information
	echo "Thanks for registering! <br />",
	"Username: ", htmlentities($_POST['username']), "<br />",
	"Email: ", htmlentities($_POST['email']), "<br />";
} else {
	# If the form was not submitted, displays the form
?>
	<form action="82-test.php" method="post">
	<label for="username">Username:</label>
	<input type="text" name="username" />
	<label for="email">Email:</label>
	<input type="text" name="email" />
	<input type="submit" value="Register!" />
	</form>
	
<?php } # End else statement ?> 