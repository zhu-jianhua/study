<?php
/**
 * If the user is returning to this page 
 * after previously registering, use the 
 * cookie to welcome them back.
 */
if ( isset( $_COOKIE['username'] ) ) {
	echo "Welcome back, ",
		htmlentities( $_COOKIE['username'] ),
		"! <br />";
}

/**
 * If the user is new and submits the 
 * registration form, set a cookie with
 * their username and display a thank
 * you message.
 */
else if ( $_SERVER['REQUEST_METHOD'] == 'POST'
			&& !empty( $_POST['username'] ) ) {

			# Sanitize the input and store in a variable
			$uname = htmlentities( $_POST['username'] );

			# Set a cookie that expires in one week
			$expires = time() + 7*24*60*60;
			setcookie('username', $uname, $expires, '/');
			
			# Output a thank you message
			echo "Thanks for registering, $uname! <br />";				
}

/**
 * If the user has neither previously registered
 * or filled out the registration form, show the
 * registration form.
 */
else {

?>

<form method="post">
	<label for="username">Username:</label>
	<input type="text" name="username" />
	<input type="submit" value="Register" />
</form>

<?php } # End else statement ?>
