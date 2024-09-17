<?php
// include '../profile.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Initialize error variables
    $unameErr = $passErr = "";

    // Validate username
    $usernamePattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
    if (!preg_match($usernamePattern, $username)) {
        // Username validation failed
        $unameErr = "Username should have at least 8 letters and 1 or more numbers.";
    }

    // Validate password
    $passwordPattern = "/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/";
    if (!preg_match($passwordPattern, $password)) {
        // Password validation failed
        $passErr = "Password should have at least 8 characters, 1 capital letter, and 1 or more numbers.";
    }

    // Construct the update query
$updateQuery = "UPDATE user_tbl SET ";
$updateParams = array();

// Update fields that are not empty
if (!empty($firstName)) {
    $updateQuery .= "user_fname = :firstName, ";
    $updateParams[':firstName'] = $firstName;
}
if (!empty($lastName)) {
    $updateQuery .= "user_lname = :lastName, ";
    $updateParams[':lastName'] = $lastName;
}
if (!empty($dob)) {
    $updateQuery .= "user_dob = :dob, ";
    $updateParams[':dob'] = $dob;
}
if (!empty($age)) {
    $updateQuery .= "user_age = :age, ";
    $updateParams[':age'] = $age;
}
if (!empty($gender)) {
    $updateQuery .= "user_gender = :gender, ";
    $updateParams[':gender'] = $gender;
}
if (!empty($username)) {
    $updateQuery .= "user_uname = :username, ";
    $updateParams[':username'] = $username;
}
if (!empty($password)) {
    $updateQuery .= "user_password = :password, ";
    $updateParams[':password'] = $password;
}
if (!empty($email)) {
    $updateQuery .= "user_email = :email, ";
    $updateParams[':email'] = $email;
}

// Remove trailing comma and space from the update query
$updateQuery = rtrim($updateQuery, ", ");

// Add WHERE clause to target specific user ID
$updateQuery .= " WHERE user_id = :userID";
$updateParams[':userID'] = $userID;
    // Execute the update query
    try {
        $conn = connectDB();
        $stmt = $conn->prepare($updateQuery);
        $stmt->execute($updateParams);
        $conn = null;
        echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                    document.querySelector(".popUpContainer").style.visibility = "visible";
                    document.querySelector(".messageCon h2").textContent = "UPDATE SUCCESSFULLY!";
                });
            </script>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>