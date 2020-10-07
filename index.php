<?php
 session_start();
 
 include_once 'database.php';
 
 /*Setting var $message empty */
 $message = "";
  
   if (isset($_POST['login_form'])){
      /*Getting the message from database.php */
      $message = $_SESSION['message'];
         
      $username = $_POST['username'];
      $pwd = $_POST['pwd'];
      
      /* Creating instance */
      $persoon = new DB("localhost", "root", "", "project1", "utf8mb4");
        
      $persoon->login($username, $pwd); 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title> 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!--Custom Styles -->
    <link rel="stylesheet" href="assets/styles/style.css">
    <style>
    .alert{
      z-index:2;
      position: absolute;
      left: 50%;
      top: 15%;
      -webkit-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      margin: 10px 5px;
    }
    </style>
</head>
<body>
<?php echo $message; ?>
  <div class="form-box">
    <form class="form form-login" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="form-title">
          <h1>Login</h1>
        </div>
        <div class="form-group">
            <label>Gebruikersnaam</label>
            <input type="text" name="username" class="form-control" required />
        </div>
        <div class="form-group">
            <label>Wachtwoord</label>
            <input type="password" name="pwd" class="form-control" required />
        </div>
        <div class="ww-forgot">
           <a href="lostpsw.php">Wachtwoord Vergeten?</a>
        </div>
        <div class="form-btn-submit-box">
            <input type="submit" class="btn btn-primary btn-submit" name="login_form" value="Bevestigen"/>
        </div>
        <div class="form-btn-register">
           Geen lid? <a href="signup.php">Registreren</a>
        </div>
    </form>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>

