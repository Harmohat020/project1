<?php 
include_once '../database.php'; 

session_start();

$type = $_SESSION['type'];

if (isset($_SESSION['username']) AND $type === 'Admin'){
    $row = $_SESSION['admin_row'];
}else{
    header("Location: ..\index.php");
}

 /* Checking if the form is succesfully submitted */
 if (isset($_POST['register_form'])){
    /* Putting the fieldnames from the form in the array*/
    $fieldnames = array('fname', 'lname', 'username', 'email', 'pwd', 'repeat-pwd');

    $error = false;
    /* Looping the fieldnames in the $_POST[] */
    foreach ($fieldnames as $data) {
        if(empty($_POST[$data])){
            $error = true;
        }    
    }
    /* If a fieldname is empty error message will be shown */
    if ($error) {  
          echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'All fields are required' .'</div>'; 
          
          error_log('X - Add User Failed: username: '.$username.' - '. 'Admin: '. $_SESSION['username'].date("h:i:sa").' ['.$ip_address."]\n", 3, 'logs/admin/log_'.date("d-m-Y").'.log');

    }
    /*If there is not a error, data will be inserted in the database */
    else {
      $persoon = new DB('localhost','root','','project1','utf8mb4');

      $voornaam = ucwords($_POST['fname']);
      $tussenvoegsel = $_POST['tussenvoegsel'];
      $achternaam = ucwords($_POST['lname']);
      $username = $_POST['username'];
      $email = $_POST['email'];
      $pwd = $_POST['pwd'];
      $pwd_repeat = $_POST['repeat-pwd'];
      
          /* If password is not the same error will be shown */
          if ($pwd != $pwd_repeat) {
              echo '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.'Password is not the same' .'</div>';

              error_log('X - Add User Failed: username: '.$username.' - '. 'Admin: '. $_SESSION['username'].date("h:i:sa").' ['.$ip_address."]\n", 3, 'logs/admin/log_'.date("d-m-Y").'.log');

          }else{
              $persoon->register_insert($voornaam, $tussenvoegsel, $achternaam, $email, $pwd, $username);

              error_log('X - Add User Success: username: '.$username.' - '. 'Admin: '. $_SESSION['username'].date("h:i:sa").' ['.$ip_address."]\n", 3, 'logs/admin/log_'.date("d-m-Y").'.log');
          }

    } 
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            min-height: 75rem;
            padding-top: 4.5rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home<span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="overzicht.php">Overzicht</a>
                </li>        
                <li class="nav-item">
                    <a class="nav-link" href="gegevens.php">Gegevens</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link active" href="create.php">Toevoegen</a>
                </li> 
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                         <a class="dropdown-item " href="logout.php">Log out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <main role="main" class="container">
        <form class="form form-register" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" name="fname"   maxlength="60" placeholder="Voornaam" required/>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="tussenvoegsel"  maxlength="60" placeholder="Tussenvoegsel"/>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="lname" maxlength="60" placeholder="Achternaam" required/>
                </div>
                <div class="col">
                    <input type="number" class="form-control" name="type" min="1" max="4" placeholder="Functie" required/>
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class="col">
                    <input type="email" class="form-control" name="email"   maxlength="60" placeholder="email" required/>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="username"  maxlength="60" placeholder="Gebruikersnaam" required/>
                </div>
                <div class="col">
                    <input type="password" class="form-control" name="pwd" maxlength="60" placeholder="Wachtwoord" required/>
                </div>
                <div class="col">
                    <input type="password" class="form-control" name="repeat-pwd" maxlength="60" placeholder="Herhaal Wachtwoord" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <input type="submit" class="btn btn-primary mt-3" name="register_form" value="Toevoegen"/>
                </div>
            </div>
        </form>  
        <hr>
        <h3>Nummer toevoegen bij Functie:</h3>
        <ul>
            <li>1: Admin</li>     
            <li>2: Docent</li>  
            <li>3: Student</li>  
            <li>4: User</li>     
        </ul>  
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="..\assets\js\table.js"></script>
</body>
</html>