<?php
    require_once 'php/dbconnector.php';
    require_once 'php/insertNotes.php';

    // Function to retrieve and display the profile image based on user ID
    function displayProfileImage($userID, $conn)
    {
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

    // Check if user is logged in
    if (isset($_SESSION['username'])) {
        
        // Establish database connection
        $conn = connectDB();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve user ID from the session
        $username = $_SESSION['username'];
        $sql = "SELECT user_id FROM user_tbl WHERE user_uname = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userID = $user['user_id'];

        } else {
            // Display a default image if user not found
            echo '<img src="default_profile_image.jpg" alt="DEFAULT PROFILE IMAGE" />';
        }
    } else {
        // Redirect user to login page if not logged in
        header("Location: index.php");
        exit();
    }

    // FOR EDIT/UPDATE
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title1']) && isset($_POST['description1']) && isset($_POST['noteId']))
    {
        $updatedTitle = $_POST['title1'];
        $updatedDescription = $_POST['description1'];
        $noteId = $_POST['noteId'];

        if (updateNote($noteId, $updatedTitle, $updatedDescription)) 
        {
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.querySelector(".popUpContainer").style.visibility = "visible";
                        document.querySelector(".messageCon h2").textContent = "NOTES UPDATED!";
                    });
                </script>';
        } 
        else 
        {
            echo "<script>alert('Failed to update note.');</script>";
        }
    }

    // FOR ADDING/INSERTING
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title']) && isset($_POST['description'])) {
        // Check if the user is logged in and retrieve the user ID
        if (isset($_SESSION['username'])) {
            $userID = getUserIDFromSession();
        } else {
            // Handle case where user is not logged in
            echo "<script>alert('Error: User is not logged in.');</script>";
            exit; // Stop further execution
        }

        // Retrieve title and description from POST data
        $noteTitle = $_POST['title'];
        $noteContent = $_POST['description'];

        // Call insertNote function with user ID, title, and content
        if (insertNote($userID, $noteTitle, $noteContent)) {
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.querySelector(".popUpContainer").style.visibility = "visible";
                    });
                </script>';
        } else {
            echo "<script>alert('Error inserting note.');</script>";
        }
    }

    // FOR ARCHIVING
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['archiveNoteId']))
    {
        $noteId = $_POST['archiveNoteId'];

        if (archiveNote($noteId)) 
        {
            echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                        document.querySelector(".popUpContainer").style.visibility = "visible";
                        document.querySelector(".messageCon h2").textContent = "NOTES ARCHIVED!";
                    });
                </script>';
        } 
        else 
        {
            echo "<script>alert('Failed to update note.');</script>";
        }
    }

    // FOR RESTORE
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resNoteId']))
    {
        $noteId = $_POST['resNoteId'];

        if (restoreNote($noteId)) 
        {
            echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                        document.querySelector(".popUpContainer").style.visibility = "visible";
                        document.querySelector(".messageCon h2").textContent = "NOTES RESTORED!";
                    });
                </script>';
        } 
        else 
        {
            echo "<script>alert('Failed to update note.');</script>";
        }
    }

    // FOR FAVORITE
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['faveNoteId'])) 
    {
        $noteId = $_POST['faveNoteId'];

        // Check if the note is already marked as favorite
        $isFavorite = isNoteFavorite($noteId);

        // If the note is already favorite, remove it; otherwise, mark it as favorite
        if ($isFavorite) 
        {
            // Remove favorite status
            if (removeFavorite($noteId)) 
            {
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.querySelector(".popUpContainer").style.visibility = "visible";
                        document.querySelector(".messageCon h2").textContent = "NOTES UNMARKED AS FAVORITE";
                    });
                </script>';
            } 
            else 
            {
                echo "<script>alert('Failed to unmark note as favorite.');</script>";
            }
        } 
        else 
        {
            // Mark as favorite
            if (favoriteNote($noteId)) 
            {
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.querySelector(".popUpContainer").style.visibility = "visible";
                        document.querySelector(".messageCon h2").textContent = "NOTES MARKED AS FAVORITE";
                    });
                </script>';
            } 
            else 
            {
                echo "<script>alert('Failed to mark note as favorite.');</script>";
            }
        }
    }

    // FOR DELETE
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delNoteId']))
    {
        $noteId = $_POST['delNoteId'];

        if (deleteNote($noteId)) 
        {
            echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                        document.querySelector(".popUpContainer").style.visibility = "visible";
                        document.querySelector(".messageCon h2").textContent = "NOTES DELETE!";
                    });
                </script>';
        } 
        else 
        {
            echo "<script>alert('Failed to update note.');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iNote!</title>
    <link rel="stylesheet" href="/todolist/css/dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<style>
    
</style>

<body>
    <div class="mainContainer">

        <!-- SIDEBARS -->
        <div class="sideBar interActive" id="sidebar">
            <div class="logo">iN!</div>
    
                <div class="icons" id="nav">
                    <div class="menuBtncon1">
                        <div class="btncon btncon1" onclick="handleButtonClick(1)">
                            <button name="allMyNotes" class="btnnot" onclick="handleAllButtonClick()">
                                <div class="btn1" id="button1">
                                    <i class='bx bx-notepad'></i>
                                </div>
                                <span class="aNotes a1">ALL NOTES</span>
                            </button>   
                        </div>
                    </div>

                    <div class="menuBtncon2">
                        <div class="btncon btncon2" onclick="handleButtonClick(2)">
                            <button name="favoriteNotes" class="btnfave" onclick="handleFavoritesButtonClick()">
                                <div class="btn2" id="button2">
                                    <i class='bx bx-book-heart'></i>
                                </div>
                                <span class="aNotes a2">FAVORITES</span>
                            </button>
                        </div>
                    </div>


                    <div class="menuBtncon3">
                        <div class="btncon btncon3" onclick="handleButtonClick(3)">
                            <button name="archNotes" class="btnarch" onclick="handleArchiveButtonClick()">
                                <div class="btn3" id="button3">
                                    <i class='bx bx-archive-in'></i>
                                </div>
                                <span class="aNotes a3">ARCHIVES</span>
                            </button>
                        </div>
                    </div>
                </div>
            
                <a href="profile.php"><div class="profile">
                    <div class="prof" id="profile">
                        <div class="profile-image-container">
                            <?php
                                displayProfileImage($userID, $conn);
                            ?>
                        </div>
                    </div>
                    <div class="profilename" id="profName"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></div>
                    <div class="profileid" id="id"><?php echo isset($userID) ? $userID : ''; ?></div>
                </div></a>

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

        <div class="extended-sidebar">
            <div class="inner-extended">
                <div class="add-search">
                    <input type="text" placeholder="Search..." name="search" class="searches" id="searchInput">
                    <button class="add" id="addNotes" onclick="displayAddForm()"> + </button>
                </div>   

                <div class="label-view">
                    <div class="labelView ">
                        <div class="labelLogo" id="logoTitles"><i class='bx bx-notepad titleLogs'></i></div>
                        <div class="labelName" id="logoNames">All Notes</div>
                    </div>
                </div>

                <div class="noteContentList" id="listMode">
                    <?php
                            include "php/displayNotes.php"
                        ?>
                </div>  
            </div>      
        </div>

        <!-- NOTE CONTENTS -->
        <div class="noteContentContainer">
            <div class="contentCon">
                <div class="noteHeader">
                    <div class="myNotes">
                        <i class='bx bxs-folder folders'></i><span id="conTitles">My Notes</span>
                    </div>

                    <div class="closeFullScreen">
                        <i class='bx bx-x' id="clsFs" onclick="closeFullScreen()"></i>
                    </div>
                </div>

                <div class="contentNoteCon">    
                    <div class="contentTitleCon">
                        <div class="content-options">
                            <div id="noteId">#</div>
                        <i class='bx bx-dots-horizontal-rounded' id="optionsIcon"></i>
                        <div class="options-container" id="optionsContainer">
                            <div class="option" id="fsOption" onclick="displayFullScreen()">Full Screen</div>
                            <div class="option" id="archiveOption" onclick="displayArchiveForm()">Archive</div>
                            <div class="option" id="editOption" onclick="displayEditForm()">Edit</div>
                        </div>
                    </div>
                    
                        <div class="content-title" id="selectedNoteTitle">
                            NOTE TITLE!      
                        </div>
                    </div>

                    <div class="contentDesc">
                        <div class="contentInside">
                            <p class="contentDescription" id="selectedNoteDescription">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi quae libero impedit, neque asperiores similique maiores tempore incidunt sit iure eveniet aliquid cumque vitae voluptatem explicabo nobis, illo laboriosam dolores!</p>
                        </div>    
                    </div>
                </div>        
            </div>
        </div>


    </div>

    <div class="addForm">
        <div class="formContainer">
            <form action="" class="inputForms" id="iForms" method="POST">
                <div class="titleArea">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="note-title" id="noteTitle" placeholder="Enter Title">
                </div>

                <div class="descriptionArea">
                    <label for="desciption">Description</label>
                    <textarea name="description" id="noteDescription" class="note-description" placeholder="Enter Description"></textarea>
                </div>

                <div class="buttonArea">
                    <input type="submit" value="ADD NOTE" class="submitBtn">
                    <button class="cancel" type="Button" onclick="cancelForm()" >CANCEL</button>
                </div>
            </form>
        </div>
    </div>

    <div class="editForm">
        <div class="formContainer1">
            <form action="" class="inputForms1" id="iForms1" method="POST">
                <div class="titleArea1">
                    <input type="hidden" name="noteId" id="idEdit" value="#">
                    <label for="title1">Title</label>
                    <input type="text" name="title1" class="note-title1" id="noteTitle1" placeholder="Enter Title">
                </div>

                <div class="descriptionArea1">
                    <label for="desciption1">Description</label>
                    <textarea name="description1" id="noteDescription1" class="note-description1" placeholder="Enter Description"></textarea>
                </div>

                <div class="buttonArea1">
                    <input type="submit" value="SAVE CHANGES" class="submitBtn">
                    <button class="cancel" type="Button" onclick="cancelForm()" >CANCEL</button>
                </div>
            </form>
        </div>
    </div>

    <div class="popUpContainer1">
        <div class="popUpCon1">
            <form action="" method="POST">
                <div class="messageCon1">
                    <input type="hidden" name="archiveNoteId" id="idArchive" value="#">
                    <h2>ARE YOU SURE YOU WANT TO ARCHIVE THIS NOTE?</h2>
                </div>
                <div class="closeCon1">
                    <input type="submit" value="YES" class="submitBtn1">
                    <button class="clsBtn1" type="button" onclick="cancelForm()">NO</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mainDelCon">
        <div class="Delcon">
            <form action="" method="POST">
                <div class="messageDelCon">
                    <input type="hidden" name="delNoteId" id="idDel" value="#">
                    <h2>ARE YOU SURE YOU WANT TO DELETE THIS NOTE?</h2>
                </div>
                <div class="closeDelCon">
                    <input type="submit" value="YES" class="submitBtnDel">
                    <button class="clsBtnDel" type="button" onclick="cancelForm()">NO</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mainResCon">
        <div class="resCon">
            <form action="" method="POST">
                <div class="messageResCon">
                    <input type="hidden" name="resNoteId" id="idRes" value="#">
                    <h2>ARE YOU SURE YOU WANT TO RESTORE THIS NOTE?</h2>
                </div>
                <div class="closeResCon">
                    <input type="submit" value="YES" class="submitBtnRes">
                    <button class="clsBtnRes" type="button" onclick="cancelForm()">NO</button>
                </div>
            </form>
        </div>
    </div>


    <div class="popUpContainer">
        <div class="popUpCon">
            <div class="closeCon">
                <button class="clsBtn" onclick="closePopup()">X</button>
            </div>
            <div class="messageCon">
                <h2>NOTES SAVE!</h2>
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



<!-- 
3.  AJAX validation
 -->