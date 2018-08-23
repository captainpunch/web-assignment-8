<?php # Script 10.2 - delete_user.php
// This page is for deleting a user record.
// This page is accessed through view_users.php.

$page_title = 'Delete a User';
include ('includes/header.html');
echo '<div class="header-3">Delete a User</div>';
//echo '<div class="container">';
// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.

		// acces error 
	echo '<p class="alert-warning"> page was accesses improperly.</p> <p> You will be redirected in <b>10 seconds</b> or follow the button.';
	
		// auto redirect in 10 seconds
	header( "refresh:10;url=view_users.php");
	
		// optional button to redirect
	echo '<button class="button" align="center" value="redirect" onclick="location.href = 'view_users.php'>';
	include ('includes/footer.html'); 
	exit();
}

require_once ('includes/mysqli_connect.php');

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
		$q = "DELETE FROM users WHERE user_id=$id LIMIT 1";		
		$r = @mysqli_query ($dbc, $q);
		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			// Print a message:
			echo '<p>The user has been deleted.</p>';
			
			//auto redirect 
			header( "refresh:10;url=view_users.php" ); 
			
			// button to redirect to users 
			echo '<button class="button" align="center" value="redirect" onclick="location.href = 'view_users.php'>';
			
		} else { // If the query did not run OK.
			echo '<p class="alert">The user could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}
	
	} else { // No confirmation of deletion.
		echo '<p>The user has NOT been deleted.</p>';	
	}

} else { // Show the form.

	// Retrieve the user's information:
	$q = "SELECT CONCAT(last_name, ', ', first_name), status as status FROM users WHERE user_id=$id";
	$r = @mysqli_query ($dbc, $q);

	if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

		// Get the user's information:
		$row = mysqli_fetch_array ($r, MYSQLI_BOTH);
		
		// Display the record being deleted:
		echo '<h3>Name: ' . $row[0] . '</h3>';
		if($row['status'] == 'A')
		{
			echo '<p class="alert-warning"> This user is currently active and cannot be deleted.</p>';
		}
		else{
		// Create the form:
		echo ' <p>Are you sure you want to delete this user?</p>';
		echo '<form class="form" action="delete_user.php" method="post">
	<input type="radio" name="sure" value="Yes" /> Yes 
	<input type="radio" name="sure" value="No" checked="checked" /> No <br>
	<input type="submit" name="submit" value="Submit" />
	<input type="hidden" name="id" value="' . $id . '" />
	</form>';
		}
	} else { // Not a valid user ID.
		echo '<p class="alert">This page has been accessed in error.</p>';
	}

} // End of the main submission conditional.

mysqli_close($dbc);
//echo '</div>';
include ('includes/footer.html');
?>