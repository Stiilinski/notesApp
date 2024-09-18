<?php
// function connectDB() 
// {
//     $host = "localhost";
//     $dbname = "notes";
//     $username = "root";
//     $password = "";

//     try 
//     {
//         $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         return $conn;
//     } 
//     catch (PDOException $e) 
//     {
//         echo "Connection failed: " . $e->getMessage();
//     }

//     return null;
// }


function connectDB() 
{
    // Get environment variables for the database connection
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_DATABASE');
    $username = getenv('DB_USERNAME');
    $password = getenv('DB_PASSWORD');
    $port = getenv('DB_PORT') ?: '3306'; // Use default MySQL port if not set

    try {
        // Create a DSN string for the PDO connection
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

        // Create a new PDO instance
        $conn = new PDO($dsn, $username, $password);

        // Set error mode to exceptions
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn; // Return the PDO connection
    } catch (PDOException $e) {
        // Handle the error by displaying a message
        die("Connection Failed: " . $e->getMessage());
    }
}

?>