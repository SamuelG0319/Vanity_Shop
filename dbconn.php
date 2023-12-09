<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "vanity_db";

try {
    $dbconn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    print "Error: " . $e->getMessage(). "<br/>";
    die();
}

?>