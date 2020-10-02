<?php 
include_once '../database.php'; 

session_start();

$type = $_SESSION['type'];

if (isset($_SESSION['username']) AND $type === 'Admin'){

    $overzicht = new DB("localhost","root","","project1","utf8mb4");
    $overzicht->getAllUsers();

    $row = $_SESSION['admin_row'];
}else{
    header("Location: ..\index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht</title>
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
                    <a class="nav-link active" href="overzicht.php">Overzicht</a>
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
        <table class="table table-striped" id="overzicht">
            <thead>
                <tr>
                    <th scope="col">Voornaam</th>
                    <th scope="col">Tussenvoegsel</th>
                    <th scope="col">Achternaam</th>
                    <th scope="col">email</th>
                    <th scope="col">Gebruikersnaam</th>
                    <th scope="col">Functie</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($row as $array): ?>
                <tr>
                    <td><?php echo $array['voornaam'];?></td>
                    <td><?php echo $array['tussenvoegsel'];?></td>
                    <td><?php echo $array['achternaam'];?></td> 
                    <td><?php echo $array['email'];?></td> 
                    <td><?php echo $array['gebruikersnaam'];?></td> 
                    <td><?php echo $array['type'];?></td>  
                    <td>
                        <a class="btn btn-secondary mr-2 btn-sm" href="">Toon</a>
                        <a class="btn btn-primary mr-2 btn-sm" href="edit.php">Edit</a>
                        <input class="btn btn-danger btn-sm" type="submit" value="Verwijderen">
                    </td>       
                </tr> 
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="..\assets\js\table.js"></script>
</body>
</html>