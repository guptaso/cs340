<!DOCTYPE html>
<html>
<body style="background-image:url(http://web.engr.oregonstate.edu/~sunamotl/braden-jarvis-383867-unsplash.jpg)">
	<h2>Purchase Ticket</h2>
	<form action="purchase.php" method="post">
	    Flight Number: <input type="number" name="num"><br>
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
			   	$sql = "SELECT * FROM Flight_Schedule WHERE schedule_num='$num'";
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
					      if($credit_num == $ccn){ 
					      	//verify purchase price option
						 if($price == 200){ 
					   		echo "<h3>"."Thank you! Economy ticket for flight $num successfully purchased."."</h3>";
					   		echo "<br>";
						 }else if($price == 300){ 
					   		echo "<h3>"."Thank you! Business ticket for flight $num successfully purchased."."</h3>";
					   		echo "<br>";
						 }else if($price == 500){ 
					   		echo "<h3>"."Thank you! First-Class ticket for flight $num successfully purchased."."</h3>";
					   		echo "<br>";
						 }else{ 
						 	echo "invalid price entered";
							exit();
						 }
					      }else{ 
					      	echo 'invalid credit card number';
						exit();
					      }
					   }
					   //provide link back to home page
					   $link_address1 = 'home.php';
					   echo "<a href='$link_address1'>Return to Home</a>";
					}
				}

			}
			//no errors present
			//get gate number: schedule/flight #555:B6 and #999:#G22
			if($num == 555){ 
			   	$gate = B6;
			}else{ 
				$gate = G22;
			}
			//insert the provided information, ticket_ID is auto. incremented
			$sql = "INSERT INTO Ticket (schedule_num,Price,account_num,Gate_Number) VALUES ('$num','$price','$an','$gate')";
		        $res = $pdo->prepare($sql);
		        $res->execute();	       
			$sql = null;
			$res = null;
			
			//update Flight table by incrementing passenger_count column
			//for specific flight purchased which is $num
			//get flight number using schedule number
			$sql = "SELECT * FROM Flight_Schedule WHERE schedule_num = '$num'"; 
		        $res = $pdo->prepare($sql);
		        $res->execute();	       
			foreach($res as $row){ 		
			   	$flight = $row["flight_number"];     
				//get number of passengers from Flight table
				$sql2 = "SELECT * FROM Flight WHERE flight_number='$flight'";
			        $res2 = $pdo->prepare($sql2);
				$res2->execute();
		      		foreach($res2 as $row2){ 		
				   $passengers=$row2["passenger_count"];
				   $passengers = $passengers + 1;
				   $sql3 = "UPDATE Flight SET passenger_count = '$passengers' WHERE flight_number = '$flight'";
			           $res3 = $pdo->prepare($sql3);
				   $res3->execute();
				}
			}

			//NULLify all queries
			$sql = null;
			$res = null;
			$row = null;
			$sql2 = null;
			$res2 = null;	
			$row2 = null;
			$sql3 = null;
			$res3 = null;
			
			exit();
	        }
	    } catch (\PDOException $e){ 
	    	$error_message = $e->getMessage();
		echo "<tr><td>", $error_message, "</td></td>\n";
	    } 
	    ?>
    </body>
</html>
