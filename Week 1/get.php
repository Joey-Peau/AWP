<div id="accordion">
<?php
include "../../config.php";

try {
	$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
	$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$DBH->query("SET NAMES 'UTF8';");

} catch (PDOException $e) {
	echo "Could not connect to database.";
	file_put_contents('log.txt', $e->getMessage(), FILE_APPEND);
}

try {
	$eventList = array();
	$sql = "SELECT * FROM calendar";
	$STH = $DBH->query($sql);
	$STH->setFetchMode(PDO::FETCH_OBJ);
	while ($row = $STH->fetch()) {
		echo '<h3>' . $row->eDate . '<br><strong>' . $row->eName . '</strong></h3><div><i>' . $row->eDescription . '</i><br><br>With:<br>' . $row->pEmail . '<br>' . $row->pPhone . '</div>';
	}
} catch (PDOException $e) {
	echo 'Something went wrong';
	file_put_contents('log.txt', $e->getMessage() . "\n\r", FILE_APPEND); // remember to set the permissions so that log.txt can be created
}

?>
</div>
<script>
   $(function() {
    $( "#accordion" ).accordion({
        collapsible: true,
        active: "none"
    });
});
</script>
