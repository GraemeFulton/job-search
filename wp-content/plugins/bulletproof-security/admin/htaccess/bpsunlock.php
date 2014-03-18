<?php
// BulletProof Security Pro stand alone file
//
// Delete Login Security Database Rows based on Username / Unlock Locked User Accounts
/*
// This is the error that will occur if someone enters an incorrect DB Table Prefix:
// Warning: mysql_fetch_assoc() expects parameter 1 to be resource, boolean given in C:\xampp2\htdocs7\aitpro\arqdelete.php on line 69
*/

// Form - Delete the bpsunlock.php file
if ( isset($_POST['Self-Delete']) ) {
unlink($_SERVER["SCRIPT_FILENAME"]);
}
?>

<table width="100%" border="1" cellspacing="1" cellpadding="5" align="center">
  <tr>
    <td width="50%" align="center"><h1>Login Security Unlock User Account Form</h1></td>
    <td width="50%" align="center"><h1>Login Security Delete Password Reset Form</h1></td>
  </tr>
  <tr>
    <td>This form allows you to Unlock Locked User Accounts.</td>
    <td>If you are locked out of your website and have turned on Disable Password Reset use this form to allow Password Resets again on your website. <strong>NOTE:</strong> This form will delete all Login Security options. Please resave your Login Security options again after you have logged back into your website.</td>
  </tr>
  <tr>
    <td>Open your wp-config.php file to get your Database connection information below:</td>
    <td>Open your wp-config.php file to get your Database connection information below:</td>
  </tr>
  <tr>
    <td>Enter your DB Name, DB User, DB Password, DB Host and DB Table Prefix.</td>
    <td>Enter your DB Name, DB User, DB Password, DB Host and DB Table Prefix.</td>
  </tr>
  <tr>
    <td>Enter the Username for the User Account you want to unlock.</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>NOTE:</strong> If your DB Table Prefix is the standard wp_ DB Table Prefix in your wp-config.php file <strong>$table_prefix  = 'wp_';</strong><br />
then enter wp_ in the DB Table Prefix form field or enter the DB Table Prefix that you are using instead.</td>
    <td><strong>NOTE:</strong> If your DB Table Prefix is the standard wp_ DB Table Prefix in your wp-config.php file <strong>$table_prefix  = 'wp_';</strong><br />
then enter wp_ in the DB Table Prefix form field or enter the DB Table Prefix that you are using instead.</td>
  </tr>
  <tr>
    <td colspan="2" align="center" style="color:#0000FF;">
      
<?php
// Form - Delete Login Security Database Rows based on Username
if ( isset($_POST['Login-Security-Unlock']) ) {

	$DBHost = $_POST['dbhost'];
	$DBUser = $_POST['dbuser'];
	$DBPass = $_POST['dbpassword'];
	$DBName = $_POST['dbname'];
	$username = $_POST['username'];
	$LoginSecurity = $_POST['tableprefix'] . "bpspro_login_security";	

	$mysqli = new mysqli($DBHost, $DBUser, $DBPass, $DBName);

	/* check connection */
	if ( mysqli_connect_errno() ) {
    	printf("Connect failed: %s\n", mysqli_connect_error());
    //exit();
	}

	$query = "SELECT * FROM $LoginSecurity WHERE username = '$username'";

	if ( $result = $mysqli->query($query) ) {

		/* fetch associative array & delete the username Row from the Login Security DB Table */
    	while ( $row = $result->fetch_assoc() ) {
			$delete_query = "DELETE FROM $LoginSecurity WHERE username = '$username'";
		
			if ( $mysqli->query($delete_query) ) {       
		
				echo '<strong><font color="green">User Account: ';
				printf ("%s", $row["username"]);
    			echo '</font><font color="green"> Unlocked Successfully.</font></strong><br>';
				
			}
		}
	$result->free();
	}
	$mysqli->close();
}

