<?php
  include_once 'database.php'; 

  /* Checking if the form is succesfully submitted */
  if (isset($_POST['register_form'])){
      $voornaam = ucwords($_POST['fname']);
      $tussenvoegsel = $_POST['tussenvoegsel'];
      $achternaam = ucwords($_POST['lname']);
      $username = $_POST['username'];
      $email = $_POST['email'];
      $pwd = $_POST['pwd'];
      $pwd_repeat = $_POST['repeat-pwd'];

      $persoon = new DB("localhost","root","","project1","utf8mb4");
      
      /* If password and repeat password are the same, data will be sended to the database */
      if ($pwd === $pwd_repeat) {
          $persoon->register_insert($voornaam, $tussenvoegsel, $achternaam, $email, $pwd, $username);
      }else {
        echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Password is not the same' .'</div>';
      } 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <!--Custom Styles -->
    <link rel="stylesheet" href="assets/styles/style.css">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
    .alert{
        z-index:2;
        position: absolute;
        left: 50%;
        top: 2%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        margin: 10px 5px;
      }
    </style>
</head>
<body>
    <div class="form-box">
        <form class="form form-register" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-title">
            <h1>Signup</h1>
            </div>
            <div class="form-group">
                <label >Voornaam</label>
                <input type="text" name="fname" class="form-control" required />
            </div>
            <div class="form-group">
                <label >Tussenvoegsel</label>
                <input type="text"  name="tussenvoegsel" class="form-control"/>
            </div>
            <div class="form-group">
                <label >Achternaam</label>
                <input type="text"  name="lname" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required/>
            </div>
            <div class="form-group">
                <label>Gebruikersnaam</label>
                <input type="text" name="username" class="form-control"  required/>
            </div>
            <div class="form-group">
                <label>Wachtwoord</label>
                <input type="password" name="pwd" class="form-control" required />
            </div>
            <div class="form-group">
                <label >Herhaal Wachtwoord</label>
                <input type="password" name="repeat-pwd" class="form-control" required />
            </div>
            <div class="form-btn-submit-box">
                <input type="submit" class="btn btn-primary btn-register" name="register_form" value="Bevestigen"/>
            </div>
        </form>
    </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>   
</body>
</html>