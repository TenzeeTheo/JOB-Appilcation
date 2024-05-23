<?php
require("./includes/header.inc");

// Check if the user is logged in and is an admin
session_start();
if (!isset($_SESSION['Admin']) || $_SESSION['Admin'] != 1) {
    // If not logged in or not an admin, redirect to login page
    header("Location: login.php");
    exit(); // Stop script execution after redirection
}

// Include database connection settings
require("./includes/setting.php");
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Test connection success or error
if ($conn->connect_error) {
    $_SESSION['message'] = '<div class="alert alert-warning mt-3" role="alert">Connection Failed</div>';
    header("Location: ../login.php?loginerror=connectionfailed");
    exit();
} else {
    $_SESSION['message'] = '<div class="alert alert-success mt-3" role="alert">Connection Successful</div>';
}

// Function to list all applications
function listAllApplications($conn) {
    $sql = "SELECT * FROM applications";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Query failed: " . mysqli_error($conn);
    }
    return $result;
}

// Function to list applications by position
function listApplicationsByPosition($conn, $jobReferenceNumber) {
    $jobReferenceNumber = mysqli_real_escape_string($conn, $jobReferenceNumber);
    $sql = "SELECT * FROM applications WHERE job_reference_number = '$jobReferenceNumber'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Query failed: " . mysqli_error($conn);
        return false; 
    }
    return $result;
}

// Function to list applications by applicant
function listApplicationsByApplicant($conn, $firstName, $lastName) {
    $firstName = mysqli_real_escape_string($conn, $firstName);
    $lastName = mysqli_real_escape_string($conn, $lastName);
    $sql = "SELECT * FROM applications WHERE first_name LIKE '%$firstName%' AND last_name LIKE '%$lastName%'";
    echo "Debug: SQL Query: $sql"; // Print SQL query for debugging
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        return false;
    }
    return $result;
}

// Function to delete applications by job reference number
function deleteApplicationsByJobReferenceNumber($conn, $jobReferenceNumber) {
    $jobReferenceNumber = mysqli_real_escape_string($conn, $jobReferenceNumber);
    $sql = "DELETE FROM applications WHERE job_reference_number = '$jobReferenceNumber'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_affected_rows($conn) > 0) {
        echo "Query failed: " . mysqli_error($conn);
    }
    return $result;
}

// Function to change the status of an application
function changeApplicationStatus($conn, $id, $Status) {
    $id = (int)$id;
    $Status = mysqli_real_escape_string($conn, $Status);
    $sql = "UPDATE applications SET status = '$Status' WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        // Log the MySQL error for debugging
        error_log("MySQL Error: " . mysqli_error($conn));
        return false; // Return false to indicate failure
    }

    return true; // Return true if the update was successful
}
// Check if form is submitted for listing EOIs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = false; // Initialize result to false to capture errors

    // Check which query to perform
    if (isset($_POST['list_all'])) {
        $result = listAllApplications($conn);

    } elseif (isset($_POST['list_by_position'])) {
        $jobReferenceNumber = $_POST['job_reference_number'];
        if (!empty($jobReferenceNumber)) {
            $result = listApplicationsByPosition($conn, $jobReferenceNumber);
        } else {
            $_SESSION['message'] = '<div class="alert alert-warning mt-3" role="alert">Job Reference Number is required.</div>';
        }

    } elseif (isset($_POST['list_by_applicant'])) {
        if (!empty($_POST['first_name']) && !empty($_POST['last_name'])) {
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $result = listApplicationsByApplicant($conn, $firstName, $lastName);
        } else {
            $_SESSION['message'] = '<div class="alert alert-warning mt-3" role="alert">Both First Name and Last Name are required.</div>';
        }

    } elseif (isset($_POST['delete_by_position'])) {
        $jobReferenceNumber = $_POST['delete_job_reference_number'];
        if (!empty($jobReferenceNumber)) {
            $result = deleteApplicationsByJobReferenceNumber($conn, $jobReferenceNumber);
        } else {
            $_SESSION['message'] = '<div class="alert alert-warning mt-3" role="alert">Job Reference Number is required for deletion.</div>';
        }

    } elseif (isset($_POST['change_status'])) {
        $id = $_POST['id'];
        $Status = $_POST['status'];
        if (!empty($id) && !empty($Status)) {
            $result = changeApplicationStatus($conn, $id, $Status);
            // Check if the status was changed successfully
            if ($result) {
                $_SESSION['message'] = '<div class="alert alert-success mt-3" role="alert">Application status changed successfully.</div>';
            } else {
                $_SESSION['message'] = '<div class="alert alert-danger mt-3" role="alert">Error: Unable to change application status.</div>';
            }
        } else {
            $_SESSION['message'] = '<div class="alert alert-warning mt-3" role="alert">Both Application ID and Status are required.</div>';
        }
    }
}
?>
<!-- <link rel="stylesheet" href="style.css"> -->

<!-- HTML form to list all applications -->
<form method="post">
    <input type="submit" name="list_all" value="List All Applications">
</form>

<!-- HTML form to list applications by position -->
<form method="post">
    <input type="text" name="job_reference_number" placeholder="Job Reference Number">
    <input type="submit" name="list_by_position" value="List Job Reference Number">
</form>

<!-- HTML form to list applications by applicant -->
<form method="post">
    <input type="text" name="first_name" placeholder="First Name">
    <input type="text" name="last_name" placeholder="Last Name">
    <input type="submit" name="list_by_applicant" value="List Applications by Applicant">
</form>

<!-- HTML form to delete applications by position -->
<form method="post">
    <input type="text" name="delete_job_reference_number" placeholder="Job Reference Number">
    <input type="submit" name="delete_by_position" value="Delete Applications by Position">
</form>

<!-- HTML form to change application status -->
<form method="post">
    <input type="text" name="id" placeholder="Application ID">
    <select name="status">
        <option value="" disabled>Please Select</option>
        <option value="New" selected>New</option>
        <option value="Current">Current</option>
        <option value="Final">Final</option>
    </select>
    <input type="submit" name="change_status" value="Change Application Status">
</form>

<?php
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message once displayed
}
if (isset($result)) {
    if ($result === true) {
        echo "<div class='alert alert-danger mt-3' role='alert'>An unexpected result type was received.</div>";
    } elseif ($result instanceof mysqli_result) {
        echo "<h2>Results:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Job Reference Number</th><th>First Name</th><th>Last Name</th><th>Status</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['job_reference_number'] . "</td>";
            echo "<td>" . $row['first_name'] . "</td>";
            echo "<td>" . $row['last_name'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='alert alert-danger mt-3' role='alert'>An unexpected result type was received.</div>";
        // You can also print or log the actual result to debug further
        var_dump($result);
    }
} else {
    echo "<div class='alert alert-danger mt-3' role='alert'>No result found.</div>";
}

?>
