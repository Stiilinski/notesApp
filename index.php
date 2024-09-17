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
    <link rel="stylesheet" href="/todolist/css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
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




