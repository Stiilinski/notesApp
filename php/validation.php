<?php
include 'dbconnector.php';

if(isset($_POST['checkUser'])) {
    $username = $_POST['checkUser'];
    
    // Connect to the database
    $conn = connectDB();

    // Prepare and execute the query to check if the username exists
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM user_tbl WHERE user_uname = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($result['count'] > 0) {
        // Username exists
        echo "Username exists in the database.";
    } else {
        // Username does not exist
        echo "Username does not exist in the database.";
    }
}

if(isset($_POST['checkInput'])) {
    $inputValue = $_POST['checkInput'];
    
    if(empty($inputValue)) {
        echo "Input is empty.";
    }
}
?>