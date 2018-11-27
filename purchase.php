<!DOCTYPE html>
<html>
    <body>
	<h2>Purchase Ticket</h2>
	<form action="purchase.php" method="post">
	    Schedule Number: <input type="number" name="num"><br>
	    Price(Economy:$200 Business:$300 First-Class:$500): <input type="number" name="price"><br>
	    Account Number: <input type="number" name="an"><br>	    
	    Credit Card Number: <input type="number" name="ccn"><br>	    
	    <button type="submit" name="submit">Purchase</button><br>
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
	        $pdo = new PDO($dsn, $user, $pass, $opt);
	        $an = $_POST['an'];
	        $num = $_POST['num'];
		$ccn = $_POST['ccn'];
		$purchase = $_POST['submit'];
		$price = $_POST['price'];
		//check that submit button was clicked and handle errors
		if(isset($purchase)){ 
			//check if any of the input fields are empty
		   	if(empty($an) || empty($num) || empty($ccn)){ 
				echo 'ERROR: empty field(s)';
				exit();
			}else{ 
			   	//Check that the flight associated w/ the supplied sched./flight # exists
			   	$sql = "SELECT * FROM Flight WHERE flight_number='$num'";
				$res = $pdo->prepare($sql);
				$res->execute();
				if($res->rowCount()<0){ 
					echo "Invalid. Flight does not exist";
					exit();
				}else{ 
					$sql = null;
					$res = null;
				   	//verify account # 
				   	$sql = "SELECT * FROM Passenger WHERE account_num='$an'";
					$res = $pdo->prepare($sql);
					$res->execute();
					if($res->rowCount()<0){ 
					   echo 'Failed Authentication of account information';
				   	   exit();	   
					}else{ 
					   //verify credit card number
					   foreach($res as $row){ 
					      $credit_num=$row['credit_card_num'];
					      //echo "$credit_num";
					      if($credit_num == $ccn){ 
					      	echo 'ccn verified';
					      }else{ 
					      	echo 'invalid ccn';
						exit();
					      }
					   }
					   echo "Ticket for flight $num successfully purchased";
					   echo "<br>";
					   //provide link back to home page
					   //$link_address1 = 'home.html';
					   //echo "<a href='$link_address1'>List users</a>";
					}
				}
			//	$sql = null;
			//	$res = null;

			}
			/*
			//no errors present
			//insert the provided information
			$sql = "INSERT INTO Ticket (schedule_num,Price,account_num,Gate_Number) VALUES ('$num','$price','$an','$ccn')";
		        $res = $pdo->prepare($sql);
		        $res->execute();	       
			$sql = null;
			$res = null;
			*/
			exit();
	        }
	    } catch (\PDOException $e){ 
	    	$error_message = $e->getMessage();
		echo "<tr><td>", $error_message, "</td></td>\n";
	    } 
	    ?>
    </body>
</html>
