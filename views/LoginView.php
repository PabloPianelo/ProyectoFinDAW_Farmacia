<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css/login.css">
    <title>LoginPage</title>
    <?php include_once("common/login_header.php"); ?>   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<div class="image-container">
    
  </div>
  <div class="login-box">
    <h2>Login</h2>
    <form action="index.php">
    <input type="hidden" name="controlador" value="login">

		<input type="hidden" name="accion" value="login">


      <div class="user-box">
        <input type="text" name="username" >
        <label>Username</label>
      </div>
      <div class="user-box">
        <input type="password" name="password" >
        <label>Password</label>
      </div>
      <input type="submit" name="Login" value="Login">
    </form>
  </div>
</body>
<footer>
<?php include("common/footer.php"); ?>
</footer>
</html>