<?php

session_start(); // Start session

include 'dbconnector.php';
include 'insertNotes.php'; // Include before any output

// Check for username session and get userID
$userID = getUserIDFromSession();

if (!$userID) {
    // Redirect if not logged in, before any output
    header("Location: ../login.php");
    exit();
}

// Proceed with the rest of the script only after validating the session

$pdo = connectDB();

$searchFilter = $_GET['search'] ?? '';

$sql = "SELECT * FROM notes_tbl WHERE notes_status = 'Active' AND user_id = :userID";

if (!empty($searchFilter)) {
    $sql .= " AND notes_title LIKE :searchFilter";
}

$sql .= " ORDER BY notes_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userID', $userID);

if (!empty($searchFilter)) {
    $stmt->bindValue(':searchFilter', '%' . $searchFilter . '%');
}

if ($stmt->execute()) {
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    die("Query failed: " . implode(" ", $stmt->errorInfo()));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iNote!</title>
    <link rel="stylesheet" href="../css/noteContent.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body>
<?php
$firstNote = true;
foreach ($notes as $note) {
    $class = $firstNote ? 'noteContainer selected' : 'noteContainer';

    $noteTitle = htmlspecialchars($note['notes_title']);
    $noteDescription = htmlspecialchars($note['notes_description']);
    $noteTitle = str_replace(array("\n", "\r"), '<br>', $noteTitle);
    $noteDescription = str_replace(array("\n", "\r"), '<br>', $noteDescription);

    $heartColor = ($note['notes_favorite'] == 'favorite') ? '#e73a4e' : ''; 

    $noteTitle = str_replace("'", "&#39;", $noteTitle);
    $noteDescription = str_replace("'", "&#39;", $noteDescription);

    echo "<div class='{$class}' onclick='showNoteContent(this, \"{$noteTitle}\", \"{$noteDescription}\")'>";
    echo '<span class="nId">' . htmlspecialchars($note['notes_id']) . '</span>';
    echo '<span class="nTitle">' . shortentitle($noteTitle) . '</span>';
    echo '<span class="nDesc">' . shortenDescription($noteDescription) . '</span>';
    echo '<span class="nDate"> <i class="bx bxs-calendar"></i>' . htmlspecialchars($note['notes_date']) . '</span>';

    echo '<span class="fulltitle" style="display: none;">' . htmlspecialchars($noteTitle) . '</span>';
    echo '<span class="fullDescription" style="display: none;">' . htmlspecialchars($noteDescription) . '</span>';

    echo '<form action="" method="POST">
              <input type="hidden" name="faveNoteId" value="' . htmlspecialchars($note['notes_id']) . '">
              <button type="submit" class="heart-btn">
                  <i class="bx bxs-heart bottom-left" style="color: ' . $heartColor . ';"></i>
              </button>
          </form>';
    echo '</div>';

    $firstNote = false;
}
?>
</body>
</html>
