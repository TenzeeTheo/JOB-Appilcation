<link rel="stylesheet" href="styles.css">

<div class="background">
    <div class="card">
    <form class="form" action="./includes/signup.inc.php" method="post">
    <h2>Create Account</h2>
    <!-- F. SIGNUP MESSAGES -->
    <?php 
      if(isset($_GET['error'])){
        // Message for emptyfeilds error
        if($_GET['error'] == "emptyfeilds"){
          $errorMsg =" Please fill in all feilds ";

        }else if ($_GET['error'] =='invaliduidmail'){
          $errorMsg =" Invalid Username and Password";
          
        }else if ($_GET['error'] =='invaliduid'){
          $errorMsg =" Invalid Username";

        }else if ($_GET['error'] =='invalidmail'){
          $errorMsg =" Invalid email";

        }else if ($_GET['error'] =='passwordcheck'){
          $errorMsg =" Passwords do not match";
          // New
        }else if ($_GET['error'] =='invalidpassword'){
          $errorMsg ="Passwords Must contain Minimum of 8 characters, one upper case, one special chars and Must have at least one number ";

        }else if ($_GET['error'] =='sqlerror'){
          $errorMsg =" You Must Sign Up to access this page";

        }else if ($_GET['error'] =='usertaken'){
          $errorMsg =" User Name Already Taken";

        }else if ($_GET['error'] =='forbidden'){
          $errorMsg =" Access Denied";
        }
        // GENERAL CATCH ALL
        echo ' <div class="alert alert-danger mt-3" role="alert"> '.$errorMsg.' </div>';


      }else if (isset($_GET['Account']) == "Created") {
        echo '<div class="alert alert-success mt-3" role="alert">You have successfully signed up!</div>';    
      }
      
      ?>

<!-- 1. USERNAME -->
<input type="text" class="form-control" name="uid" placeholder="Username" value=
                <?php
                if(isset($_GET['uid'])){
                echo  $_GET['uid'];
                }
                ?>
                >
            <!-- 2. EMAIL -->
            
                <input type="email" class="form-control" name="mail" placeholder="Email Address" value=
                <?php
                if(isset($_GET['mail'])){
                echo  $_GET['mail'];
                }
                ?>
                >
                   <!-- 3. PASSWORD -->
   
            <!-- 3. PASSWORD -->
                <input type="password" class="form-control" name="pwd" placeholder="Password">

            <!-- 4. PASSWORD CONFIRMATION -->
                <input type="password" class="form-control" name="pwd-repeat" placeholder="Confirm Password">
            
            <!-- 5. SUBMIT BUTTON -->
            <button type="submit" name="signup-submit" class="btn btn-primary w-100">Sign Up</button>
            <p>Existing users, <a href="./login.php">Log In Here</a></p>
            
            </form>
    </div>
</div>