<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $accID = $_POST['user'];
    $accPass = $_POST['pass'];

    try 
    {
        // $conn = connectDB();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM user_tbl WHERE user_uname = :accID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':accID', $accID);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($accID) && empty($accPass)) 
        {
            header("Location: ../index.php?error=Both fields are required&user_error=true&pass_error=true");
            exit();
        } 
        elseif (empty($accID)) 
        {
            header("Location: ../index.php?error=Username is Required&user_error=true");
            exit();
        } 
        elseif (empty($accPass)) 
        {
            header("Location: ../index.php?error=Password is Required&pass_error=true");
            exit();
        } 
        elseif ($user) 
        {
            if (password_verify($accPass, $user['user_password'])) 
            {
                $_SESSION['username'] = $user['user_uname'];
                // header("Location: ../loadingscreen.php");
                header("Location: ../dashboard.php");
                exit();
            } 
            else 
            {
                header("Location: ../index.php?error=Incorrect password or username&user_error=true&pass_error=true");
                exit();
            }
        } 
        else 
        {
            header("Location: ../index.php?error=Incorrect password or username&user_error=true&pass_error=true");
            exit();
        }
    } catch (PDOException $e) 
    {
        echo "Error: " . $e->getMessage();
    } 
    finally 
    {
        if ($conn) 
        {
            $conn = null;
        }
    }
}
?>
