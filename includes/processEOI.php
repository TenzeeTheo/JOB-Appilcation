<?php
session_start();
  // 1. Check user clicked submit button on Login Form
  if(isset($_POST['Apply-btn'])){

      
      // 2. Call connection class: mysqli
      require("setting.php");
      
      $conn = mysqli_connect($servername, $username, $password, $dbname);
      

// 3. Test connection success or error: connect_error

if($conn->connect_error) {
    $_SESSION["Connection-failed"] ="Connection Failed";
    echo '<div class="alert alert-warning mt-3" role="alert">Connection Failed</div>';
  die();
} else {
    echo'<div class="alert alert-success mt-3" role="alert">Connection Successful</div>';
}
   // Check if user is logged in
   if (!isset($_SESSION['username'])) {
    header("Location: ../login.php?error=notloggedin");
    exit();
}


    // Get username from session
    $username = $_SESSION['username'];

    // Fetch user ID based on username
    $sql = "SELECT id FROM users WHERE username = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("s", $username);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows === 0) {
        header("Location: ../login.php?error=nouser");
        exit();
    }
    // Function to validate the state and postcode match
    function validatePostcode($state, $postcode) {
        $postcode_states = array(
            "VIC" => "/^3\d{3}$/",
            "NSW" => "/^2\d{3}$/",
            "QLD" => "/^4\d{3}$/",
            "NT" => "/^08\d{2}$/",
            "WA" => "/^6\d{3}$/",
            "SA" => "/^5\d{3}$/",
            "TAS" => "/^7\d{3}$/",
            "ACT" => "/^02\d{2}$/"
        );
        return preg_match($postcode_states[$state], $postcode);
    }


    $user = $result->fetch_assoc();
    $user_id = $user['id'];

    // Sanitize and store form data in variables
    $jobReferenceNumber = mysqli_real_escape_string($conn, $_POST['JRnum']);
    $firstName = mysqli_real_escape_string($conn, $_POST['First-Name']);
    $lastName = mysqli_real_escape_string($conn, $_POST['Last-Name']);
    
    $birthDate = mysqli_real_escape_string($conn, $_POST['date']);
    $gender = mysqli_real_escape_string($conn, $_POST['Gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $suburb = mysqli_real_escape_string($conn, $_POST['suburb']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);

    $postcode = mysqli_real_escape_string($conn, $_POST['postcode']);

    // Collect skills from checkboxes
    $skill1 = isset($_POST['skills1']) ? 'HTML' : null;
    $skill2 = isset($_POST['skills2']) ? 'CSS' : null;
    $skill3 = isset($_POST['skills3']) ? 'JavaScript' : null;
    $skill4 = isset($_POST['skills4']) ? 'PHP' : null;

    // Sanitize and store other skills
    $otherSkills = mysqli_real_escape_string($conn, $_POST['otherSkills']);

 // 5. Check to see if fields are  blank

        if (empty($jobReferenceNumber) || empty($firstName) || empty($lastName) || empty($birthDate)|| empty($gender)|| empty ($phone) || empty($email) || empty($street)|| empty($suburb) || empty($state) || empty($postcode) ) {
            header("Location: ../apply.php?error=emptyfields");
            exit();
        }
    
    // Validate input
    // preg_match(pattern, subject, matches, flags, offset)
    // used to search a string for a specific pattern and determine if the pattern exists
    // within the string. If the pattern is found, the function returns tr

    if (!preg_match("/^(CSa45|SEz78|XYz45|ABc12)$/", $jobReferenceNumber)) {
        header("Location: ../apply.php?error=invalidjobReferenceNumber");
        exit();
    }
    if (!preg_match("/^[A-Za-z]{1,20}$/", $firstName)) {
        header("Location: ../apply.php?error=invalidFirst-Name");
        exit();
    }

    if (!preg_match("/^[A-Za-z]{1,20}$/", $lastName)) {
        header("Location: ../apply.php?error=invalidLast-Name");
        exit();
    }

    // New validation code for date of birth
    $dob_date = date_create_from_format('Y/m/d', $birthDate);

    // Perform validation for the submitted DOB
    if (!$dob_date || $dob_date->format('Y/m/d') !== $birthDate) {
        header("Location: ../apply.php?error=invalid-date");
        exit();
    } else {
        // Calculate age directly from the submitted DOB
        $today = new DateTime();
        $age = $today->diff($dob_date)->y;
        if ($age < 15 || $age > 80) {
            header("Location: ../apply.php?error=invalidage");
            exit();
        }
    }
 
    $validGenders = array("Male", "Female", "Other");
    if (!in_array($gender, $validGenders)) {
    }


    if (!preg_match("/^\d{8,12}$/", $phone)) {
        header("Location: ../apply.php?error=invalidphone");

    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../apply.php?error=invalidemail" .$email);
        exit();
    }

    if (!preg_match("/^[A-Za-z0-9\s]{5,40}$/", $street)) {
        header("Location: ../apply.php?error=invalidstreet" );

        exit();

    }

    if (!preg_match("/^[A-Za-z\s]{5,40}$/", $suburb)) {
        header("Location: ../apply.php?error=invalidsuburb");
        exit();
    }

    if (!in_array($state, ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'])) {
        header("Location: ../apply.php?error=invalidstate" );

        exit();
    }
        // Call validatePostcode() function to check if the postcode matches the state
    if (!validatePostcode($state, $postcode)) {
        header("Location: ../apply.php?error=invalidpostcodestate");
        exit();
    }


      // SQL to create applications table if it doesn't exist

      $sql = "CREATE TABLE IF NOT EXISTS applications (
      id INT AUTO_INCREMENT PRIMARY KEY,
        jobReferenceNumber VARCHAR(255),
        firstName VARCHAR(255),
        lastName VARCHAR(255),
        birth_date DATE,
        street VARCHAR(255),
        suburb VARCHAR(255),
        state VARCHAR(255),
        postcode VARCHAR(255),
        email VARCHAR(255),
        phone VARCHAR(255),
        skill1 VARCHAR(255),
        skill2 VARCHAR(255),
        skill3 VARCHAR(255),
        skill4 VARCHAR(255),
        other_skills TEXT,
        status ENUM('New', 'Current', 'Final') DEFAULT 'New'
        )";

    if (mysqli_query($conn, $sql)) {
        $_SESSION["Create-table"]=" Table called applications is created successfully or already exists";

    } else {
        echo "Error creating table: " . mysqli_error($conn) . "<br>";

    }
   
  // 1. Prepare Stament

   // SQL to insert form data into database
   $insertSql = "INSERT INTO applications (
    user_id, job_reference_number, first_name, last_name, birth_date, gender, phone, email, street, suburb, state, postcode, skill1, skill2, skill3, skill4, other_skills,
    status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,'New')";

    // Prepare and bind
    $statement = $conn->prepare($insertSql);
    $statement->bind_param("issssssssssssssss", $user_id, $jobReferenceNumber, $firstName, $lastName, $birthDate, $gender, $phone, $email, $street, $suburb, $state, $postcode, $skill1, $skill2, $skill3, $skill4, $otherSkills);

   // Execute statement and check for errors
   if ($statement->execute()) {
    header("Location: ../apply.php?success=submitted" );

} else {
    header("Location: ../apply.php?error=error");
}


} else {
header("Location: ../apply.php?error=forbidden");
exit();
}

