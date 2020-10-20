<?php 
include_once '../database.php'; 

session_start();

$type = $_SESSION['type'];

if (isset($_SESSION['username']) AND $type === 'Admin'){
    
    if(isset($_GET['id'])){

        print $_GET['id'];
        $persoon = new DB('localhost','root','','project1','utf8mb4');

        $persoon->destroy();
    }
    
}else{
    header("Location: ..\index.php");
}
?>
