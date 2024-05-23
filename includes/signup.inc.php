<?php
if(isset($_POST['signup-submit'])){
    // coonection to db

  // 2. Call connection class: mysqli
  require("./setting.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

// 3. Test connection success or error: connect_error

if($conn->connect_error) {
  echo'<div class="alert alert-warning mt-3" role="alert"; style="text-align: center; margin-top:30px;>Connection Failed</div>';
  die();
} else {
  echo '<div class="alert alert-success mt-3" role="alert"; style="text-align: center; margin-top:30px;>Connection Successful</div>';
}


    // SQL to create users table if it doesn't exist

    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        is_admin TINYINT(1) DEFAULT 0
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Table users created successfully or already exists<br>";
    } else {
        echo "Error creating table: " . mysqli_error($conn) . "<br>";
    }

    // store submitted form data in variables

    $username = $_POST["uid"];
    $email = $_POST["mail"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];
    $pwdReg = "/^(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/";


    // Validation 

    // 1. check for empty form feild 

    if(empty($username)|| empty($email)|| empty($password)|| empty($passwordRepeat)){
        // redirect 
        header("Location: ../signup.php?error=emptyfeilds&uid=".$username ."&mail=".$email);
        exit();
    }
        // 2. Test for both invalid username & email
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !filter_var($email, 
    FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invaliduidmail");
        exit();

    }
        // 3. Test for invalid username 
    else if (!preg_match("/^[a-zA-Z0-9\s]*$/", $username)){
        header("Location: ../signup.php?error=invaliduid&mail=" .$email);
        exit();

    }
        // 4. Test for invaill email

    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: ../signup.php?error=invalidmail&uid=" .$username);
        exit();
        
    }
    // NEW: Password pattern
    // RULE 1: Minimum of 8 characters
    // RULE 2: Must have at least one upper case char
    // RULE 3: Must have at least one symbol/ special chars
    // RULE 4: Must have at least one number
    else if(!preg_match( $pwdReg,$password)){
    header("Location: ../signup.php?error=invalidpassword&uid=" .$username."&mail" .$email);
    exit();
        // 5. check to see if password != passwordRepeat

    }else if($password !== $passwordRepeat){
        header("Location: ../signup.php?error=passwordcheck&uid=".$username ."&mail=".$email);
        exit();
    }
    // Success condition we can query our DB
    else{
        // PREPARE STATEMENTS: MOST IMPORTANT FOR "WRITE" QUERIES: ADDING , UPDATING ,DELETING

    // Databse Query 1 checking for Existing User 

        //    1.Set our Query with PlaceHolders- ?
        $sql = "SELECT * FROM users WHERE username=?;";

        //    2. Initialising the prepare statement
    $statement = mysqli_stmt_init($conn);

        //    3. Prepare & send statement to database to check templet SQL
    if (!mysqli_stmt_prepare($statement,$sql)){
        header("Location: ../signup.php?error=sqlerror");
        exit();
    }
    else{
        //    4.Bind statement with data
        mysqli_stmt_bind_param($statement, "s", $username);

        //    5. Excute the sql with Data 
        mysqli_stmt_execute($statement);

        // 6. Return result & store
        mysqli_stmt_store_result($statement);

        // Register Test - Duplicate User
        $resultCheck = mysqli_stmt_num_rows($statement);
        if($resultCheck > 0){
            header("Location: ../signup.php?error=usertaken&mail=" .$email);
        exit();

        }
        
    }
    // Databse Query 2 Save User to Databse

        //    1.Set our Query with PlaceHolders- ?
        // $sql = "INSERT INTO users(uidUsers, emailUsers, pwd) VALUES (?, ?, ?);";
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?);";


        //    2. Initialising the prepare statement
        $statement = mysqli_stmt_init($conn);

        //    3. Prepare & send statement to database to check templet SQL
        if (!mysqli_stmt_prepare($statement,$sql)){
        header("Location: ../signup.php?error=sqlerror");
        exit();
    }
        //    4.Bind statement with data
        // Encryption: Hash
        $hashPwd =crypt($password, `salt`);
        mysqli_stmt_bind_param($statement,"sss",$username,$email,$hashPwd);

        //    5. Excute the sql with Data 
        mysqli_stmt_execute($statement);

        // Success
        header("Location: ../signup.php?Account=Created");
        exit();

    }

// mannual method to close the statement & Connection 
mysqli_stmt_close($statement);
mysqli_close($conn);

}else{
    header("Location: ../signup.php?error=forbidden");
    exit();
}

 ?>