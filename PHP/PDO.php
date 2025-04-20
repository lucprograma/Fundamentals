<?php
function getConnection(){
    $host = 'localhost';
    $db = 'your_database_name';
    $user = 'your_username';
    $pass = 'your_password';
    try {
     return $connection = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    }
    catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
$query = "SELECT * FROM your_table_name";
$connection = getConnection();
if ($connection) {
    $stmt = $connection->prepare($query);
    $stmt->execute();
} 
 ?>