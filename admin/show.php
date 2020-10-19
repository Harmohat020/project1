<?php
include_once '../database.php'; 

session_start();

$type = $_SESSION['type'];

if (isset($_SESSION['username']) AND $type === 'Admin'){
    $row = $_SESSION['admin_row'];

    if(isset($_GET['id'])){
        $user = new DB('localhost','root','','project1','utf8mb4');
        
        $user->show($_GET['id']);
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
    <title>Show</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg"> 
                 <div class="card"> 
                    <div class="card-body">              
                         <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-left mt-3">
                                    <h1>User details</h1>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <p class="font-weight-bold">Voornaam</p>
                                    </div>
                                    <div class="col">
                                         <?php echo $user->voornaam;?>
                                    </div>
                                    <div class="col-9"></div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                    <p class="font-weight-bold">Tussenvoegsel:</p>
                                    </div>
                                    <div class="col">
                                         <?php echo $user->tussenvoegsel;?>
                                    </div>
                                    <div class="col-9"></div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                    <p class="font-weight-bold">Achternaam:</p>
                                    </div>
                                    <div class="col">
                                         <?php echo $user->achternaam;?>
                                    </div>
                                    <div class="col-9"></div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                    <p class="font-weight-bold">Email:</p>
                                    </div>
                                    <div class="col">
                                         <?php echo $user->email;?>
                                    </div>  
                                    <div class="col-9"></div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                    <p class="font-weight-bold">Gebruikersnaam:</p>
                                    </div>
                                    <div class="col">
                                         <?php echo $user->gebruikersnaam;?>
                                    </div>
                                    <div class="col-9"></div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                    <p class="font-weight-bold">Type:</p>
                                    </div>
                                    <div class="col">
                                         <?php echo $user->type;?>
                                    </div>
                                    <div class="col-9"></div>
                                </div>
                                <div class="pull-right mt-3 mb-3">
                                    <a class="btn btn-primary" href="overzicht.php">Terug</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>