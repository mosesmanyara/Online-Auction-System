<?php
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $dbName = 'cse480';

    $db = mysqli_connect($host, $user, $password, $dbName);
    if(!$db) {
        die("Error: Could not connect database !!");
    }
?>