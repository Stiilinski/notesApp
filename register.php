<?php
include_once "php/dbconnector.php";
include_once "php/insertUser.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iNote!</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Manjari:wght@100;400;700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    * {
    box-sizing: border-box;
    }

    body {
    margin: 0 auto;
    padding: 0px;
    background-color: #252424;
    overflow-x: hidden;
    }

    .maincontainer {
    width: 1536px; 
    margin: 0 auto;
    min-height: 100vh;
    display: flex;
    background-color: #252424;
    }

    .regFormCon {
    display: flex;
    flex-direction: column;
    align-items: center;
    }

    .regForm {
    width: 1536px;
    padding: 10px;
    font-family: Helvetica, sans-serif;
    display: flex;
    flex-direction: column;
    gap: 40px;
    }

    .p-info, .a-info {
    width: 550px;
    display: flex;
    justify-content: flex-start;
    }

    .accInfo, .perInfo {
    color: #fff;
    font-size: 30px;
    }

    .informations {
    display: flex;
    flex-direction: row;
    }

    .form-title {
    width: 100%;
    text-align: left;
    padding-left: 20px;
    line-height: 50px;
    font-family: 'Inter';
    font-size: 40px;
    color: #fff;
    font-weight: 800;
    }


    .personal-info {
    display: flex;
    flex-direction: column;
    width: 50%;
    gap: 40px;
    justify-content: center;
    align-items: center;
    height: 100%;
    }

    .account-info {
    width: 50%;
    height: 100%;
    gap: 40px;
    display: flex; 
    flex-direction: column;
    justify-content: center;
    align-items: center;
    }

    .label {
    margin-bottom: 5px;
    }

    label {
    color: #ADABAB;
    font-family: 'Inter';
    font-size: 20px;
    }

    .fname-Area, .lname-Area, .dob-Area, .age-Area, 
    .gender-Area, .user-Area, .email-Area, .pass-Area, 
    .pic-Area{
    display: flex;
    flex-direction: column;
    gap: 5px;
    width: 550px;
    position: relative;
    }

    .firstname, .lastname, .dateBirth,
    .username, .email, .passwords {
    height: 50px;
    border-radius: 10px;
    border-color: #5BD9E1;
    outline: none;
    padding: 13px;
    font-size: 18px;
    background-color: #080808;
    color: #ADABAB;
    width: 550px;
    }



    .age-gender {
    display: flex;
    justify-self: center;
    align-items: center;
    width: 550px;
    }

    .u-age {
    height: 50px;
    border-radius: 10px;
    border-color: #5BD9E1;
    outline: none;
    padding: 13px;
    font-size: 18px;
    background-color: #080808;
    color: #ADABAB;
    width: 250px;
    }

    .error-icon-container, .error-icon-container2, .error-icon-container3,
    .error-icon-container4, .error-icon-container5, .error-icon-container6,
    .error-icon-container7 {
    position: absolute;
    top: 35%;
    right: 5px; 
    transform: translateY(-50%);
    visibility: hidden;

    }
    .error-icon-container1 {
    position: absolute;
    top: 35%;
    right: 30px; 
    transform: translateY(-50%);
    visibility: hidden;
    }

    .bx {
    color: #FF0000;
    font-size: 30px;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(80%);
    margin-right: 20px;
    }

    #gMale, #gFemale {
    width: 40px;
    }

    .sub-btn {
    height: 50px;
    border-top-left-radius: 15px;
    border-bottom-left-radius: 15px;
    border-top-right-radius: 15px;
    background-color: #48A9A9;
    color: #fff;
    font-size: 25px;
    font-family: 'Inter';
    font-weight: 900;
    box-shadow: inset 0 0 10px 5px rgba(0, 0, 0, 0.3);
    cursor: pointer;
    width: 350px;
    }

    .submit-Area {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    }

    .input-pic {
    height: 50px;
    border-radius: 10px;
    border: solid 2px #5BD9E1;
    background-color: #080808;
    color: #ADABAB;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    width: 550px;
    }

    .submit {
    width: 100%;
    }

    .signin {
    text-align: center;
    color: #fff;
    }

    .signlog, .signlog a {
    color: #4DCBB5;
    }

    .male-gender, .female-gender {
    display: flex;
    flex-direction: row;
    }

    .choices {
    display: flex;
    flex-direction: row;
    gap: 20px;
    }

    .errMessage {
    display: flex;
    flex-direction: row;
    gap: 10px;
    color: #ec573c;
    }


    #proPics {
    font-size: 16px;
    background: #080808;
    border-radius: 10px;
    width: 550px;
    height: 50px;
    border: solid 1px #5BD9E1;
    color: #fff;
    }

    ::-webkit-file-upload-button {
    color: #fff;
    background: #1EB9C3;
    height: 48px;
    border: none;
    border-radius: 10px;
    outline: none;
    }




    .popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color:#252323;
    font-family: 'Inter';
    color: #fff;
    width: 450px;
    height: 200px;   
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1), 0 0 0 1000px
                rgba(0, 0, 0, 0.95);
    display: flex;
    justify-content: center;
    align-items: center;
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s, opacity 0.5s ease-in-out;
    }

    .popup.active {
    visibility: visible;
    opacity: 1;
    }

    #my-canvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 100000;
    visibility: hidden;
    pointer-events: none;
    }

    #my-canvas.active  {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 100000;
    visibility: visible;
    }

    .close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 10px 20px;
    background: rgb(237, 147, 58);
    color: #fff;
    cursor: pointer;
    border-top-right-radius: 10px;
    }

    .success {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    }

    .bx-check-circle {
    color: #5deb91;
    font-size: 80px;
    }
</style>

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
     <div class="popup">
        <div class="success">
            <i class='bx bx-check-circle'></i>
            <h2>REGISTERED SUCCESSFULLY</h2>
        </div>
            <b class="close">X</b>
        </div>
    </div>
    <canvas id="my-canvas"></canvas>


    <script src="js/index.min.js"></script>
    <script src="js/script.js"></script>
    
</body>
</html>



