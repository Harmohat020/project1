<?php
session_start();

$type = $_SESSION['type'];

if (isset($_SESSION['username']) AND $type === 'Admin') {

    $username = ucwords($_SESSION['username']);

    /* This sets the $time var to current hour (24h) */
    $time = date("H");
    /* Set the $timezone variable to current timezone */
    $timezone = date("e");
    /* If time is higher or equal than 6 and less than 12 o'clock, display will be Good Morning */
    if ($time >= "6" AND $time < "12") {
        $welcomeMSG = "Good Morning - {$username}";
    } 
    /* If time is between or equal to 12 and 17 o'clock, display will be Good Afternoon */
    elseif ($time >= "12" AND $time < "17") {
        $welcomeMSG = "Good Afternoon -  {$username}";
    } 
    /* If time is between or equal than 17 o'clock and less than 19 o'clock, display will be Good Evening */
    elseif ($time >= "17" AND $time < "19") {
        $welcomeMSG = "Good Evening - {$username}";
    } 
    /* If time is greater or equal than  19 o'clock, display will be Good Evening */
    else {
        $welcomeMSG = "Good Night - {$username}";
    }
}else{
    header("Location: ..\index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Admin</title>
    <!--Own CSS File -->
    <link rel="stylesheet" href="..\assets\styles\admin\style.scss">

    <!--Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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
                    <a class="nav-link active" href="index.php">Home<span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="overzicht.php">Overzicht</a>
                </li>    
                <li class="nav-item">
                    <a class="nav-link" href="gegevens.php">Gegevens</a>
                </li>     
                <li class="nav-item">
                    <a class="nav-link" href="create.php">Toevoegen</a>
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
        <div class="welcome-msg">
            <h2><?php echo $welcomeMSG; ?></h2>
        </div>

        <hr>
     
    </main>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>