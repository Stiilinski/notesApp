<?php
require_once 'php/dbconnector.php';
require_once 'php/insertNotes.php';

// Function to retrieve and display the profile image based on user ID
function displayProfileImage($userID, $conn)
{
    $conn = connectDB();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        // Retrieve user image from the database
        $sql = "SELECT user_profilepic FROM user_tbl WHERE user_id = :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $userImage = $stmt->fetchColumn();

        // Display profile image if it exists
        if ($userImage) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($userImage) . '" alt="PROFILE IMAGE" />';
        } else {
            // Display a default image if user image not found
            echo '<img src="default_profile_image.jpg" alt="DEFAULT PROFILE IMAGE" />';
        }
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_SESSION['username'])) {
    
    // Establish database connection
    $conn = connectDB();
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve user ID from the session
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM user_tbl WHERE user_uname = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userID = $user['user_id'];
        $fname = $user['user_fname'];
        $lname = $user['user_lname'];
        $fullName = $user['user_fname'] . ' ' . $user['user_lname'];
        $gender = $user['user_gender'];
        $dob = $user['user_dob'];
        $age = $user['user_age'];
        $uname = $user['user_uname'];
        $password = $user['user_password'];
        $emails = $user['user_email'];


    } else {
        // Display a default image if user not found
        echo '<img src="default_profile_image.jpg" alt="DEFAULT PROFILE IMAGE" />';
    }
} else {
    // Redirect user to login page if not logged in
    header("Location: index.php");
    exit();
}



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
    $fnameErr = $lnameErr = $genderErr = $unameErr = $passErr = $emailErr = "";

    // Construct the update query
    $updateQuery = "UPDATE user_tbl SET ";
    $updateParams = array();

    // Update fields that are not empty
    if (!empty($firstName)) {
        // Validate first name for consecutive spaces
        if (preg_match("/ {3,}/", $firstName)) {
            // First name validation failed
            $fnameErr = "Invalid First Name. Maximum of 2 consecutive spaces allowed.";
        } 
        else {
            $updateQuery .= "user_fname = :firstName, ";
            $updateParams[':firstName'] = $firstName;
        }
    }

    if (!empty($lastName)) {
        // Validate last name for consecutive spaces
        if (preg_match("/ {3,}/", $lastName)) {
            // Last name validation failed
            $lnameErr = "Invalid Last Name. Maximum of 2 consecutive spaces allowed.";
        } else {
            $updateQuery .= "user_lname = :lastName, ";
            $updateParams[':lastName'] = $lastName;
        }
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
        // Validate gender
        $trimmedGender = trim($gender);
        if (strlen($trimmedGender) === 0 || preg_match("/ {2,}/", $trimmedGender)) {
            // Gender validation failed
            $genderErr = "Invalid Gender. Please select a valid gender.";
        } else {
            $updateQuery .= "user_gender = :gender, ";
            $updateParams[':gender'] = $trimmedGender;
        }
    }

    if (!empty($username)) {
        // Validate username
        $usernamePattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d ]{8,}$/";
        if (!preg_match($usernamePattern, $username) || preg_match("/ {3,}/", $username)) {
            // Username validation failed
            $unameErr = "Username should have at least 8 letters and 1 or more numbers";
        } 
        else {
            $updateQuery .= "user_uname = :username, ";
            $updateParams[':username'] = $username;
            $_SESSION['username'] = $username;
        }
    }

    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
        // Handle profile picture upload and add to update query
        $profilePic = file_get_contents($_FILES['profilePic']['tmp_name']);
        $updateQuery .= "user_profilepic = :profilePic, ";
        $updateParams[':profilePic'] = $profilePic;
    }

    if (!empty($password)) {
        // Validate password
        $passwordPattern = "/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/";
        if (!preg_match($passwordPattern, $password)) {
            // Password validation failed
            $passErr = "Password should have at least 8 characters, 1 capital letter, and 1 or more numbers.";
        } 
        else {
            // If password validation passes, hash it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateQuery .= "user_password = :password, ";
            $updateParams[':password'] = $hashedPassword;
        }
    }

    if (!empty($email)) {
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            // Email validation failed
            $emailErr = "Invalid email format";
        } 
        else 
        {
            // Email validation passed, add to update query
            $updateQuery .= "user_email = :email, ";
            $updateParams[':email'] = $email;
        }
    }

    // Remove trailing comma and space from the update query
    $updateQuery = rtrim($updateQuery, ", ");

    // Add WHERE clause to target specific user ID
    $updateQuery .= " WHERE user_id = :userID";
    $updateParams[':userID'] = $userID;

    if (empty($unameErr) && empty($passErr) && empty($emailErr) && empty($fnameErr) && empty($lnameErr) && empty($genderErr)) 
    {
        // Execute the update query only if there are no validation errors
        try 
        {
            $conn = connectDB();
            $stmt = $conn->prepare($updateQuery);
            $stmt->execute($updateParams);
            $conn = null;
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var popUpContainer = document.querySelector(".popUpContainer");
                        if (popUpContainer) {
                            popUpContainer.style.visibility = "visible";
                            var messageCon = document.querySelector(".messageCon h2");
                            if (messageCon) {
                                messageCon.textContent = "UPDATE SUCCESSFULLY!";
                            }
                        }
                    });
                </script>';
        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iNote!</title>
    <link rel="stylesheet" href="/todolist/css/profile.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="mainContainer">
        <!-- SIDEBARS -->
        <div class="sideBar interActive" id="sidebar">
            <div class="logo">iN!</div>
                
                <div class="icons" id="nav">
                    <div class="menuBtncon1">
                        <div class="btncon btncon1" onclick="handleButtonClick(1)">
                            <a href="dashboard.php"><button name="allMyNotes" class="btnnot" onclick="handleAllButtonClick()">
                                <div class="btn1" id="button1">
                                    <i class='bx bx-notepad'></i>
                                </div>
                                <span class="aNotes a1">DASHBOARD</span>
                            </button></a>
                        </div>
                    </div>
                
                    <a href="profile.php">
                        <div class="profile">
                            <div class="prof" id="profile">
                                <div class="profile-image-container">
                                    <?php
                                    displayProfileImage($userID, $conn);
                                    ?>
                                </div>
                            </div>

                           <div class="profilenameside" id="profName"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></div>
                            <div class="profileid" id="id"><?php echo isset($userID) ? $userID : ''; ?></div>
                        </div>
                    </a>
                </div>

                <div class="icons" id="nav1">   
                    <div class="btncon4" onclick="displayLogout()">
                        <div class="logoutBtnContainer">
                            <div class="btn4" id="button4">
                                <i class='bx bx-log-out-circle'></i>
                            </div>
                            <span class="aNotes a4">LOGOUT</span>
                        </div>
                    </div>
                </div>
            </div>
        
    
        <!-- NOTE CONTENTS -->
        <div class="noteContentContainer">
            <div class="contentCon">
                <div class="noteHeader">
                    <div class="myNotes">
                        <i class='bx bxs-user-rectangle'></i><span>My Profile</span></i>
                    </div>
                </div>

                <div class="contentNoteCon">    
                    <div class="contentTitleCon">
                        <div class="content-options">
                            <div id="noteId">#</div>
                        </div>
                    
                        <div class="content-title" id="selectedNoteTitle">
                            <div class="profile-img-con">
                                <?php
                                    displayProfileImage($userID, $conn);
                                ?>
                                <span id="editBtn"><i class='bx bxs-edit-alt' title="Edit" onclick="editProfile()"></i></span>
                                <div class="namesCon">    
                                    <div class="profilename" id="profName">
                                        <?php echo isset($fullName) ? $fullName : ''; ?>
                                    </div>
                                    <div class="profileEmail" id="profEm"><?php echo isset($emails) ? $emails : ''; ?></div>
                                </div>
                            </div>      
                        </div>
                    </div>

                    <div class="contentDesc">
                        <div class="contentDescCon">
                            <form action="" method="post" class="contentInside" enctype="multipart/form-data">
                                <div class="personalInfo">
                                    <div class="fnameArea">
                                        <label for="firstName">First Name:</label>
                                        <input type="text" name="firstName" id="fname" value="<?php echo isset($fname) ? $fname : ''; ?>" disabled>
                                        <div class="errMessage"><span class="error-message"><?php echo $fnameErr ?? ''; ?></span></div>
                                    </div>
                                    <div class="lnameArea">
                                        <label for="lastName">Last Name:</label>
                                        <input type="text" name="lastName" id="lname" value="<?php echo isset($lname) ? $lname : ''; ?>" disabled>
                                        <div class="errMessage"><span class="error-message"><?php echo $lnameErr ?? ''; ?></span></div>
                                    </div>
                                    <div class="birthdateArea">
                                        <label for="dob">Date of Birth:</label>
                                        <input type="date" name="dob" id="dob" onchange="calculateAge()" value="<?php echo isset($dob) ? $dob : ''; ?>" disabled>
                                    </div>
                                    <div class="gender-age">
                                        <div class="ageArea">
                                            <label for="age">Age:</label>
                                            <input type="number" name="age" id="age" value="<?php echo isset($age) ? $age : ''; ?>" disabled readonly>
                                        </div>
                                        <div class="genderArea">
                                            <label for="gender">Gender:</label>
                                            <input type="text" name="gender" id="gender" value="<?php echo isset($gender) ? $gender : ''; ?>" disabled>
                                            <div class="errMessage"><span class="error-message"><?php echo $genderErr ?? ''; ?></span></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accountInfo">
                                    <div class="unameArea">
                                        <label for="username">Username:</label>
                                        <input type="text" name="username" id="uname" value="<?php echo isset($uname) ? $uname : ''; ?>" disabled>
                                        <div class="errMessage"><span class="error-message"><?php echo $unameErr ?? ''; ?></span></div>
                                    </div>
                                    <div class="passArea"> 
                                        <label for="password">Password:</label> 
                                        <input type="password" name="password" id="pass" placeholder="Enter New Password" disabled>
                                        <div class="errMessage"><span class="error-message"><?php echo $passErr ?? ''; ?></span></div>
                                    </div>    
                                    <div class="emailArea">
                                        <label for="email">Email:</label> 
                                        <input type="text" name="email" id="emails" value="<?php echo isset($emails) ? $emails : ''; ?>" disabled>
                                        <div class="errMessage"><span class="error-message"><?php echo $emailErr ?? ''; ?></span></div>
                                    </div>
                                    <div class="profileArea"> 
                                        <label for="profilePic">Profile Picture:</label>        
                                        <input type="file" name="profilePic" id="profPic" disabled>
                                    </div>
                                </div>

                                <div class="btnArea">
                                    <input type="submit" id="submitBtns" name="UpdateBtn" value="SAVE" disabled>
                                </div>
                            </form>
                        </div>    
                    </div>
                </div>        
            </div>
        </div>
    </div>


    <div class="popUpContainer">
        <div class="popUpCon">
            <div class="closeCon">
                <button class="clsBtn" onclick="closePopup1()">X</button>
            </div>
            <div class="messageCon">
                <h2>UPDATE SUCCESSFULY</h2>
            </div>
        </div>
    </div>

    <div class="logoutMessageCon">
        <div class="lmCon">
            <div class="lmlmcon">
                <h2>ARE YOU SURE YOU WANT TO LOGOUT?</h2>
            </div>
            <div class="logOutBtns">
                <button class="logoutBtn" id="logoutBtn" onclick="conFirmLogout()">LOGOUT</button>
                <button class="cancelLogBtn" onclick="cancelLogout()">CANCEL</button>
            </div>
        </div>
    </div>

    <script src="js/dashboard.js"></script>
</body>
</html>

