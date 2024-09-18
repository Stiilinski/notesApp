<?php
session_start();
require_once 'dbconnector.php';

function getUserIDFromSession() {
    if (isset($_SESSION['userID'])) {
        return $_SESSION['userID'];
    } elseif (isset($_SESSION['username'])) {
        // If userID is not set but username is, retrieve userID from the database
        try {
            $conn = connectDB();

            // Retrieve user ID based on the session's username
            $username = $_SESSION['username'];
            $sql = "SELECT user_id FROM user_tbl WHERE user_uname = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return $user['user_id'];
            } else {
                // Log an error if no user is found
                // Instead of echoing, handle it later
                return null;
            }
        } catch (PDOException $e) {
            // Handle DB errors here
            error_log("Error: " . $e->getMessage());
            return null;
        }
    } else {
        return null;  // Neither userID nor username are set in the session
    }
}

// Check for username session and get userID
$userID = getUserIDFromSession();

if (!$userID) {
    // Redirect or handle the error (don't echo it)
    header("Location: ../login.php"); // Or handle it appropriately
    exit();
}

// Use the userID safely below this point
$insertId = $userID;

function insertNote($userID, $title, $content) {
    try {
        $conn = connectDB();
        $currentDate = date("Y-m-d");

        $stmt = $conn->prepare("INSERT INTO notes_tbl (user_id, notes_title, notes_description, notes_date, notes_status) VALUES (:id, :title, :content, :date, 'Active')");
        
        $stmt->bindParam(':id', $userID);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':date', $currentDate);

        $stmt->execute();
        $conn = null;

        return true;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

function shortenDescription($description) {
    if (strlen($description) > 18) 
    {
        return substr($description, 0, 18) . '...';
    } 
    else {
        return $description;
    }
}

function shortentitle($title) {
    if (strlen($title) > 10) 
    {
        return substr($title, 0, 10) . '...';
    } 
    else {
        return $title;
    }
}

function getNotes($userID) {
    try {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT * FROM notes_tbl WHERE notes_status = 'Active' AND user_id = :userID ORDER BY notes_date DESC");
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $notes;
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        return array(); // Return empty array if an error occurs
    }
}

$notes = getNotes($userID);

function updateNote($noteId, $updatedTitle, $updatedDescription) {
    try {
        $conn = connectDB();
        $currentDate = date("Y-m-d");

        $stmt = $conn->prepare("UPDATE notes_tbl SET notes_title = :title, notes_description = :description, notes_date = :date WHERE notes_id = :noteId");
        $stmt->bindParam(':title', $updatedTitle);
        $stmt->bindParam(':description', $updatedDescription);
        $stmt->bindParam(':noteId', $noteId);
        $stmt->bindParam(':date', $currentDate);
        $stmt->execute();
        $conn = null;

        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function archiveNote($noteId) {
    try {
        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE notes_tbl SET notes_status = 'Archive' WHERE notes_id = :noteId");
        $stmt->bindParam(':noteId', $noteId);
        $stmt->execute();
        $conn = null;

        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function restoreNote($noteId) {
    try {
        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE notes_tbl SET notes_status = 'Active' WHERE notes_id = :noteId");
        $stmt->bindParam(':noteId', $noteId);
        $stmt->execute();
        $conn = null;

        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deleteNote($noteId) {
    try {
        $conn = connectDB();
        $stmt = $conn->prepare("DELETE FROM notes_tbl WHERE notes_id = :noteId");
        $stmt->bindParam(':noteId', $noteId);
        $stmt->execute();
        $conn = null;

        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function favoriteNote($noteId) {
    try {
        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE notes_tbl SET notes_favorite = 'favorite' WHERE notes_id = :noteId");
        $stmt->bindParam(':noteId', $noteId);
        $stmt->execute();
        $conn = null;

        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function removeFavorite($noteId) {
    try {
        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE notes_tbl SET notes_favorite = NULL WHERE notes_id = :noteId");
        $stmt->bindParam(':noteId', $noteId);
        $stmt->execute();
        $conn = null;

        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function isNoteFavorite($noteId) {
    try {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT notes_favorite FROM notes_tbl WHERE notes_id = :noteId");
        $stmt->bindParam(':noteId', $noteId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;

        return $result['notes_favorite'] === 'favorite';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}



?>
