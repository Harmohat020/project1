<?php
session_start();

$type = $_SESSION['type'];

if (isset($_SESSION['username']) AND $type === 'Admin') {
    $row = $_SESSION['row'];
}else{
    header("Location: ..\index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gegevens</title>
    <!--Own CSS File -->
    <link rel="stylesheet" href="..\assets\styles\users\style.scss">

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
                    <a class="nav-link" href="index.php">Home<span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="overzicht.php">Overzicht</a>
                </li>  
                <li class="nav-item">
                    <a class="nav-link active" href="gegevens.php">Gegevens</a>
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
        <div class="card">
            <h5 class="card-header">Gegevens</h5>
            <div class="card-body">
            <?php foreach ($row as $persoon): ?>
                <p class="card-text"><b>Voornaam:</b> <?php print($persoon->voornaam);?></p> 
                <p class="card-text"><b>Tussenvoegsel:</b> <?php print($persoon->tussenvoegsel);?></p>  
                <p class="card-text"><b>Achternaam:</b> <?php print($persoon->achternaam);?></p>  
                <p class="card-text"><b>email:</b> <?php print($persoon->email);?></p> 
                <p class="card-text"><b>Functie:</b> <?php print($persoon->type);?></p>    
            <?php endforeach; ?>  
            </div>
        </div>
    </main>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>