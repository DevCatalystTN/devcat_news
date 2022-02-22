<?php
//DB Creds
$servername = "localhost:3306";
$username = "theco_mpinkley";
$password = "Pancake1-Unrated-Prelaw";
$dbname = "theco_mpinkley";
            
//connecting to DB
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: {$conn->connect_error}");
}
?>  