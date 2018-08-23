<?php 	// Grant Schorgl Assignment 7 11/8/2016
$page_title = 'Current Users';
include 'includes/header.html';
require 'mysqli_connect.php';
$query = "SELECT last_name, first_name, DATE_FORMAT( registration_date, '%M %d, %Y') AS dr, user_id, status AS status FROM users ORDER BY registration_date ASC";
//$concat = "SELECT CONCAT(last_name, ', ', first_name) AS name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr FROM users ORDER BY registration_date ASC";
echo '<h1>Registered Users</h1>';
$results = mysqli_query($dbc, $query);
$num = @mysqli_num_rows($results);

 if ($num > 0 ) 
{
echo "<p align='center'>there are currently $num registered users.</p>\n";
	echo 
	'<table class="table">
		<thead>
			<tr>
				
				<td align ="left">	<br>Last Name</br>				</td>
				<td align ="left">	<br>First Name</br>				</td>
				<td align ="left">	<br>Date Registered</br>	</td>
				<td align ="left">	<br>Status</br>				</td>
				
				<td align ="left">	<br>Edit</br>				</td>
				<td align ="left">	<br>Delete</br>				</td>
			</tr>
		</thead>';
		while ($row =mysqli_fetch_array($results, MYSQLI_ASSOC)) 
		{
		echo 
		'<tr>
			
			<td align="left"> ' . $row['last_name'] . '	</td>
			<td align="left"> ' . $row['first_name'] . '	</td>
			<td align="left">  ' .$row['dr'] . '		</td>
			<td align="left">  ' .$row['status'] . '		</td>
			<td align="left"><a href="status.php?id=' . $row['user_id'] . '	"> Edit</a></td>
			<td align="left"><a href="password.php?id=' . $row['user_id'] . '	"> Delete</a></td>
		</tr>';
	}
	echo '</table>';
	mysqli_free_result ($results);
}
else
{
	echo '<p class="error">The current users could not be retrieved. We apologize for any inconvenience.</p>';
	echo '<p>' .mysqli_error($dbc) . '</br></br> Query: ' . $query . '</p>';
}
mysqli_close($dbc);
include 'includes/footer.html';
?>
