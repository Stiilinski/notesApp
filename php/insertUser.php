<?php

$fnameErr = $lnameErr = $dobErr = $ageErr = $genderErr = $unameErr = $emailErr = $passErr = $ppErr = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fname"])) {
        $fnameErr = "*First Name is required";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.firstname');
                    var error = document.querySelector('.error-icon-container');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
                </script>";
    } 
    elseif (!preg_match("/^[a-zA-Z\s]*$/", $_POST["fname"])) 
    {
        $fnameErr = "*Only letters and white spaces allowed";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.firstname');
                    var error = document.querySelector('.error-icon-container');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    }
    else {
       echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.firstname');
                    if (outline) {
                        outline.style.borderColor = '#6ff184';
                    }
                });
              </script>";
    }

    // Validation for Last Name
    if (empty($_POST["lname"])) {
        $lnameErr = "*Last Name is required";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.lastname');
                    var error = document.querySelector('.error-icon-container2');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    } 
    elseif (!preg_match("/^[a-zA-Z\s]*$/", $_POST["lname"])) 
    {
        $lnameErr = "*Only letters and white spaces allowed";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.lastname');
                    var error = document.querySelector('.error-icon-container2');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    }
    else {
        echo "<script>
                 document.addEventListener('DOMContentLoaded', function() {
                     var outline = document.querySelector('.lastname');
                     if (outline) {
                         outline.style.borderColor = '#6ff184';
                     }
                 });
               </script>";
     }

    // Validation for Date of Birth
    if (empty($_POST["dob"])) {
        $dobErr = "*Date of Birth is required";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.dateBirth');
                    var error = document.querySelector('.error-icon-container3');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    }
    else {
        echo "<script>
                 document.addEventListener('DOMContentLoaded', function() {
                     var outline = document.querySelector('.dateBirth');
                     if (outline) {
                         outline.style.borderColor = '#6ff184';
                     }
                 });
               </script>";
     }

    // Validation for Age
    if (empty($_POST["age"])) {
        $ageErr = "*Age is required";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.u-age');
                    var error = document.querySelector('.error-icon-container1');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    }
    else {
        echo "<script>
                 document.addEventListener('DOMContentLoaded', function() {
                     var outline = document.querySelector('.u-age');
                     if (outline) {
                         outline.style.borderColor = '#6ff184';
                     }
                 });
               </script>";
     } 

    // Validation for Gender
    if (empty($_POST["gender"])) {
        $genderErr = "*Gender is required";
    }

    // Validation for Username
    if (empty($_POST["usersname"])) {
        $unameErr = "*Username is required";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.username');
                    var error = document.querySelector('.error-icon-container4');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    } 
    elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["usersname"])) 
    {
        $unameErr = "*Username should have at least 8 letters and 1 or more numbers";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.username');
                    var error = document.querySelector('.error-icon-container4');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    }
    elseif (isUsernameTaken($_POST["usersname"])) 
    {
        $unameErr = "*Username has been taken";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.username');
                    var error = document.querySelector('.error-icon-container4');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    }
    else {
        echo "<script>
                 document.addEventListener('DOMContentLoaded', function() {
                     var outline = document.querySelector('.username');
                     if (outline) {
                         outline.style.borderColor = '#6ff184';
                     }
                 });
               </script>";
     } 
    

    // Validation for Email
    if (empty($_POST["uemails"])) {
        $emailErr = "*Email is required";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.email');
                    var error = document.querySelector('.error-icon-container5');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    } 
    elseif (!filter_var($_POST["uemails"], FILTER_VALIDATE_EMAIL)) 
    {
        $emailErr = "*Invalid email format";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.email');
                    var error = document.querySelector('.error-icon-container5');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    }
    else {
        echo "<script>
                 document.addEventListener('DOMContentLoaded', function() {
                     var outline = document.querySelector('.email');
                     if (outline) {
                         outline.style.borderColor = '#6ff184';
                     }
                 });
               </script>";
     } 

    // Validation for Password
    if (empty($_POST["password"])) {
        $passErr = "*Password is required";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.passwords');
                    var error = document.querySelector('.error-icon-container6');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    } 
    elseif (!preg_match("/^(?=.*[A-Z])(?=.*\d).{8,}$/", $_POST["password"])) 
    {
        $passErr = "*Password should have at least 8 characters, 1 capital letter, and 1 or more numbers";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.querySelector('.passwords');
                    var error = document.querySelector('.error-icon-container6');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    }
    else {
        echo "<script>
                 document.addEventListener('DOMContentLoaded', function() {
                     var outline = document.querySelector('.passwords');
                     if (outline) {
                         outline.style.borderColor = '#6ff184';
                     }
                 });
               </script>";
     } 

    if (empty($_FILES["profilePic"]["name"])) {
        $ppErr = "*Profile Picture is required";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var outline = document.getElementById('proPics');
                    var error = document.querySelector('.error-icon-container7');
                    if (outline) {
                        outline.style.borderColor = '#FF0000';
                        error.style.visibility = 'visible';
                    }
                });
              </script>";
    }
    else {
        echo "<script>
                 document.addEventListener('DOMContentLoaded', function() {
                     var outline = document.querySelector('.input-pic');
                     var error = document.querySelector('.error-icon-container');
                     var error = document.querySelector('.error-icon-container1');
                     var error = document.querySelector('.error-icon-container2');
                     var error = document.querySelector('.error-icon-container3');
                     var error = document.querySelector('.error-icon-container4');
                     var error = document.querySelector('.error-icon-container5');
                     var error = document.querySelector('.error-icon-container6');
                     var error = document.querySelector('.error-icon-container7');
                     if (outline) {
                         outline.style.borderColor = '#6ff184';
                         error.style.visibility = 'hidden';
                     }
                 });
               </script>";
     } 

    if (empty($fnameErr) && empty($lnameErr) && empty($dobErr) && empty($ageErr) && empty($genderErr) && empty($unameErr) && empty($emailErr) && empty($passErr) && empty($ppErr)) {
        // Insert user data into the database
        insertUser($_POST['usersname'], $_POST['fname'], $_POST['lname'], hashPassword($_POST['password']), $_POST['uemails'], isset($_POST['gender']) ? $_POST['gender'] : '', $_POST['age'], $_POST['dob'], file_get_contents($_FILES['profilePic']['tmp_name']));
    
        // JavaScript code for popup and redirection
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var popup = document.querySelector('.popup');
                    if (popup) {
                        popup.classList.add('active');
                    }
                    var confetti = document.querySelector('#my-canvas');
                    if (confetti) {
                        confetti.classList.add('active');
                    }
    
                    // Add event listener to the close button
                    var closeBtn = document.querySelector('.close');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', function() {
                            window.location.href = 'index.php'; // Redirect to index.php
                        });
                    }
                });
              </script>";
              exit;
    }
}


