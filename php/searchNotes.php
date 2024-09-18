<?php
include 'insertNotes.php';
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
$pdo = connectDB();

$searchFilter = $_GET['search'] ?? '';

$sql = "SELECT * FROM notes_tbl WHERE notes_status = 'Active' AND user_id = $userID";


if (!empty($searchFilter)) {
    $sql .= " AND notes_title LIKE :searchFilter";
}

$sql .= " ORDER BY notes_date DESC";

$stmt = $pdo->prepare($sql);

if (!empty($searchFilter)) {
    $stmt->bindValue(':searchFilter', '%' . $searchFilter . '%');
}


if ($stmt->execute()) {
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Start of the note container

    $firstNote = true;
    foreach ($notes as $note) {
        // Check if it's the first note, add 'selected' class
        $class = $firstNote ? 'noteContainer selected' : 'noteContainer';
    
        // Preprocess title and description to handle line breaks and apostrophes
        $noteTitle = htmlspecialchars($note['notes_title']);
        $noteDescription = htmlspecialchars($note['notes_description']);
        $noteTitle = str_replace(array("\n", "\r"), '<br>', $noteTitle);
        $noteDescription = str_replace(array("\n", "\r"), '<br>', $noteDescription);
    
        $heartColor = ($note['notes_favorite'] == 'favorite') ? '#e73a4e' : ''; 
    
        // Escape apostrophes in the title and description
        $noteTitle = str_replace("'", "&#39;", $noteTitle); // Replacing single quote with HTML entity
        $noteDescription = str_replace("'", ",;", $noteDescription); // Replacing single quote with HTML entity
    
        // Start of the note container for each note
        echo "<div class='{$class}' onclick='showNoteContent(this, \"{$noteTitle}\", \"{$noteDescription}\")'>";
    
        // Display note details
        echo '<span class="nId">' . htmlspecialchars($note['notes_id']) . '</span>';
        echo '<span class="nTitle">' . shortentitle($noteTitle) . '</span>';
        echo '<span class="nDesc">' . shortenDescription($noteDescription) . '</span>';
        echo '<span class="nDate"> <i class="bx bxs-calendar"></i>' . htmlspecialchars($note['notes_date']) . '</span>';
    
        // Hidden fields for full details
        echo '<span class="fulltitle" style="display: none;">' . htmlspecialchars($noteTitle) . '</span>';
        echo '<span class="fullDescription" style="display: none;">' . htmlspecialchars($noteDescription) . '</span>';
    
        // Form for favorite button
        echo '<form action="" method="POST">
                    <input type="hidden" name="faveNoteId" value="' . htmlspecialchars($note['notes_id']) . '">
                    <button type="submit" class="heart-btn">
                        <i class="bx bxs-heart bottom-left" style="color: ' . $heartColor . ';"></i>
                    </button>
              </form>';
    
        // End of the note container for each note
        echo '</div>';
    
        // After the first note, set the flag to false
        $firstNote = false;
    }
} 
else 
{
    die("Query failed: " . implode(" ", $stmt->errorInfo()));
}
?>
</body>
</html>