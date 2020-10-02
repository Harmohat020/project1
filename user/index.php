<?php 
session_start();

$type = $_SESSION['type'];

if (isset($_SESSION['username']) AND $type === 'user'){
    echo "Wait till the Admin adds you to a group"; 
}else{
    header("Location: ..\index.php");
}
?>