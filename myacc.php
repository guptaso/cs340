<style>
#updateButton {
  position: relative;
  bottom: -500px;
}
#updateInfoForm {
  position: relative;
}
</style>

<script type="text/javascript">
  function updateInfo() {

  }
</script>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
  table,th,td{
    padding: 15px;
	  text-align:left;
  	border-collapse:collapse;
  	border: 1px solid black;
  }
</style>
</head>
<body>
  <section class="main-container">
    <div class="main-wrapper">
      <h2>My Account</h2>
      <form class="account_form" action="myacc.php" method="post">
        <input type="number" name="user" placeholder="Account Number"><br>
        <button type="submit" name="submit">Submit</button><br>
      </form>
    </div>
  </section>
  <table id=updateInfoTable>
    <form method="post" action="myacc.php" id="updateInfoForm">
      <input type="text" name="firstNewName" placeholder="First Name">
      <input type="text" name="lastNewName" placeholder="Last Name">
    </form>
  </table>
  <button id="updateButton" type="button" onclick="updateInfo()">Update Information</button>

  <?php
  $host = 'classmysql.engr.oregonstate.edu';
	$user = 'cs340_guptaso';
	$db = 'cs340_guptaso';
	$charset = 'utf8mb4';
	$pass = '9839';
	//define the database source name for accessing MariaDB
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$opt = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
	];

	try {
    $userN = $_POST['user'];
	  $submit = $_POST['submit'];

	  //check if the submit button was clicked
	  if(isset($submit)){
      $pdo = new PDO($dsn, $user, $pass, $opt);
      //Authenticate user's provide account number
	    $sql = $pdo->query("SELECT * FROM Passenger WHERE account_num='$userN'");
		  if($sql->rowCount() == 0){
        echo 'Failed to Authenticate Account Number';
		    exit();
		  }
      else{
        foreach($sql as $row){
			  echo "<br>";
			  echo "<h3>"."Hello ".$row["name"]."!"."</h3>";
        }
      }
      $sql = null;

      //Output all the tickets associated with the validated account #
  		$sql2 = $pdo->query("SELECT * FROM Ticket WHERE account_num='$userN'");
  		echo "<table><tr><th>Schedule Number</th><th>Price</th><th>Ticket ID</th><th>Account Number</th><th>Gate Number</th></tr>";

      //foreach($sql2 as $row2){
		  while($row2 = $sql2->fetch(PDO::FETCH_ASSOC)){
        //echo 'in for loop';
      	echo "<tr>";
  			echo "<td>".$row2["schedule_num"]."</td>";
  			echo "<td>"."$".$row2["Price"]."</td>";
  			echo "<td>".$row2["Ticket_ID"]."</td>";
  			echo "<td>".$row2["account_num"]."</td>";
  			echo "<td>".$row2["Gate_Number"]."</td>";
  			echo "</tr>";
      }
      echo "</table>";
  		exit();
  		//$sql2 = null;
    }
  } catch (\PDOException $e){
    $error_message = $e->getMessage();
		echo "<tr><td>", $error_message, "</td></td>\n";
  }
	    ?>

    </body>


    </html>
