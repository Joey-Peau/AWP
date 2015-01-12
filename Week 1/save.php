<?php
$host = 'mysql.metropolia.fi';
$dbname = 'joeyp';
$user = 'joeyp';
$pass = 'Joy1788150c';

// TODO: get the data from the form by using $_POST
// this is how you convert the date from the form to SQL formatted date:
// date ("Y-m-d H:i:s", strtotime(dataFromDateField.' '.dataFromTimeField));

// this part was in dbConnect.php in last period:
try {

	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
	$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$DBH->query("SET NAMES 'UTF8';");

} catch (PDOException $e) {

	echo "Could not connect to database.";
	file_put_contents('log.txt', $e->getMessage(), FILE_APPEND);
}

try {
	var_dump($_POST);
	$name = $_POST["name"];
	$desc = $_POST["desc"];
	$email = $_POST["email"];
	$cell = $_POST["cell"];
	$datetime = date("Y-m-d H:i:s", strtotime($_POST["date"] . " " . $_POST["time"]));
	$res = $DBH->prepare("INSERT INTO calendar (eName, eDescription, pEmail, pPhone, eDate)
		VALUES ('" . $name . "', '" . $desc . "', '" . $email . "', '" . $cell . "', '" . $datetime . "')");
	$res->execute();

} catch (PDOException $e) {
	echo 'Something went wrong';
	file_put_contents('log.txt', $e->getMessage() . "\n\r", FILE_APPEND); // remember to set the permissions so that log.txt can be created
}
?>
