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



// function connectDB() 
// {
//     $host = "207.148.119.27:5432";
//     $dbname = "default";
//     $username = "mysql";
//     $password = "u3xI2nyoewbtnvMgA7Bm1bwAFu9MpL7ix3ABjXTxAs1qku5P9it2LTDuImE76GWO";

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

function connectDB() {
    // Database connection settings from the provided image
    $host = '207.148.119.27';
    $port = '3306'; // Port should be 3306 for MySQL
    $dbname = 'default'; // Replace with your actual database name
    $username = 'mysql'; // Username as shown in the image
    $password = 'fYrR7PcIT8ELErISEqNFeIm9GsvsjCvQ64wzbn7v7Srp7vEQ1nnbqTXQCmIHornA'; // Replace with the actual password

    try {
        // Set up the PDO connection string for MySQL
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        
        // Create a new PDO instance
        $conn = new PDO($dsn, $username, $password);

        // Set error reporting to throw exceptions
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (PDOException $e) {
        // Handle any errors that occur during connection
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}
?>