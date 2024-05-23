<?php require "includes/header.inc" ?>
<link rel="stylesheet" href="style.css">


<main id="Enhancements">
  <h1>Enhancements</h1>

  <section>
    <h2>1. Responsive Design</h2>
    <p>Description: Implemented responsive design across the entire website, ensuring optimal display on various screen sizes and devices.</p>
    <p>Beyond Basic Requirements: The website layout and content dynamically adjust based on the user's device, providing a seamless browsing experience.</p>
    <p>Implementation: CSS media queries for responsiveness</p>
    <p>Third-party Reference: <a href="https://www.w3schools.com/css/css_rwd_mediaqueries.asp">W3Schools Responsive Web Design</a></p>
    <p>Implementation Link: <a href="./apply.html">Example of Responsive Design</a></p>
    <img src="./styles/image/demo.png" id="demo-img" alt="picture of our website showing in small screen" />
  </section>

  <section>
    <h2> 2. Dynamic Background Animation</h2>
    <p>Description: The index page features a captivating animation effect in the background, creating a dynamic and visually appealing backdrop for the content. The animation seamlessly transitions through different background positions, enhancing the overall user experience and adding a touch of modernity to the design.
    </p>
    <p>Beyond Basic Requirements: The animation's timing and movement are carefully crafted to complement the page's content without overwhelming the user. This enhancement not only improves visual aesthetics but also creates an interactive element that captures user attention.
    </p>

    <p>Implementation: The animation is achieved using CSS animations and transitions, leveraging keyframes to control the background movement and positioning. The effect is further enhanced by utilizing background images and text clipping to create a unique visual experience.
    </p>
    <p>Third-party Reference: <a href="https://www.w3schools.com/css/css3_animations.asp">W3Schools CSS Animations</a>
    </p>
    <p>Implementation Link: <a href="index.html">Example of Responsive Design</a></p>
    <section class="main-bg">
      <div class="textcontainer">

        <h1>Demo </h1>
      </div>
    </section>
  </section>

  <section>
    <h2>3. Button with Fancy Hover effect</h2>

    <p>Description: This enhancement adds a fancy hover effect to a button on the Apply page, improving the visual appeal and interactivity of the button.</p>
    <p>Beyond Basic Requirements: The hover effect includes animations and transitions that make the button visually engaging and intuitive to use, enhancing the user experience.</p>
    <p>Implementation: The button is styled using CSS and have a transition effect for smooth hover and click interactions. Additionally, the button contains an icon that animates and scales upon hover, providing a dynamic and interactive experience for users.</p>
    <p>Third-party Reference: <a href="https://www.w3schools.com/tags/tag_button.asp">W3Schools CSS Animations</a>
    </p>
    <p>Implementation Link: <a href="apply.html">Example of Button with Fancy Hover effect </a></p>
    <figure class="container">
      <button class="Apply-btn">
        <img src="./styles/image/button.svg" alt="Send Icon">
        <span>Submit Application</span>
      </button>

    </figure>


  </section>
</main>

<?php
include('./includes/footer.inc')
?>
