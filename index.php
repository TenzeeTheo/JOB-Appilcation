<?php
require "includes/header.inc";

// Initialize the welcome message
$welcomeMessage = "";

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Check if the user is an admin
      if (isset($_SESSION['Admin']) && $_SESSION['Admin'] == 1) {
        $welcomeMessage = " Welcome, Admin " .$_SESSION['username'];
        // Redirect to admin dashboard or perform admin actions
    } else {
      $welcomeMessage = "Welcome, " .  $_SESSION['username'];
        // Redirect to regular user dashboard or perform user actions
    }
} 
?>
<?php
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']); // message display here 
}
?>
<link rel="stylesheet" href="style.css">
  <!-- Welcome message for logged in users -->
  <div class="alert alert-success mt-3" role="alert" style="text-align: center;">
    <?php echo $welcomeMessage; ?>
  </div>

<main>
  <section class="main-bg">
    <div class="textcontainer">

      <h1>Welcome To Tech-Nova</h1>
    </div>
  </section>
  <article class="grid-container">
    <figure id="item1" class="item">
      <h2>Welcome to Tech Nova</h2>
      <p>At TechNova, we are committed to revolutionizing the way businesses operate in the digital age. Our team of skilled professionals is dedicated to providing innovative IT services that propel your organization towards success. With a focus on delivering cutting-edge solutions, TechNova collaborates closely with clients to understand their unique needs and challenges, offering tailored strategies that drive efficiency, productivity, and growth.</p>
      <p>TechNova can help startups improve their online presence, assist growing businesses with software needs, and enhance cybersecurity for companies. They focus on making customers happy and have a history of successful projects, showing they're dedicated to providing great service.</p>
    </figure>
    <figure id="item2" class="item">
      <img src="./src/image/com.avif" alt="apple laptop">
    </figure>
    <figure id="item3" class="item">
      <img src="./src/image/cyber-pre.jpeg" alt="picture represent of cloud storage">
    </figure>
    <figure id="item4" class="item">
      <h2>Why Choose Tech-Nova?</h2>

      <ul>
        <li>Web Development: Custom websites for your business.</li>
        <li>Software Development: Efficient software solutions.</li>
        <li>Cybersecurity: Protecting your digital assets.</li>
        <li>Cloud Services: Flexible and scalable cloud solutions.</li>
        <li>Experienced Professionals: Skilled IT experts with industry experience. </li>
        <li>Innovative Solutions: Stay updated for cutting-edge solutions.</li>
        <li>Customer-Centric Approach: Your satisfaction is our priority.</li>
        <li> Proven Track Record: Successful projects and satisfied clients.</li>
      </ul>

    </figure>
    <figure id="item5" class="item">
      <h3>The power of our team and technology</h3>
      <p>Are you passionate about technology and looking for exciting career opportunities? TechNova is always on the lookout for talented infigureiduals to join our dynamic team. Explore our current job openings and take the next step in your IT career with TechNova.</p>
      <a href="./apply.php" class="btn">Join Our Team TechNova</a>
    </figure>
    <figure id="item6" class="item">
      <img src="./src/image/join.webp" alt="pic of two people">
    </figure>
  </article>
  <p class="demonstration"><a class="demonstation" href="https://youtu.be/sBg6tmbi9Tw?si=WQqtoml7WCGpMsI-">Demonstration Video</a></p>
</main>

<?php require "includes/footer.inc" ?>

