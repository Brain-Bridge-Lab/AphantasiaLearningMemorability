<html>
<?php
	// ?s are the indicators of PHP code!

	/* February 5, 2021
	By: Wilma Bainbridge

	This is the main change from Experiment 3 to Experiment 4. We now have a server that saves the data! This is the code that lets us upload data to the server. This is in a language called PHP that is very different from both Javascript and HTML. But it can also interact with both of them, as you can see some examples of here!
	*/

	// Here's the login data for your online database. Many web hosts have this as a feature and your university may allow it to! I personally use Ionos (though I have not tried other hosts so I cannot vouch for them either way). It allows me to create and maintain an unlimited number of MySQL databases on my web server. I then interact with it using this PHP script uploaded to my website.

	// Note: these will have to be changed if you create a new database on your server
	$host_name = "db5014156671.hosting-data.io";
	$database = "dbs11797020";
	$user_name = "dbu5436738";
	$password = "Tow3weld@";

	// Connect to the database
	$connect = mysqli_connect($host_name, $user_name, $password, $database);

	global $message;
	$message = "";

	// Check the connection, and return an error if there is an issue.
	if(mysqli_connect_errno()){
		$message = 'There was a connection error: ' . mysqli_connect_error();
	}

	// Clean up the data to prevent security risks.
	// Note: added 'ENT_QUOTES' here because quotes were breaking the code for some reason
	// Quotes get spitted out as '&#039;' 
	function testinput($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data, ENT_QUOTES);
		return $data;
	}

	// You can use this to get the IP address of your participant, if you want general location information
	function get_client_ip() {
        $ipaddress = '';
		// Essentially, different browsers have different syntax for IP address, so this is trying all of them.
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
	}

	// Now get all the values sent to us from example4.html!
	// This encompasses anything from an <input> tag and it's identifying it from what is under "name".


	// data
	$st = testinput($_POST["stimName"]);
	$re = testinput($_POST["reactionName"]);
	$an = testinput($_POST["answersName"]);
	$sm = testinput($_POST["stimMemName"]);
	$rem = testinput($_POST["responseMemName"]);
	$rm = testinput($_POST["reactionMemName"]);
	$tfm = testinput($_POST["trueFalseMemName"]);
		// Note: have to make osiq array into a string to see results on server

// Now this is the main line! This inserts the data into the database!
// The first set of items in () are the names of the columns in the MySQL database. While they are the same as the names of inputs from example4.html, this is just to keep the names consistent when analyzing the data -- they don't have to be the same! The second set of items (after VALUES) are the values we just extracted that we're uploading into each of the columns. We're essentially creating a new row in the database.
$sql = "INSERT INTO testTable (stimSequence,answerSequence,responseTimeSequence,memoryTestStim,memoryTestResponse,memoryTestReaction,memoryTestCorrect) VALUES ('$st','$an','$re','$sm','$rem','$rm','$tfm')";

// You can use PHP to interact with the webpage. It can also do things like work with variables, use logic, and do basic math. Here, if it successfully sends the data, it will post a thank you. If it doesn't, it will return an error.

// As a silly example, I will also have it return the participant's age and do simple math on it, so you can see how to integrate data between PHP and HTML.

if (mysqli_query($connect, $sql)){ // If successfully uploaded
	
	// You can write HTML code right into a String!
	$displayperformance = "<div style='font-family:helvetica;font-size:18px'>Your responses have been successfully submitted!<br><br>
	</div>";
} else{
	$displayperformance = "Error: " . $sql . "<br>" . mysqli_error($connect);
}

mysqli_close($connect); // Now close the connection

?>
<title>Experiment Complete</title>
<center>
<br><br>
<div style='font-family:helvetica;font-size:24px'>Thank you!</div>
<br><br>
<!-- Here is how that message is inserted from the PHP to the HTML! -->	
<p><?php echo $displayperformance ?></p>
</center>


</html>