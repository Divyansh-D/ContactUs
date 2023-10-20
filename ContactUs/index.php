<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ContactUs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Contact Us</h1>
    <?php
    if(isset($_SESSION['message'])){
      echo "<h4 class='alert alert-seccess'>".$_SESSION['message']."</h4>";
      unset($_SESSION['message']);
    }
    ?>
    <form action="code.php" method="POST" autocomplete="off" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="Name" class="form-label">Name</label>
        <input type="name" name="uname" class="form-control" id="name" placeholder="Enter your name" required>
      </div>
      <div class="mb-3">
        <label for="Email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" aria-describedby="emailHelp" required>
      </div>
      <div class="mb-3">
        <label for="file" class="form-label">Upload file</label>
        <input type="file" name="image" id="up" required/>
      </div>
      <div class="mb-3">
        <label for="desc" class="form-label">Description</label>
        <textarea class="form-control" name="desc" id="desc" placeholder="Enter description" cols="25" rows="5" required></textarea>
      </div>
      <div>
      <input type="submit" name="btns" value="Submit" class="btn btn-info">
      </div>
    </form>
    </div>
    <script>
    </script>
  </body>
</html>