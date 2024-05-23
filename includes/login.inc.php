<?php
session_start(); // Ensure the session is started
  // 1. Check user clicked submit button on Login Form
  if(isset($_POST['login-submit'])){

  // 2. Call connection class: mysqli
  require("./setting.php");

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // 3. Test connection success or error: connect_error
  if ($conn->connect_error) {
    // store the messsage in session to later display on login form if connection is success or failed
    echo '<div class="alert alert-warning mt-3" role="alert"; style="text-align: center;>Connection Failed</div>';
    header("Location: ../login.php?loginerror=connectionfailed");
    exit();
  } else {
    echo '<div class="alert alert-success mt-3" role="alert"; style="text-align: center;>Connection Successful</div>';
  }
  


    // 3. Collect & store the POST username + password in variables
    $email = $_POST['mailuid'];
    $password = $_POST['pwd'];

    // 4. Check username and password fields are not blank
    if(empty($email) || empty($password)){

      header("Location: ../login.php?loginerror=emptyfields"); 
      exit(); 
    
    } else {
     // SQL QUERY 1: FINDING USER TO PASS IN USERS
        //    1.Set our Query with PlaceHolders- ?
      $sql = "SELECT * FROM users WHERE username=? OR email=?"; 

        //    2. Initialising the prepare statement
        $statement = $conn->stmt_init();

  //    3. Prepare & send statement to database to check templet SQL      
        if(!$statement->prepare($sql)) {
                header("Location: ../login.php?loginerror=sqlerror"); 
                exit(); 
            } else {
        //    4.Bind statement with data

        $statement->bind_param("ss", $email, $email);

        //    5. Excute the sql with Data 
        $statement->execute();

        // 6. Return result & store variable
        $result = $statement->get_result();    
        
        // Test result for matching user 
       
        if($row = mysqli_fetch_assoc($result)){
          // This compares password passed in by user VS encrypted password in DB
          $hashedPwdFromDB = $row['password'];
          $pwdCheck = crypt($password, $hashedPwdFromDB) === $hashedPwdFromDB;


        // case 1: password is imcorrect
        if($pwdCheck == false){
            header("Location: ../login.php?loginerror=wrongpwd");
            exit(); 

          // (ii) User exists - Password match & init session
          } else if ($pwdCheck == true) {
            session_start();
            $_SESSION['username'] = $row['username']; // You can store any relevant user data in the session
            $_SESSION['Admin'] = $row['is_admin'];
            header("Location: ../index.php?login=success");

            exit();
          
          // (iii). Catch all for unexpected error (very remote!)
          } else {
            header("Location: ../login.php?loginerror=wrongpwd");
            exit(); 
          }
        
        // (iv). Error if no user was found in DB
        } else {
          header("Location: ../login.php?loginerror=nouser");
          exit(); 
        }
      }
    }
  // 7. We have to close this off - it relates back to our SUBMIT button CHECK
  } else {
    // If users try to access this file DIRECTLY - it REDIRECTS to signup page 
    header("Location: ../signup.php?loginerror=forbidden");
    exit();
  }

?>
 