<div id="calendar">
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
     $sql = "SELECT * FROM calendar ORDER BY eDate ASC";
     $STH = $DBH->query($sql);
     $STH->setFetchMode(PDO::FETCH_OBJ);
     while ($row = $STH->fetch()) {
		// create standard object which complies with this: http://fullcalendar.io/docs/event_data/Event_Object/
      $event = new stdClass();
      $event->start = $row->eDate;
      $event->title = $row->eName;
      $event->description = $row->eDescription . "\nContact Tel : ". $row->pPhone . "\nContact Mail : ".$row->pEmail;
      $eventList[] = $event;
  }
  $eventsJSON = json_encode($eventList);
} catch (PDOException $e) {
 echo 'Something went wrong';
	file_put_contents('log.txt', $e->getMessage() . "\n\r", FILE_APPEND); // remember to set the permissions so that log.txt can be created
}

?>
</div>
<script>
// JSON made in PHP is saved in JavaScript
var jsonEvents = <?php echo $eventsJSON;?>;
console.log(jsonEvents);

$('#calendar').fullCalendar({
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
    defaultView: 'month',
    timeFormat: 'H(:mm)',
    events : jsonEvents,
    eventClick: function(calEvent, jsEvent, view) {
        var text ="";
        text += "Event : " + calEvent.title + "\n";
        text += "Time : " + calEvent.start.format('MMMM Do YYYY, h:mm:ss a') + "\n";
        text += "Description : " + calEvent.description + "\n";

        alert(text);

    }
});
</script>
