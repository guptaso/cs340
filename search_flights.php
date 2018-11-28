<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<style>
table,tr,td{
  padding: 15px;
  text-align: left;
  border-collapse: collapse;
  border: 1px solid black;

}
</style>
<html>
<body style="background-image:url(http://web.engr.oregonstate.edu/~sunamotl/braden-jarvis-383867-unsplash.jpg)">
  <h1> Seach Flights </h1>
  <div id="searchBar" class="searchBar">
    <h2 id="searchBarHead"> Enter Search Criteria </h2>
    <!--<form name = "fill-in" id="fill-in">-->
    <form method = "post" action="search_flights.php">
      <table id="UserFillTable">
        <style>
        #UserFillTable {
          border-style: hidden;
        }
        #UserFillTable td,tr {
          border: 0;
        }
        </style>
        <tr>
          <td><label for="field_one">Airline Name</label></td>
          <td><input id="field_one" name="field_one" type="text"> </td>
        </tr>
        <tr>
          <td><label for="field_two">Departure Location</label></td>
          <td><input id="field_two" name="field_two" type="text"> </td>
        </tr>
        <!--<tr>
          <td><label for="field_three">Arrival Location</label></td>
          <td><input id="field_three" name="field_three" type="text"></td>
        </tr> -->
        <tr>
          <td> <input type='submit' name="submit" value="Search" onclick="EraseTable()"></td>
        </tr>
      </table>
    </form>
  </div>

  <script type="text/javascript">
  function EraseTable() {
    var table = document.getElementById("displayResultsTable");
    for (var i = 1, row; row=table.rows[i]; i++) {
        table.deleteRow(i);
    }
  }
  </script>

  <!-- lists all the flights by default, otherwise filtered -->
  <h3> Results: </h3>
  <table id="displayResultsTable" border="1">
    <tr>
      <td><b>Airline Name</b></td>
      <td><b>Flight Number</b></td>
      <td><b>Capacity</b></td>
      <td><b>Seats Available</b></td>
      <td><b>Departure Location</b></td>
      <td><b>Arrival Location</b></td>
      <!--<td><b>Purchase</b></td>-->
    </tr>

  <?php
  $pass = '9839';
  $host = 'classmysql.engr.oregonstate.edu';
  $db = 'cs340_guptaso';
  $user = 'cs340_guptaso';
  $charset = 'utf8mb4';
  // specify the database using a DSN string
  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
  $opt= [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ];

  try {
    // construct a database access object of class PDO
    $pdo = new PDO($dsn, $user, $pass, $opt);
  } catch (PDOException $e) {
    $error_message = $e->getMessage();
  }


  // fetch all rows of data from Flight table
  $sql = 'SELECT flight_number, capacity, passenger_count, airline_name from Flight';
  // run the sql query
  $res = $pdo->query($sql);
  // iterate through the rows that are returned
  // for each row in the result-set, print a row in the HTML table