// Form - Delete the Login Security Database Option
if ( isset($_POST['Login-Security-Delete-PWR']) ) {
	
	$DBHost = $_POST['dbhost'];
	$DBUser = $_POST['dbuser'];
	$DBPass = $_POST['dbpassword'];
	$DBName = $_POST['dbname'];
	$wp_options = $_POST['tableprefix'] . "options";	

	$mysqli = new mysqli($DBHost, $DBUser, $DBPass, $DBName);

	/* check connection */
	if ( mysqli_connect_errno() ) {
    	printf("Connect failed: %s\n", mysqli_connect_error());
    //exit();
	}

	$query = "SELECT * FROM $wp_options WHERE option_name = 'bulletproof_security_options_login_security'";

	if ( $result = $mysqli->query($query) ) {

		/* fetch associative array & delete BPS Login Security DB Option */
    	while ( $row = $result->fetch_assoc() ) {
			$delete_query = "DELETE FROM $wp_options WHERE option_name = 'bulletproof_security_options_login_security'";
		
			if ( $mysqli->query($delete_query) ) {       
		
				echo '<strong><font color="green">Database option_name: ';
				printf ("%s", $row["option_name"]);
    			echo '</font><font color="green"> Deleted Successfully.</font></strong><br>';
				
			}
		}
	$result->free();
	}
	$mysqli->close();	
}

?>
      
  <div style="margin:10px 0px 0px 0px;">
  <form action="" method="post">   
  <label for="SelfDelete"><strong>IMPORTANT!!! Delete this file after you are done using it by clicking the Delete bpsunlock.php File button below: </strong></label><br />
  <input type="submit" name="Self-Delete" value="Delete bpsunlock.php File" />    
  </form>
  </div>
      
    </td>
  </tr>
  <tr>
    <td align="center">	
    <form action="" method="post">
<table width="400" border="1" style="margin:10px 0px 10px 10px; background-color:#DBDBDB;">
  <tr>
    <td><label for="LSDBDelete"><strong>DB Name: </strong></label></td>
    <td><input type="text" name="dbname" value="" /></td>
  </tr>
  <tr>
    <td><label for="LSDBDelete"><strong>DB User: </strong></label></td>
    <td><input type="text" name="dbuser" value="" /></td>
  </tr>
  <tr>
    <td><label for="LSDBDelete"><strong>DB Password: </strong></label></td>
    <td><input type="password" name="dbpassword" value="" /></td>
  </tr>
  <tr>
    <td><label for="LSDBDelete"><strong>DB Host: </strong></label></td>
    <td><input type="text" name="dbhost" value="" /></td>
  </tr>
  <tr>
    <td><label for="LSDBDelete"><strong>DB Table Prefix: </strong></label></td>
    <td><input type="text" name="tableprefix" value="" /></td>
  </tr>
 <tr>
    <td><label for="LSDBDelete"><strong>User Account: </strong></label></td>
    <td><input type="text" name="username" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Login-Security-Unlock" value="Unlock User Account" /></td>
  </tr>
</table>
</form>
</td>
    <td align="center">
<form action="" method="post">
<table width="400" border="1" style="margin:10px 0px 10px 10px; background-color:#DBDBDB;">
  <tr>
    <td><label for="LSDBDelete"><strong>DB Name: </strong></label></td>
    <td><input type="text" name="dbname" value="" /></td>
  </tr>
  <tr>
    <td><label for="LSDBDelete"><strong>DB User: </strong></label></td>
    <td><input type="text" name="dbuser" value="" /></td>
  </tr>
  <tr>
    <td><label for="LSDBDelete"><strong>DB Password: </strong></label></td>
    <td><input type="password" name="dbpassword" value="" /></td>
  </tr>
  <tr>
    <td><label for="LSDBDelete"><strong>DB Host: </strong></label></td>
    <td><input type="text" name="dbhost" value="" /></td>
  </tr>
  <tr>
    <td><label for="LSDBDelete"><strong>DB Table Prefix: </strong></label></td>
    <td><input type="text" name="tableprefix" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Login-Security-Delete-PWR" value="Delete Password Reset Option" /></td>
  </tr>
</table>
</form>    
    </td>
  </tr>
</table>