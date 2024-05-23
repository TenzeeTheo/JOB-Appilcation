<?php
require "includes/header.inc" 
?>
<style> 
.container{
  width: max-content;
}
</style>
<main class="container" style="text-align: center; width:max-content; align-items:center">
<!-- /* Check $_GET to see if we have any application error messages  */ -->
<?php 
if(isset($_GET['error'])){
    $errorMsg = "";
    switch($_GET['error']){
        // Empty fields in application
        case "emptyfields":
            $errorMsg = "Please fill in all fields";
            break;
        // Invalid job reference number
        case "invalidjobReferenceNumber":
            $errorMsg = "Invalid job reference number only accept (CSa45|SEz78|XYz45|ABc12)";
            break;
        // Invalid first name
        case "invalidFirst-Name":
            $errorMsg = "Invalid first name";
            break;
        // Invalid last name
        case "invalidLast-Name":
            $errorMsg = "Invalid last name";
            break;
        // Invalid date
        case "invalid-date":
            $errorMsg = "Invalid birth date";
            break;
        // Invalid date
        case "invalidage":
            $errorMsg = "You are either too young (15) or too old (80) ";
            break;
        // Invalid phone number
        case "invalidphone":
            $errorMsg = "Invalid phone number";
            break;
        // Invalid email
        case "invalidemail":
            $errorMsg = "Invalid email address";
            break;
        // Invalid street
        case "invalidstreet":
            $errorMsg = "Invalid street address";
            break;
        // Invalid suburb
        case "invalidsuburb":
            $errorMsg = "Invalid suburb";
            break;
        // Invalid state
        case "invalidpostcodestate":
            $errorMsg = "Invalid State";
            break;
        // Invalid postcode
        case "invalidpostcodestate":
            $errorMsg = "Invalid Post Code";
            break;
        // Any other unspecified error
        default:
            $errorMsg = "An error occurred";
            break;
    }
    // Display alert with dynamic error message
    echo '<div class="alert alert-danger mt-3" role="alert">'
        .$errorMsg.
        '</div>';
}
// Check if there is a success message
if(isset($_GET['success']) && $_GET['success'] === "submitted") {
  // Display success message
  echo '<div class="alert alert-success mt-3" role="alert">
        Application submitted successfully!.
      </div>';
}
?>

</main>
<link rel="stylesheet" href="style.css">


<main class="Apply-container">
  <section class="JobApply">
    <figure class="Job-Banner">
      <img src="./src/image/join.png" alt="Picture that says we are hiring">
    </figure>
    <h1 class="ApplicationHeader">Employment Application</h1>
    <p>Fill the form below accurately indicating your potentials and suitability to job applying for.</p>
    <hr>
    <form action="./includes/processEOI.php" method="POST" novalidate="novalidate">
      <fieldset>
        <legend>Personal Details</legend>
        <label for="JRnum" class="Textlabel">Job reference number</label>
        <input type="text" name="JRnum" id="JRnum" >
      


        <label for="First-Name" class="Textlabel">First Name:</label>
        <input type="text" name="First-Name" id="First-Name">
     
        
        <label for="Last-Name" class="Textlabel">Last Name:</label>
        <input type="text" name="Last-Name" id="Last-Name" >
   
        <label for="date" class="Textlabel"> Birth Date</label>
        <input type="text" name="date" id="date" placeholder="yyyy/mm/dd" >
        

        <br><br>

        <label for="male" class="Textlabel">Male</label>
        <input type="radio" id="male" name="Gender" value="Male">

        <label for="female" class="Textlabel">Female</label>
        <input type="radio" id="female" name="Gender" value="Female">

        <label for="other" class="Textlabel">Other</label>
        <input type="radio" id="other" name="Gender" value="Other">

      </fieldset>

      <br><br>
      <label for="phone" class="Textlabel">Phone number</label>
      <input type="text" name="phone" id="phone" required="required" >
      <br><br>
      <label for="email" class="Textlabel">Email address</label>
      <input type="text" name="email" id="email" required="required" >
      <br> <br>
      <fieldset>
        <legend>Address</legend>
        <label for="street" class="Textlabel">Street Address</label>
        <input type="text" name="street" id="street" required="required">

        <label for="suburb" class="Textlabel">Suburb/Town</label>
        <input type="text" name="suburb" id="suburb" required="required">

        <label for="state" class="Textlabel">State</label>
        <select name="state" id="state" required="required" class="State">
          <option value="">Please Select</option>
          <option value="VIC">VIC</option>
          <option value="NSW">NSW</option>
          <option value="QLD">QLD</option>
          <option value="NT">NT</option>
          <option value="WA">WA</option>
          <option value="SA">SA</option>
          <option value="TAS">TAS</option>
          <option value="ACT">ACT</option>
        </select>
        <br><br>
        <label for="postcode" class="Textlabel">Postcode</label>
        <input type="text" name="postcode" id="postcode" >
      </fieldset>
      <br><br>
      <fieldset>
        <legend class="Textlabel">Skills</legend>
        <br>
        <input type="checkbox" id="skills1" name="skills1" value="Html">
        <label for="skills1" class="SkillsOption">Html</label><br>

        <input type="checkbox" id="skills2" name="skills2" value="Css">
        <label for="skills2" class="SkillsOption">Css</label><br>

        <input type="checkbox" id="skills3" name="skills3" value="Java Script">
        <label for="skills3" class="SkillsOption">Java Script</label><br>

        <input type="checkbox" id="skills4" name="skills4" value="PhP">
        <label for="skills4" class="SkillsOption">PhP</label><br><br>

        <label for="otherSkills" class="Textlabel">Other Skills:</label>
        <textarea id="otherSkills" name="otherSkills" class="otherSkills" placeholder="Other Skills I Have..."></textarea>
      </fieldset>

      <figure class="container">
        <button class="Apply-btn" name="Apply-btn">
          <img src="./styles/image/button.svg" alt="Send Icon">
          <span>Submit Application</span>
        </button>

      </figure>



    </form>
  </section>
</main>
<?php require "includes/footer.inc" ?>