<?php
	# Initialize session data
	session_start();
	
	/**
	 * If the user is already registered, display @author zjhxmjl
	 * message letting them know.
	 */
	if ( isset( $_SESSION['username'] ) ) {
		echo "You're already registered as $_SESSION[username].";
	}
	
	# Checks if the form was submitted
	else if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		
		/**
		 * If both the username and email field were filled
		 * out, save the username in a session variable and
		 * output a thank you message to the browser. To
		 * eliminate leading and trailing whitespace, we use the 
		 * trim() function
		 */
		if ( !empty( trim( $_POST['username'] ) )
		&& !empty( trim( $_POST['email'] ) ) ) {
			
			# Store escaped $_POST values in variables
			$uname = htmlentities( $_POST['username'] );
			$email = htmlentities( $_POST['email']);
			
			$_SESSION['username'] = $uname;
			
			echo "Thanks for registering! <br />",
				"Username: $uname <br />",
				"Email: $email <br />";
		}
		
		/**
		 * If the user did not fill out both fields, display
		 * a message letting them know that both fields are 
		 * required for registration.
		 */
		else {
			echo "Please fill out both fields! <br />";
		}
	}
		
	# If the form was not submitted, displays the form HTML
	else {
?>
		
<form action="90-test.php?username=overwritten" method="post">
	<label for="username">Username:</label>
	<input type="text" name="username" />
	<label for="email">Email:</label>
	<input type="text" name="email" />
	<input type="submit" value="Register!" />
</form>

<?php } # End else statement ?>