function hashPassword($password) 
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function insertUser($uname, $fname, $lname, $password, $email, $gender, $age, $dob, $profilePicData) 
{
    try 
    {
        // Use the function to get a PDO connection
        $conn = connectDB();

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement with placeholders
        $sql = "INSERT INTO user_tbl (user_uname, user_fname, user_lname, user_password, user_email, user_gender, user_profilepic, user_age, user_dob) 
        VALUES (:uname, :fname, :lname, :password, :email, :gender, :profilePic, :age, :dob)";    

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':uname', $uname);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':dob', $dob);

        // Bind profile picture data as a blob
        $stmt->bindParam(':profilePic', $profilePicData, PDO::PARAM_LOB);

        // Execute the statement
        $stmt->execute();

        // Close the connection
        $conn = null;

        return true; // Return true if insertion is successful
    } 
    catch (PDOException $e) 
    {
        // Return false and log error message if insertion fails
        error_log("Error inserting user: " . $e->getMessage(), 0);
        return false;
    }
}



function isUsernameTaken($username) {
    // Include your database connection
    include_once "php/dbconnector.php";

    try {
        // Connect to the database
        $conn = connectDB();

        // Prepare and execute the query to check if the username exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM user_tbl WHERE user_uname = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Fetch the result
        $count = $stmt->fetchColumn();

        // Return true if the username exists, false otherwise
        return $count > 0;
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
        return false;
    } finally {
        // Close the connection
        $conn = null;
    }
}
?>