/*

*/
  // gets the name argument from the form
  /*if( isset($_POST["submit"])){
    if($_POST['field_one']) {
      $searched_name = $_POST['field_one'];
      $sql2 = "SELECT airline_name, flight_number, capacity, passenger_count FROM Flight WHERE airline_name='{$_POST['field_one']}'";
      $res2 = $pdo->query($sql2);
      foreach ($res2 as $row) {
        $flightNum= $row['flight_number'];
        // gets how many seats are available
        $passengers2 = $row['passenger_count'];
        $cap2 = $row['capacity'];
        $available2 = $cap2 - $passengers2;
        $sql3 = "SELECT Departure_Location, Arrival_Location, flight_number FROM Flight_Schedule WHERE flight_number=$flightNum";
        $res3 = $pdo->query($sql3);
        foreach ($res3 as $row3) {
          // displays results in the table
          echo "<tr><td>", $row['airline_name'], "</td>",
               "<td>", $row['flight_number'], "</td>",
               "<td>", $row['capacity'], "</td>",
               "<td>", $available2, "</td>",
               "<td>", $row3['Departure_Location'], "</td>",
               "<td>", $row3['Arrival_Location'], "</td></tr>\n";
        }
      }
    }
  }*/
  if (isset($_POST['submit'])){
    $searched_name = $_POST['field_one'];
    $departure_loc = $_POST['field_two'];
    if(($_POST['field_one']) && ($_POST['field_two'])) {
      $sql2 = "SELECT * FROM Flight INNER JOIN Flight_Schedule ON `Flight`.`flight_number`=`Flight_Schedule`.`flight_number` WHERE `Flight`.`airline_name`='$searched_name' AND `Flight_Schedule`.`Departure_Location`='$departure_loc'";
    }
    elseif (($_POST['field_one']) && (!($_POST['field_two']))) {
      $sql2 = "SELECT * FROM Flight INNER JOIN Flight_Schedule ON `Flight`.`flight_number`=`Flight_Schedule`.`flight_number` WHERE `Flight`.`airline_name`='{$_POST['field_one']}'";
    }
    elseif ((!($_POST['field_one'])) && ($_POST['field_two'])) {
      //$sql2 = "SELECT * FROM Flight_Schedule INNER JOIN Flight ON `Flight_Schedule`.`flight_number`=`Flight`.`flight_number` WHERE `Flight_Schedule`.`Departure_Location`=`{$_POST['field_two']}`";
      $sql2 = "SELECT * FROM Flight INNER JOIN Flight_Schedule ON `Flight`.`flight_number`=`Flight_Schedule`.`flight_number` WHERE `Flight_Schedule`.`Departure_Location`='{$_POST['field_two']}'";

    }
    $res2 = $pdo->query($sql2);
    foreach ($res2 as $row) {
      $passengers2 = $row['passenger_count'];
      $cap2 = $row['capacity'];
      $available2 = $cap2 - $passengers2;
      echo "<tr><td>", $row['airline_name'], "</td>",
             "<td>", $row['flight_number'], "</td>",
             "<td>", $row['capacity'], "</td>",
             "<td>", $available2, "</td>",
             "<td>", $row['Departure_Location'], "</td>",
             "<td>", $row['Arrival_Location'], "</td></tr>\n";

    }
  }

  ?>
  </table>

  <h3> All Available Flights: </h3>
  <table>
    <tr>
      <td><b>Airline Name</b></td>
      <td><b>Flight Number</b></td>
      <td><b>Capacity</b></td>
      <td><b>Seats Available</b></td>
      <td><b>Departure Location</b></td>
      <td><b>Arrival Location</b></td>
      <!--<td><b>Purchase</b></td>-->
    </tr>
    <?php
    $pass = '9839';
    $host = 'classmysql.engr.oregonstate.edu';
    $db = 'cs340_guptaso';
    $user = 'cs340_guptaso';
    $charset = 'utf8mb4';
    // specify the database using a DSN string
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt= [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
      // construct a database access object of class PDO
      $pdo = new PDO($dsn, $user, $pass, $opt);
    } catch (PDOException $e) {
      $error_message = $e->getMessage();
    }

    $sql = 'SELECT flight_number, capacity, passenger_count, airline_name from Flight';
    $res = $pdo->query($sql);
    foreach ($res as $row) {
      $flightNum= $row['flight_number'];
      $passenger = $row['passenger_count'];
      $capac = $row['capacity'];
      $av = $capac - $passenger;
      $sql2 = "SELECT Departure_Location, Arrival_Location, flight_number FROM Flight_Schedule WHERE flight_number=$flightNum";
      $res2 = $pdo->query($sql2);
      foreach ($res2 as $row2) {
        // displays results in the table
        echo "<tr><td>", $row['airline_name'], "</td>",
             "<td>", $row['flight_number'], "</td>",
             "<td>", $row['capacity'], "</td>",
             "<td>", $av, "</td>",
             "<td>", $row2['Departure_Location'], "</td>",
             "<td>", $row2['Arrival_Location'], "</td></tr>\n";
      }
    }

     ?>
  </table>

</body>
</html>
