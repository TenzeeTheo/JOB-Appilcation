
<link rel="stylesheet" href="styles.css">

<div class="background">
<div class="card">
  <form action="./includes/login.inc.php" class="login-form" method="POST">
    <div class="login-card">
      <h2 style="text-align: center;">Log In</h2>
      <h6 style="text-align: center;">Enter your credentials</h6>
      <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="mailuid" placeholder="Email Address">
      <input type="password" class="form-control" id="password" name="pwd" placeholder="Password">
      <div class="button-container">
        <a href="./signup.php" style="text-align: center;">Don't have an account? Create an account here.</a><br>
        <button type="submit" class="btn btn-primary w-100" name="login-submit">Log In</button>
      </div>
    </div>
  </form>
</div>
</div>
