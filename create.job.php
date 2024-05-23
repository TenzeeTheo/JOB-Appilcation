<!-- HEADER.PHP -->
<?php 
  require "templates/header.php"
?>


  <main class="container p-4 bg-light mt-3" style="width: 1000px">
        <!-- createrivew.inc.php - Will process the data from this form-->
  <form action="includes/createrivew.inc.php" method="POST">

      <h2>Create Rivew</h2>

       <!-- 1. TITLE -->
       <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" name="title" placeholder="Title" value="">
      </div>  

         <!-- 2. IMAGE URL -->
         <div class="mb-3">
        <label for="imageurl" class="form-label">Image URL</label>
        <input type="text" class="form-control" name="imageurl" placeholder="Image URL" value="" >
      </div>

      <!-- 3. COMMENT SECTION -->
      <div class="mb-3">
        <label for="comment" class="form-label">Story</label>
        <textarea class="form-control" name="comment" rows="3" placeholder="Story" ></textarea>
      </div>
         <!-- 4. WEBSITE URL -->
         <div class="mb-3">
        <label for="websiteurl" class="form-label">Website URL</label>
        <input type="text" class="form-control" name="websiteurl" placeholder="Website URL" value="" >
      </div>

      <!-- 5. WEBSITE TITLE -->
      <div class="mb-3">
        <label for="websitetitle" class="form-label">Website Title</label>
        <input type="text" class="form-control" name="websitetitle" placeholder="Website Title" value="" >
      </div>
    <!-- 5. Date & Time -->
      <div class="mb-3">
        <label for="Date & Time" class="form-label">Date & Time</label>
        <input type="datetime-local" class="form-control" name="DT"  value="" >
      </div>

      <!-- 6. SUBMIT BUTTON -->
      <button type="submit" name="post-submit" class="btn  w-100" style="background-color:#410099; color:white">Post</button>
    </form>
  </main>

<!-- FOOTER.PHP -->
<?php 
  require "templates/footer.php"
?>