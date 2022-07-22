<?php
/* make sure your can access your database and have created the
table to capture these data before doing this exercise.

The demoform.html web form calls this script.
*/

/* *******************************************
	GET THE VARIABLES FROM THE END-USER
	- in this example, I used the tab to line up the variables.
******************************************** */
$salutation	= $_POST["salutation"];
$name			= $_POST["username"];
$email		= $_POST["email"];
$program		= $_POST["program"];
$comments	= $_POST["comments"];

/* *******************************************
Before continuing, let's send data back to the end-user
to create an html page in the user's browser.  All the data
and error messages are going to be sent back to the browser
 so we should make it value html.
********************************************* */
/* echo "<!DOCTYPE html><html><head><title>Program Confirmation</title>"
	 "</head>\n<body>";
*/
/* NOTICE WE CAN HARD CODE THE HEADER (above) OR USE A FILE (below) */
echo file_get_contents("demoheader.txt");

echo "Variables from the form<ul>
	<li>$salutation</li>
	<li>$name</li>
	<li>$email</li>
	<li>$program</li>
	<li>$comments</li></ul>";

/* let's store the data in a flat file using PHP */

/* *******************************************
first create a variable ($dataToSave) to hold all the data.
the next line concatenates the variables from the end-user's form
and creates one giant string of data ... that string is stored
in a single variable, called $dataTosave

Notice we can mix-and-match: spaces, html tags, and data from the form
******************************************** */
$dataToSave = $salutation . " " . $name . " " . $email . " " . $program;
$dataToSave = $dataToSave . "\n<p>$comments</p><hr />";

echo "<p>For debugging only: $dataToSave</p>";

/* *******************************************
we save the data to a file - appending the data
******************************************** */
echo file_put_contents("demoprogramfile.txt", $dataToSave, FILE_APPEND);
echo "<br />";

/* *******************************************
Now let's insert the data in a relational database table
// http://www.w3schools.com/PHP/php_mysql_connect.asp
******************************************** */

/* *******************************************
Need to tell SQL where to save the data
******************************************** */
/* THE DATA ARE NOW STORED IN A config.ini FILE -
USING AN .INI FILE MAKES IT EASY TO DEVELOP AND THEN
DISTRIBUTE PROGRAMS */

$config = parse_ini_file("config.ini");
// notice the "parse_ini_file" parses the config file and stores the values in
// an array.  Then we use the array for database access.

/* *******************************************
Make a connection between the web server and the database server
******************************************** */
$conn = new mysqli('dany.simmons.edu', $config['username'], $config['password'],$config['dbname']);

/* *******************************************
Check that we have our connection; if so, continue,
else stop running the program (that's the "die()" command)
******************************************** */
echo "<br />";
if ($conn->connect_error) {
	die("Sorry, the connection could not be made: " . $conn->connect_error);
}
echo "Okay, we are connected to the db.<br />";


/* *******************************************
If we're okay to proceed, let's create the command that SQL can
understand by integrating the SQL parts and the data from the
end-user into the INSERT statement
******************************************** */

// Save the data in your table (demotable)
// First prepare an SQL command
$sql = "INSERT INTO demotable (sault, patronName, patronEmail, programChoice, patronComments) VALUES ('".$salutation."','". $name."','". $email."','". $program."','". $comments."')";

// Now let's use that command
/* *******************************************
Now let's use that command.  If the record is inserted over
the connection ($conn->query($sql)) and a new record is
created, SQL returns a boolean value TRUE.
If true, we tell the user new record, else an error
******************************************** */

if ($conn->query($sql) === TRUE) {
	echo  "New Record for " . $dataToSave;
} else {
	echo "Sorry, there was an error " .$sql . $conn->error;
}

/* *******************************************
Let's test our database, too, by issuing a SELECT statement
to pull the data back out of the database table.
We'll recycle the $sql variable ...
Pay -very- close attention to the single and double quotes.
******************************************** */
$sql = "SELECT * FROM demotable WHERE patronName = '" . $name . "'";

/* *****************************************
We issue the command ($sql) and store the results from the table
in a variable, called $result
******************************************** */
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// if we have > 0 rows, it means we have successful search
	while ($row = $result->fetch_assoc()) {
		echo "record number " . $row["recno"]. " - Name: " .
		$row["patronName"]. " " . $row["patronEmail"] . " " .
		$row["programChoice"] . " " . $row["patronComments"] . "<br />";
	}
} else {
	echo "Sorry, no records.";
}

// Close the connection to the DB
$conn->close();

/* ********************************************
We're all done with the database part.  Let's confirm the file
we wrote, too.
********************************************** */
echo "<p>Here we confirm the file we created above.</p>";

/* ********************************************
First let's make sure the file exists!
********************************************** */
if (file_exists("demoprogramfile.txt")) {
	echo file_get_contents("demoprogramfile.txt");
} else {
	echo "Sorry, the demoprogramfile does not exist or access permission denied.";
}

/* *****************************************
We're all done!  let's close out the webpage.
******************************************* */
// echo "</body></html>";

echo file_get_contents("demofooter.txt");

/* **** and close the php file **** */
?>
