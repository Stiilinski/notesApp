<?php
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



function connectDB() 
{
    $host = "207.148.119.27"; // MySQL server IP
    $port = "5432"; // Custom port for MySQL, unusual but according to your configuration
    $dbname = "default"; // Your database name
    $username = "mysql"; // Your MySQL username
    $password = "fYrR7PcIT8ELErISEqNFeIm9GsvsjCvQ64wzbn7v7Srp7vEQ1nnbqTXQCmIHornA"; // Your MySQL password

    try 
    {
        // DSN string for MySQL
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } 
    catch (PDOException $e) 
    {
        // Output the error message
        echo "Connection failed: " . $e->getMessage();
        return null; // Ensure that null is returned if connection fails
    }
}
?>