<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iNote!</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
            $('#username').keyup(function(){
            var userName = $(this).val();
            var usernameErrs = $('#outputUsername');
            var phpFile = 'validation.php';

            // Check if username is not empty
            if(userName != '') {
                $.post(phpFile, {checkUser: userName}, function(data){
                    usernameErrs.html(data);
                });
            } else {
                // If username becomes empty after keyup, trigger another keyup event
                $(this).trigger('keyupEmpty');
            }
        });

        $('#username').click(function(){
            var userName = $(this).val();
            var usernameErrs = $('#outputUsername');
            var phpFile = 'validation.php';

            // Check if username is empty
            if(userName == '') {
                $.post(phpFile, {checkInput: userName}, function(data){
                    usernameErrs.html(data);
                });
            }
        });

        // Listen for the custom keyupEmpty event
        $('#username').on('keyupEmpty', function(){
            var userName = $(this).val();
            var usernameErrs = $('#outputUsername');
            var phpFile = 'validation.php';

            // Check if username is empty
            if(userName == '') {
                $.post(phpFile, {checkInput: userName}, function(data){
                    usernameErrs.html(data);
                });
            }
        });
    });
</script>



</head>
<body>
    <div class="maincontainer">
        <div class="registerTitle">REGISTER</div>
        <form action="" method="POST" autocomplete="OFF">
            <div class="personalInfo">
                <h3 class="titleAreaLeft">Personal Information</h3>
                <div class="fnameArea">
                    <input type="text" name="firstname" id="firstname" placeholder="Enter Firstname">
                    <span id="outputfname"></span>
                </div>

                <div class="lnameArea">
                    <input type="text" name="lastname" id="lastname" placeholder="Enter Username">
                    <span id="outputlname"></span>
                </div>

                <div class="dobArea">
                    <input type="date" name="dob" id="dob" placeholder="Enter Date of Birth">
                    <span id="outputDob"></span>
                </div>

                <div class="gender-age">
                    <div class="ageArea">
                        <input type="number" name="age" id="age" placeholder="Age" readonly>
                        <span id="outputAge"></span>
                    </div>

                    <div class="genderArea">
                        <label for="gMale">Gender</label>
                            <div class="choices">
                                <div class="male-gender">
                                    <input type="radio" name="gender" id="gMale" value="Male" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'Male' ? 'checked' : ''; ?>><label for="gMale">Male</label>
                                </div>

                                <div class="female-gender">
                                    <input type="radio" name="gender" id="gFemale" value="Female" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'Female' ? 'checked' : ''; ?>><label for="gFemale">Female</label>
                                </div>
                            </div>
                            <div class="errMessage"><span class="error-message"><?php echo $genderErr ?? ''; ?></span></div>
                    </div>
                </div>
            </div>

            <div class="accountInfo">
            <h3 class="titleAreaRight">Account Information</h3>
                <div class="usernameArea">
                    <input type="text" name="username" id="username" placeholder="Enter Username">
                    <span id="outputUsername"></span>
                </div>
            </div>
        </form>
    </div>
</body>
</html>