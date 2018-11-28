<style>
#updateButton {
  position: relative;
  bottom: -490px;
}
#updateInfoForm {
  position: relative;

}
#NewName{
  position: relative;
  bottom: -470px;
  margin: 3px;
  margin-left: 0px;
}
#removeAccountNum{
  position: relative;
  bottom: -540px;
}
#removeButton{
  position: relative;
  bottom: -580px;
  left: -165px;
}
</style>



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
<body style="background-image:url(http://web.engr.oregonstate.edu/~sunamotl/braden-jarvis-383867-unsplash.jpg)">
  <section class="main-container">
    <div class="main-wrapper">
      <h2>My Account</h2>
      <form class="account_form" action="myacc.php" method="post">
        <input type="number" name="user" placeholder="Account Number"><br>
        <button type="submit" name="submit" >Submit</button><br>
      </form>
    </div>
  </section>
  <table id=updateInfoTable>
    <form method="post" action="myacc.php" >
      <input type="text" id="NewName" id="firstNewName" name="firstNewName" placeholder="New First Name">
      <input type="text" id="NewName" id="lastNewName" name="lastNewName" placeholder="New Last Name">
      <input type="text" id="NewName" id="verifyAcctNum" name="verifyAcctNum" placeholder="Verify Acct. Number">
      <button id="updateButton" name="updateButton" type="updateButton" >Update Information</button>
    </form>
  </table>
  <form method="post" action="myacc.php">
    <input type="text" id="removeAccountNum" name="removeAccountNum" placeholder="Verify Acct. Number">
    <button id="removeButton" name="removeButton" type="removeButton">Delete Account</button>
  </form>

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
	  if(isset($_POST['submit'])){
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
    if(isset($_POST['updateButton'])) {
      if (($_POST['firstNewName']) || ($_POST['lastNewName'])) {
        if (! ($_POST['verifyAcctNum'])) {
          echo "Please verify your account number";
        }
        $pdo = new PDO($dsn, $user, $pass, $opt);
        $num = ($_POST['verifyAcctNum']);

        $sql = $pdo->query("SELECT name, account_num FROM Passenger WHERE account_num='$num'");
        if($sql->rowCount() == 0) {
          echo "ERROR: couldn't locate account number";
          exit();
        }
        else {
          foreach ($sql as $row) {
            $array = $row['name'];
            $arr = explode(' ',trim($array));
            if (($_POST['firstNewName'])) {
              $first = ($_POST['firstNewName']);
            } else {
              $first = $arr[0];
            }
            if (($_POST['lastNewName'])) {
              $last = ($_POST['lastNewName']);
            } else {
              $last = $arr[1];
            }
            $newName= $first;
            $newName.=' ';
            $newName.=$last;
            $sql2 = $pdo->query("UPDATE `Passenger` SET `name` = '$newName' WHERE `Passenger`.`account_num` = '$num'");
            echo "Account name updated successfully";
          }
         }
      }
      else {
        echo "Please enter new first and/or last name";
      }
    }
    if(isset($_POST['removeButton'])) {
      if (($_POST['removeAccountNum'])) {
        $pdo = new PDO($dsn, $user, $pass, $opt);
        $num = ($_POST['removeAccountNum']);
        $sql = $pdo->query("SELECT name, account_num FROM Passenger WHERE account_num='$num'");
        if($sql->rowCount() == 0) {
          echo "ERROR: couldn't locate account number";
          exit();
        }
        else {
          foreach ($sql as $row) {
            $sql2 = $pdo->query("DELETE FROM `Ticket` WHERE `Ticket`.`account_num` = '$num'");
            $sql3 = $pdo->query("DELETE FROM `Passenger` WHERE `Passenger`.`account_num` = '$num'");

            echo "Account (along with tickets associated w/ account) deleted successfully";
          }
        }
      }
      else {
        echo "Please enter account number of account you'd like to delete";
      }
    }
  } catch (\PDOException $e){
    $error_message = $e->getMessage();
		echo "<tr><td>", $error_message, "</td></td>\n";
  }
?>
</body>
</html>
