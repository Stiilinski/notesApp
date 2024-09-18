<?php
   require_once 'insertNotes.php';

   // Get the search query from the request parameters, if it exists
   $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
   
   // Variable to track if the first note is being iterated
   $firstNote = true;
   

   // Display each note
   foreach ($notes as $note) {
       // Check if the search query matches the note title or description
       if (stripos($note['notes_title'], $searchQuery) !== false || stripos($note['notes_description'], $searchQuery) !== false || empty($searchQuery)) {
           // Check if it's the first note, add 'selected' class
           $class = $firstNote ? 'noteContainer selected' : 'noteContainer';
   
           // Preprocess title and description to handle line breaks and apostrophes
           $noteTitle = htmlspecialchars($note['notes_title']);
           $noteDescription = htmlspecialchars($note['notes_description']);
           $noteTitle = str_replace(array("\n", "\r"), '<br>', $noteTitle);
           $noteDescription = str_replace(array("\n", "\r"), '<br>', $noteDescription);
   
           $heartColor = ($note['notes_favorite'] == 'favorite') ? '#e73a4e' : ''; 
   
           // Escape apostrophes in the title and description
           $noteTitle = str_replace("'", "'", $noteTitle); // Replacing single quote with HTML entity
           $noteDescription = str_replace("'", ",;", $noteDescription); // Replacing single quote with HTML entity
   
           echo "<div class='{$class}' onclick='showNoteContent(this, \"{$noteTitle}\", \"{$noteDescription}\")'>";
           echo '<span class="nId" id="faveId">' . htmlspecialchars($note['notes_id']) . '</span>';
           echo '<span class="nTitle">' . shortentitle($note['notes_title']) . '</span>';
           echo '<span class="nDesc">' . shortenDescription($note['notes_description']) . '</span>';
           echo '<span class="nDate"><i class="bx bxs-calendar"></i>' . htmlspecialchars($note['notes_date']) . '</span>';
           echo '<span class="fulltitle" style="display: none;">' . htmlspecialchars($note['notes_title']) . '</span>';
           echo '<span class="fullDescription" style="display: none;">' . htmlspecialchars($note['notes_description']) . '</span>'; // Hidden span containing the full description
           echo '<form action="" method="POST">
                       <input type="hidden" name="faveNoteId" value="' . $note["notes_id"] . '">
                       <button type="submit" class="heart-btn">
                           <i class="bx bxs-heart bottom-left" style="color: ' . $heartColor . ';"></i>
                       </button>
                   </form>';
           echo '</div>';
   
           // After the first note, set the flag to false
           $firstNote = false;
       }
   }
   
?>
<script src="../js/dashboard.js"></script>