<?php
$servername = "db.4youoffice.nl";
$username = "md527201db568869";
$password = "C#hnP6hR#cS2@r9";
$dbname = "md527201db568869";

$conn = NULL;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}
