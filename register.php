<?php
include "php/insertUser.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iNote!</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>

<body>
    <div class="maincontainer">
        <div class="regFormCon">
        <h2 class="form-title">Registration</h2>
        <!-- action="<?//php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" -->
            <form class="regForm" id="registrationForm"  method="post" enctype="multipart/form-data" autocomplete="OFF">
                <div class="informations">
                    <div class="personal-info">
                        <div class="p-info">
                            <label for="Personal" class="perInfo">Personal Information</label>
                        </div>
                        <div class="fname-Area">
                            <input type="text" placeholder="Enter First Name" class="firstname" name="fname" id="fnames" value="<?php echo htmlspecialchars($_POST["fname"] ?? ''); ?>">
                            <div class="error-icon-container">
                                <i class='bx bx-error-circle'></i>
                            </div>
                            <div class="errMessage"><span class="error-message" id="outputfirstName"><?php echo $fnameErr ?></span></div>
                        </div>
                        <div class="lname-Area">
                            <input type="text" placeholder="Enter Last Name" class="lastname" name="lname" id="lnames"  value="<?php echo htmlspecialchars($_POST["lname"] ?? ''); ?>">
                            <div class="error-icon-container2">
                                <i class='bx bx-error-circle'></i>
                            </div>
                            <div class="errMessage"><span class="error-message" id="outputlastName"> <?php echo $lnameErr ?> </span></div>
                        </div>
                        <div class="dob-Area">
                            <input type="date" name="dob" id="dBirth" class="dateBirth" onchange="calculateAge()"  value="<?php echo htmlspecialchars($_POST["dob"] ?? ''); ?>">
                            <div class="error-icon-container3">
                                <i class='bx bx-error-circle'></i>
                            </div>
                            <div class="errMessage"><span class="error-message" id="outputDate"> <?php echo $dobErr ?> </span></div>
                        </div>
                        <div class="age-gender">
                            <div class="age-Area">
                                <input type="number" placeholder="Enter Age" readonly class="u-age" name="age" id="ages"  value="<?php echo htmlspecialchars($_POST["age"] ?? ''); ?>">
                                <div class="error-icon-container1">
                                    <i class='bx bx-error-circle'></i>
                                </div>
                                <div class="errMessage"><span class="error-message" id="outputAge"> <?php echo $ageErr ?> </span></div>
                            </div>
                            <div class="gender-Area">
                                <label for="gMale">Gender</label>
                                <div class="choices">
                                    <div class="male-gender">
                                        <input type="radio" name="gender" id="gMale" value="Male" checked <?php echo isset($_POST['gender']) && $_POST['gender'] == 'Male' ? 'checked' : ''; ?>><label for="gMale">Male</label>
                                    </div>

                                    <div class="female-gender">
                                        <input type="radio" name="gender" id="gFemale" value="Female" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'Female' ? 'checked' : ''; ?>><label for="gFemale">Female</label>
                                    </div>
                                </div>
                                <div class="errMessage"><span class="error-message" id="outputGender"><?php echo $genderErr ?></span></div>
                            </div>
                        </div>
                    </div>

                    <div class="account-info">
                        <div class="a-info">
                            <label for="account" class="accInfo">Account Information</label>
                        </div>
                        <div class="user-Area">
                            <input type="text" placeholder="Enter Username" class="username" name="usersname" id="Uname"  value="<?php echo htmlspecialchars($_POST["usersname"] ?? ''); ?>">
                            <div class="error-icon-container4">
                                <i class='bx bx-error-circle'></i>
                            </div>
                            <div class="errMessage"><span class="error-message" id="outputUsername"> <?php echo $unameErr ?> </span></div>
                        </div>
                        <div class="email-Area">
                            <input type="text" placeholder="Enter Email" class="email" name="uemails" id="emails"  value="<?php echo htmlspecialchars($_POST["uemails"] ?? ''); ?>">
                            <div class="error-icon-container5">
                                <i class='bx bx-error-circle'></i>
                            </div>
                            <div class="errMessage"><span class="error-message" id="outputEmail"> <?php echo $emailErr ?> </span></div>
                        </div>
                        <div class="pass-Area">
                            <input type="password" placeholder="Enter Password" class="passwords" id="pWords" name="password" value="<?php echo htmlspecialchars($_POST["password"] ?? ''); ?>">
                            <div class="error-icon-container6">
                                <i class='bx bx-error-circle'></i>
                            </div>
                            <div class="errMessage"><span class="error-message" id="outputPass"><?php echo $passErr ?></span></div>
                        </div>
                        <div class="pic-Area">
                            <input type="file" name="profilePic" id="proPics" class="profilePics pp">
                            
                            <div class="error-icon-container7">
                                <i class='bx bx-error-circle'></i>
                            </div>
                            <div class="errMessage"><span class="error-message" id="outputPic"> <?php echo $ppErr ?> </span></div>
                        </div>
                        
                    </div>
                </div> 
                <div class="submit-Area">
                    <input type="submit" value="REGISTER" class="sub-btn" id="registerButton">
                    <p class="signin">Already have an account? <a href="index.php" class="signlog" id="log-In">Sign In</a></p>
                </div> 
            </form>

        </div>
    </div>


     <!-- Popup message -->
     <!-- <div class="popup">
        <div class="success">
            <i class='bx bx-check-circle'></i>
            <h2>REGISTERED SUCCESSFULLY</h2>
        </div>
            <b class="close">X</b>
        </div>
    </div>
    <canvas id="my-canvas"></canvas>


    <script src="js/index.min.js"></script>
    <script src="js/script.js"></script> -->
    
</body>
</html>



