<html>
<body>
  <h1> Seach Flights </h1>
  <div id="searchBar" class="searchBar">
    <h2 id="searchBarHead"> Enter Search Criteria </h2>
    <!--<form name = "fill-in" id="fill-in">-->
    <form method = "post" action="search_flights.php">
      <table id="UserFillTable">
        <tr>
          <td><label for="field_one">Name</label></td>
          <td><input id="field_one" name="field_one" type="text"> </td>
        </tr>
        <tr>
          <td> <input type='submit' name='submit' value="Search"/>
            <!-- not doing what I want it to -->
          <input type='hidden' value=null/> </td>
        </tr>
      </table>
    </form>
  </div>


  <!-- lists all the flights by default, otherwise filtered -->
  <h3> Results: </h3>
  <table border="1">
    <tr>
      <td><b>Airline Name</b></td>
      <td><b>Flight Number</b></td>
      <td><b>Capacity</b></td>
      <td><b>Passenger Count</b></td>
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
  foreach ($res as $row) {
    // for each row in the result-set, print a row in the HTML table
    echo "<tr><td>", $row['airline_name'], "</td>",
         "<td>", $row['flight_number'], "</td>",
         "<td>", $row['capacity'], "</td>",
         "<td>", $row['passenger_count'], "</td></tr>\n";
  }

  // gets the name argument from the form
  if(isset($_POST['submit'])){
    echo $_POST['field_one'];
    if($_POST['field_one']) {
      $searched_name = $_POST['field_one'];
      echo "Searching for the name: " .$searched_name;
      $sql2 = "SELECT airline_name, flight_number, capacity, passenger_count FROM Flight WHERE airline_name='{$_POST[field_one]}'";
      $res2 = $pdo->query($sql2);
      foreach ($res2 as $row) {
        echo "<tr><td>", $row['airline_name'], "</td>",
             "<td>", $row['flight_number'], "</td>",
             "<td>", $row['capacity'], "</td>",
             "<td>", $row['passenger_count'], "</td></tr>\n";
      }
    }
  }

  ?>
  </table>


</body>
</html>
