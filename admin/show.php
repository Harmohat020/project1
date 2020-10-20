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
    
    <!--Tailwind -->
    <link rel="stylesheet" href="../assets/styles/src/tailwind/style.css">
</head>
<body>
  <main>
    <div class="py-12 p-6 sm:px-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                User Informatie
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                Persoonlijke details
                </p>
            </div>
            <div>
                <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-200">
                    <dt class="text-sm leading-5 font-medium text-black-500">
                    Voornaam
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-500 sm:mt-0 sm:col-span-2">
                        <b><?php echo $user->voornaam; ?></b>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-200">
                    <dt class="text-sm leading-5 font-medium text-black-500">
                    Tussenvoegel
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-500 sm:mt-0 sm:col-span-2">
                        <b><?php echo $user->tussenvoegsel; ?></b>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-200">
                    <dt class="text-sm leading-5 font-medium text-black-500">
                    Achternaam
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-500 sm:mt-0 sm:col-span-2">
                        <b><?php echo $user->achternaam; ?></b>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-200">
                    <dt class="text-sm leading-5 font-medium text-black-500">
                    Email
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-500 sm:mt-0 sm:col-span-2">
                        <b><?php echo $user->email; ?></b>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-200">
                    <dt class="text-sm leading-5 font-medium text-black-500">
                    Gebruikersnaam
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-500 sm:mt-0 sm:col-span-2">
                        <b><?php echo $user->gebruikersnaam; ?></b>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-200">
                    <dt class="text-sm leading-5 font-medium text-black-500">
                    Rol
                    </dt>
                    <dd class="mt-1 text-sm leading-5 text-gray-500 sm:mt-0 sm:col-span-2">
                        <b><?php echo $user->type; ?></b>
                    </dd>
                </div>
                </dl>
            </div>
            </div>
            <br>
            <center>
                <a href="overzicht.php" class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">Terug</a>
            </center>
        </div>
    </div>
  </main>
</body>
</html>