<?php
session_start();

// Check if user is already logged in
if(isset($_SESSION['username'])) {
    header("Location: dashboard.php"); // Redirect to dashboard or any other authorized page
    exit();
}
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
    @import url('https://fonts.googleapis.com/css2?family=Marcellus&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0px;
        background-color: #252424;
    }

    :root {
        --text-regular: 'Manjari', sans-serif;
        --text-bold: 'Manjari-Bold', sans-serif;
    }

    .maincontainer {
        width: 1536px; 
        margin: 0 auto;
        background-image: url(images/background.png);
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        display: flex;
    }

    .header {
        width: 100%;    
        display: flex;
        height: 50px;
    }

    .logo-left {
        padding-left: 35px;
        padding-top: 50px;
        display: flex;
        align-items: center;
        font-size: 50px;
        font-family: var(--text-regular);
        width: 100%;
        font-weight: 900;
        color: #fff;
    }

    .title-container {
        background-color: rgba(0, 0, 0, 0.5);
        height: 100vh;
        width: 50%;
        position: relative;
    }

    .content {
        position: absolute;
        top: 50%; 
        left: 0; 
        transform: translateY(-50%); 
        padding-left: 40px;
        padding-right: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .con1, .con2 {
        color: #fff;
        font-family: 'Marcellus';
        font-size: 60px;
        font-weight: 900;
    }

    .con3 {
        color: #fff;
        font-family: 'Manjari';
        font-size: 35px;
    }

    .signinForms {
        width: 50%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #242424;
    }

    .signin-con {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .formcons {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .logForm {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 20px;
        padding: 10px;
        width: 100%;
    }

    .titleArea {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .maininote {
        color:#fff;
        font-family: 'Poppins';
        font-size: 80px;
        font-weight: 900;
    }

    .mini-title {
        color: #828282;
        font-size: 18px;
        font-family: 'Manjari';
    }

    .username-area, .password-area, .optionArea {
        color: #fff;
        display: flex;
        flex-direction: column;
        width: 60%;
    }

    .optionArea {
        color: #fff;
        display: flex;
        flex-direction: column;
        width: 60%;
        align-items: center;
        font-size: 18px;
    }

    .btn-area {
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }

    .lg-btn {
        background-color: #48A9A9;
        border: none;
        height: 50px;
        width: 250px;
        border-radius: 30px;
        color: #fff;
        font-size: 20px;
        cursor: pointer;
    }

    .input-log {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .username, .password {
        background-color: #080808;
        color: #ADABAB;
        border: none;
        outline: none;
        font-family: 'Manjari';
        height: 50px;
        padding: 15px;
        font-size: 18px;
    }

    .username:-webkit-autofill,
    .password:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 1000px #080808 inset;
        -webkit-text-fill-color: #ADABAB;
    }

    .register-link,
    .register-link a {
        color: #4DCBB5;
        text-decoration: none;
        font-family: 'Manjari', sans-serif;
    }

    .forgot-link,
    .forgot-link a {
        color: #ADADAD;
        text-decoration: none;
        font-family: 'Manjari', sans-serif;
    }

    .error {
        background-color: #F13838;
        width: 350px;
        height: 40px;
        font-family: 'Manjari';
        font-size: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 700;
        color: #fff;
        border-radius: 10px;
    }
</style>

<body>
    <div class="maincontainer">
        <div class="title-container">
            <div class="header">
                <div class="logo-left">
                    <p class="maintitle">iNote!</p>
                </div>
            </div>

            <div class="content">
                <div class="con1">Make it</div>
                <div class="con2">Memorable</div>
                <br>
                <div class="con3">“Empower your thoughts with iNote, your personal note-taking haven”</div>
            </div>
        </div>


        <div class="signinForms" id="signForms">
            <div class="signin-con" id="signinForm">
                <div class="formcons">
                    <form class="logForm" action="php/loginUser.php" method="POST">
                        <div class="titleArea">
                            <span class="maininote">iNote!</span>
                            <span class="mini-title">Easy . Friendly . Secure</span>
                        </div>
                        <div class="input-log">
                            <div class="error-message">
                                <!-- ERROR MESSAGE-->
                                <?php if (isset($_GET['error'])) 
                                { ?>
                                    <span class="error"><?php echo $_GET['error']; ?></span>
                                <?php 
                                } ?>
                                <!--END OF ERROR MESSAGE-->
                            </div>

                            <div class="username-area">
                                <input type="text" class="username" id="uName" name="user" placeholder="Enter Username">
                            </div>

                            <div class="password-area">
                                <input type="password" class="password" id="pWord" name="pass" placeholder="Enter Password">
                            </div>
                        </div>

                        <div class="optionArea">
                            <p class="forgot-link"><a href="#">Forgot Your Password?</a></p>
                            <p class="register-link"><u><a href="register.php" id="reg-form">Register Here!</a></u></p>
                        </div>

                        <div class="btn-area">    
                            <input type="submit" value="SIGN IN" class="lg-btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>




