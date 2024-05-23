<?php
  // 2. Start session
  // NOTE: We need to start the session as we can not end it if it not started.  As we are only starting it on the header.php we need to add it here as we are not using the header.
  session_start();

  // 3. Take all session values in $_SESSION variable and removes them
  session_unset(); 

  // 4. End session
  session_destroy();

  // 5. Send user back to the home page
  header("Location: ../index.php");

  // 6. Now we go back to header.php to ONLY show Logout button if we have an active session!

?>