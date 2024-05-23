<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tech-Nova</title>
  <meta name="description" content="cutting-edge IT solutions to businesses of all sizes" />
  <meta name="author" content="Thupten" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
<header class="header1">
    <nav class="nav-link" id="navbar">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="jobs.php">Jobs</a></li>
        <li><a href="apply.php">Apply</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="enhancements.php">Enhancements</a></li>
        <?php 

  if (isset($_SESSION['Admin']) && $_SESSION['Admin'] == 1) {
  echo '<li class="nav-item">
                <a class="nav-link active" href="./manage.php">Manage </a>
              </li>';
      }

//  <!-- login and logout  Fadded in and out -->
 if(isset($_SESSION['username'])){
              echo ' <li class="nav-item">
              <form action="./includes/logout.inc.php" method="POST">
              <button type="submit" class="btn w-100" style="background-color:#410099;color:white" name="logout-submit">Logout</button>
              </form>';
            }else{
             echo ' <li class="nav-item">
              <a  href="./login.php" >Login</a>
            </li>';
            }
           
    
     ?>
      </ul>
    </nav>
 
</header>
<!-- Dynamic Login Error Message -->
<main class="container mt-3" style="text-align:center; align-items:center; ">
    <?php
      // Check $_GET to see if we have any login error messages
      // NOTE: As with previous examples, will display appropriate error/success message in Bootstrap Alert 
      if(isset($_GET['loginerror'])){
        // (i) Empty fields in Login 
        if($_GET['loginerror'] == "emptyfields"){
          $errorMsg = "Please fill in all fields";

        // (ii) SQL Error
        } else if ($_GET['loginerror'] == "sqlerror"){
          $errorMsg = "Internal server error - please try again later";

        // (iii) Password does NOT match DB 
        } else if ($_GET['loginerror'] == "wrongpwd"){
          $errorMsg = "Wrong password";
          
        // (iv) uidUsers / emailUsers do not match
        } else if ($_GET['loginerror'] == "nouser"){
          $errorMsg = "The user does not exist";
        }
        // Display alert with dynamic error message
        echo '<div class="alert alert-danger mt-3" role="alert">'
          .$errorMsg.
        '</div>';

      // Display SUCCESS message for correct login!
      } else if (isset($_GET['login']) == "success"){
        echo '<div class="alert alert-success mt-3 " role="alert">
          You have successfully logged in.
        </div>';    
      }

      
    ?>
  </main>
  <!-- Error Message from GET: END -->
