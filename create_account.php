<html>
<header>
  <h1> Create an Account </h1>
</header>

<body style="background-image:url(http://web.engr.oregonstate.edu/~sunamotl/braden-jarvis-383867-unsplash.jpg)">
  <h2> Enter Your Information </h2>
  <form method = "post" action="">
    <table id="CreateAccountTable">
      <tr>
        <td><label for="field_one">First Name</label></td>
        <td><input id="field_one" name="field_one" type="text"> </td>
      </tr>
      <tr>
        <td><label for="field_two">Last Name</label></td>
        <td><input id="field_two" name="field_two" type="text"> </td>
      </tr>
      <tr>
        <td><label for="field_three">Credit Card Number</label></td>
        <td><input id="field_three" name="field_three" type="number"></td>
      </tr>
      <tr>
        <td><input type="submit" name="submit" value="Search"/> </td>
      </tr>

    </table>
  </form>

  <?php
  $pass = '9839';
  $host = 'classmysql.engr.oregonstate.edu';
  $db = 'cs340_guptaso';
  $user = 'cs340_guptaso';
  $charset = 'utf8mb4';
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

  $inputFieldsArgs = filter_input_array(INPUT_POST);
  $error_message="";
  // when the user hits the submit button
  $submit = $inputFieldsArgs['submit'];
  //if (! empty($submit)) {
  if (isset($_POST['submit'])) {
    // check that all the fields are filled
    // checks that the first name is entered
    if (empty($inputFieldsArgs['field_one'])) {
      $error_message .= 'first name field is empty';
    }
    // checks that the last name is entered
    if (empty($inputFieldsArgs['field_two'])) {
      if (! empty($error_message)) {
        $error_message .= '; ';
      }
      $error_message .= 'last name field is empty';
    }
    // checks that the credit card number is entered
    if (empty($inputFieldsArgs['field_three'])) {
      if (! empty($error_message)) {
        $error_message .= '; ';
      }
      $error_message .= 'Credit Number field is empty';
    }
    // if there is an empty field, display the error message
    if(! empty($error_message)) {
      echo $error_message;
    }
    /* else there is no empty field, and so check if credit card number is
        already in use, there can be more than 1 person with the same name
    */
    else {
      $credit_card_num = $inputFieldsArgs['field_three'];
      $sql_searchCard = 'SELECT COUNT(*) FROM Passenger WHERE credit_card_num = :credit_card_num';
      try {
        $stmt = $pdo->prepare($sql_searchCard);
        $stmt->execute(['credit_card_num'=>$credit_card_num]);
        $previous_match = $stmt->fetchColumn();
      } catch (PDOException $e) {
        $error_message = $e->getMessage();
      }
    }
    // if there were no errors when searching the database
    if (empty($error_message)) {
      // if there was a match found in the database
      if ($previous_match > 0) {
        $error_message .= "credit card " . $credit_card_num . "is already taken";
      }
      // else no match was found and so add into the database
      else {
        // assigns variables to the inputs
        $username = $inputFieldsArgs['field_one'];
        $username .= ' ';
        $username .= $inputFieldsArgs['field_two'];
        $found = 0;
        $credit_card_num = $inputFieldsArgs['field_three'];

        // generates a random, unique account number between 1000 and 9999
        while ($found == 0) {
          $tempNum = (rand(1000, 9999));
          try {
            // checks if the random account number is in the database
            $sql_uniqueCard = "SELECT COUNT(*) FROM Passenger WHERE account_num=$tempNum";
            $res = $pdo->query($sql_uniqueCard);
            // if the account number is not in the db, it is unique
            if (! $res->fetchColumn() > 0) {
              $found = 1;
            }
          } catch (PDOException $e) {
            $error_message = $e->getMessage();
          }
        }
        // adds the account to the database
        try {
          $sql_insert = "INSERT INTO Passenger (account_num, name, credit_card_num) VALUES (?, ?, ?)";
          $pdo->prepare($sql_insert)->execute([$tempNum, $username, $credit_card_num]);
        } catch (PDOException $e) {
          $error_message = $e->getMessage();
        }
        // displays the error message if any
        if (! empty($error_message)) {
          echo $error_message;
        }
        else {
          echo "user added";
        }
      }
    }
    echo $error_message;
    //echo "<meta http-equiv='refresh' content='0'>";
  }
  ?>

</body>
</html>
