// Function to handle search input change
$('#searchInput').off('input').on('input', function() {
    // Get the search query entered by the user
    var searchQuery = $(this).val();
    
    // Send an AJAX request to the server
    $.ajax({
        type: 'GET',
        url: '../php/searchNotes.php', // PHP file handling the search functionality
        data: { search: searchQuery }, // Pass the search query as data
        success: function(response) {
            // Update the noteContentList container with the filtered notes
            $('#listMode').html(response);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});


function handleAllButtonClick() {
    // Set titles
    var logoTitle = document.getElementById('logoTitles');
    var titleName = document.getElementById('logoNames'); 
    var contitleIcon = document.querySelector('.myNotes'); 

    contitleIcon.innerHTML = "<i class='bx bxs-folder folders'></i><span>My Notes</span>";
    logoTitle.innerHTML = "<i class='bx bx-notepad titleLogs'></i>";
    titleName.textContent = "All Notes";



    showNoteContent(firstNoteElement, firstNoteTitle, firstNoteDescription);

    // Function to handle search input change
    $('#searchInput').off('input').on('input', function() {
        // Get the search query entered by the user
        var searchQuery = $(this).val();
        
        // Send an AJAX request to the server
        $.ajax({
            type: 'GET',
            url: '../php/searchNotes.php', // PHP file handling the search functionality
            data: { search: searchQuery }, // Pass the search query as data
            success: function(response) {
                // Update the noteContentList container with the filtered notes
                $('#listMode').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Trigger the search functionality immediately
    $('#searchInput').trigger('input');

    var labelName = document.getElementById('logoNames');
    labelName.textContent = "All Notes"
    labelNames = labelName.textContent.trim()
    console.log(labelNames);

    if (labelNames === "All Notes") 
    {
        console.log("Condition Executed");
        document.getElementById('fsOption').textContent = "Full Screen";
        document.getElementById('fsOption').setAttribute('onclick', 'displayFullScreen()');
        document.getElementById('archiveOption').textContent = "Archive";
        document.getElementById('archiveOption').setAttribute('onclick', 'displayArchiveForm()');
        document.getElementById('editOption').textContent = "Edit";
        document.getElementById('editOption').setAttribute('onclick', 'displayEditForm()');
    }  
}



function handleFavoritesButtonClick() {
    // Function to handle search input change
    $('#searchInput').off('input').on('input', function() {
        // Get the search query entered by the user
        var searchQuery = $(this).val();

        // Send an AJAX request to the server
        $.ajax({
            type: 'GET',
            url: '../php/filterFavorite.php', // PHP file handling the search functionality
            data: { search: searchQuery }, // Pass the search query as data
            success: function(response) {
                // Update the noteContentList container with the filtered notes
                $('#listMode').html(response);

                // Automatically display the content for the first note
                var firstNoteElement = document.querySelector('.noteContainer');
                var firstNoteTitle = firstNoteElement.querySelector('.fulltitle').textContent;
                var firstNoteDescription = firstNoteElement.querySelector('.fullDescription').textContent;
                showNoteContent(firstNoteElement, firstNoteTitle, firstNoteDescription);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Trigger the search functionality immediately
    $('#searchInput').trigger('input');

    // Make an AJAX request to fetch favorites
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../php/filterFavorite.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Update the note content with the response
                document.getElementById("listMode").innerHTML = xhr.responseText;

                //titles
                var logoTitle = document.getElementById('logoTitles');
                var titleName = document.getElementById('logoNames');
                var contitleIcon = document.querySelector('.myNotes'); 

                contitleIcon.innerHTML = "<i class='bx bx-book-heart folders'></i><span>My Favorites</span>";
                logoTitle.innerHTML = "<i class='bx bx-book-heart titleLogs'></i>";
                titleName.textContent = "My Favorite";
            } else {
                console.error("Failed to fetch favorites:", xhr.statusText);
            }
        }
    };
    xhr.send();

    var labelName = document.getElementById('logoNames');
    labelName.textContent = "My Favorite"
    labelNames = labelName.textContent.trim()
    console.log(labelNames);

    if (labelNames === "My Favorite") 
    {
        console.log("Condition Executed");
        document.getElementById('fsOption').textContent = "Full Screen";
        document.getElementById('fsOption').setAttribute('onclick', 'displayFullScreen()');
        document.getElementById('archiveOption').textContent = "Archive";
        document.getElementById('archiveOption').setAttribute('onclick', 'displayArchiveForm()');
        document.getElementById('editOption').textContent = "Edit";
        document.getElementById('editOption').setAttribute('onclick', 'displayEditForm()');
    }  
}


function handleArchiveButtonClick() {
    // Function to handle search input change
    $('#searchInput').off('input').on('input', function() {
        // Get the search query entered by the user
        var searchQuery = $(this).val();

        // Send an AJAX request to the server
        $.ajax({
            type: 'GET',
            url: '../php/filterArchive.php', // PHP file handling the search functionality
            data: { search: searchQuery }, // Pass the search query as data
            success: function(response) {
                // Update the noteContentList container with the filtered notes
                $('#listMode').html(response);

                // Automatically display the content for the first note
                var firstNoteElement = document.querySelector('.noteContainer');
                var firstNoteTitle = firstNoteElement.querySelector('.fulltitle').textContent;
                var firstNoteDescription = firstNoteElement.querySelector('.fullDescription').textContent;
                showNoteContent(firstNoteElement, firstNoteTitle, firstNoteDescription);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Trigger the search functionality immediately
    $('#searchInput').trigger('input');

    // Make an AJAX request to fetch favorites
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../php/filterArchive.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Update the note content with the response
                document.getElementById("listMode").innerHTML = xhr.responseText;

                //titles
                var logoTitle = document.getElementById('logoTitles');
                var titleName = document.getElementById('logoNames');
                var contitleIcon = document.querySelector('.myNotes'); 

                contitleIcon.innerHTML = "<i class='bx bx-archive-in folders'></i><span>My Archive</span>";
                logoTitle.innerHTML = "<i class='bx bx-archive-in titleLogs'></i>";
                //pangbutngan ug titlelogs nga class tanan bx
                titleName.textContent = "Archive";
            } else {
                console.error("Failed to fetch favorites:", xhr.statusText);
            }
        }
    };
    xhr.send();

        var labelName = document.getElementById('logoNames');
        labelName.textContent = "Archive"
        labelNames = labelName.textContent.trim()
        console.log(labelNames);

        if (labelNames === "Archive") 
        {
            console.log("Condition Executed");
            document.getElementById('fsOption').textContent = "Full Screen";
            document.getElementById('fsOption').setAttribute('onclick', 'displayFullScreen()');
            document.getElementById('archiveOption').textContent = "Restore";
            document.getElementById('archiveOption').setAttribute('onclick', 'displayRestoreForm()');
            document.getElementById('editOption').textContent = "Delete";
            document.getElementById('editOption').setAttribute('onclick', 'displayDeleteForm()');
        }  
}

function closeFullScreen() {
    // Get the note content container
    var noteContentContainer = document.querySelector('.noteContentContainer');
    var closebtn = document.getElementById('clsFs')

    closebtn.style.visibility = "hidden"
    // Remove the 'fullscreen' class
    noteContentContainer.classList.remove('fullscreen');
}

function displayFullScreen() {
    // Get the note content container
    var noteContentContainer = document.querySelector('.noteContentContainer');
    var closebtn = document.getElementById('clsFs')

    closebtn.style.visibility = "Visible"
    // Toggle full-screen effect
    noteContentContainer.classList.toggle('fullscreen');
}

function displayLogout() {
    var displayLogout = document.querySelector('.logoutMessageCon');
    displayLogout.style.visibility = "visible";
}

function cancelLogout() {
    var displayLogout = document.querySelector('.logoutMessageCon');
    displayLogout.style.visibility = "hidden";
}

function displayAddForm() 
{
    var displayAdd = document.querySelector('.addForm');
    displayAdd.style.visibility = "visible";
}

function conFirmLogout()
{
    window.location.href = "../logout.php";
}

function displayDeleteForm() {
     // Get the selected note's title and description
     var selectedNoteId = document.getElementById('noteId').textContent;

     // Populate the edit form fields with the selected note's data
     var delTitleId = document.getElementById('idDel'); 
     delTitleId.value = selectedNoteId;
 
     // Display the edit form
     var displaydel = document.querySelector('.mainDelCon');
     displaydel.style.visibility = "visible";

     closeFullScreen();
}

function displayRestoreForm() {
    // Get the selected note's title and description
    var selectedNoteId = document.getElementById('noteId').textContent;

    // Populate the edit form fields with the selected note's data
    var delTitleId = document.getElementById('idRes'); 
    delTitleId.value = selectedNoteId;

    // Display the edit form
    var displaydel = document.querySelector('.mainResCon');
    displaydel.style.visibility = "visible";

    closeFullScreen();
}

function displayEditForm() {
    // Get the selected note's title and description
    var selectedNoteId = document.getElementById('noteId').textContent;
    var selectedNoteTitle = document.getElementById('selectedNoteTitle').textContent;
    var selectedNoteDescription = document.getElementById('selectedNoteDescription').textContent;

    // Populate the edit form fields with the selected note's data
    var editTitleId = document.getElementById('idEdit'); 
    var editTitleInput = document.getElementById('noteTitle1');
    var editDescriptionInput = document.getElementById('noteDescription1');
    editTitleId.value = selectedNoteId;
    editTitleInput.value = selectedNoteTitle;
    editDescriptionInput.value = selectedNoteDescription;

    // Display the edit form
    var displayEdit = document.querySelector('.editForm');
    displayEdit.style.visibility = "visible";

    closeFullScreen();
}

function displayArchiveForm() {
    // Get the selected note's title and description
    var selectedNoteId = document.getElementById('noteId').textContent;

    // Populate the edit form fields with the selected note's data
    var editTitleId = document.getElementById('idArchive'); 
    editTitleId.value = selectedNoteId;

    // Display the edit form
    var displayEdit = document.querySelector('.popUpContainer1');
    displayEdit.style.visibility = "visible";

    closeFullScreen();
}

function cancelForm() 
{
    var displayAdd = document.querySelector('.addForm');
    var displayEdit = document.querySelector('.editForm');
    var displayArchive = document.querySelector('.popUpContainer1');
    var displayDel = document.querySelector('.mainDelCon');
    var displayRes = document.querySelector('.mainResCon');
    displayRes.style.visibility = "hidden";
    displayDel.style.visibility = "hidden";
    displayArchive.style.visibility = "hidden";
    displayAdd.style.visibility = "hidden";
    displayEdit.style.visibility = "hidden";
}

function closePopup() 
{
    window.location.href = '../thankYouPage.php';
}

function closePopup1() 
{
    window.location.href = '../thankYouPage1.php';
}

// Define an object to store original values
var originalValues = {};

function editProfile() {
    var firstNameInput = document.getElementById('fname');
    var lastNameInput = document.getElementById('lname');
    var dobInput = document.getElementById('dob');
    var ageInput = document.getElementById('age');
    var genderInput = document.getElementById('gender');
    var usernameInput = document.getElementById('uname');
    var passwordInput = document.getElementById('pass');
    var emailInput = document.getElementById('emails');
    var profilePicInput = document.getElementById('profPic');
    var submitButton = document.getElementById('submitBtns');

    // Check if inputs are disabled
    var inputsDisabled = firstNameInput.disabled;

    // Toggle disabled attribute
    firstNameInput.disabled = !inputsDisabled;
    lastNameInput.disabled = !inputsDisabled;
    dobInput.disabled = !inputsDisabled;
    ageInput.disabled = !inputsDisabled;
    genderInput.disabled = !inputsDisabled;
    usernameInput.disabled = !inputsDisabled;
    passwordInput.disabled = !inputsDisabled;
    emailInput.disabled = !inputsDisabled;
    profilePicInput.disabled = !inputsDisabled;
    submitButton.disabled = !inputsDisabled;

    // Toggle border style
    if (inputsDisabled) {
        // Store original values if not already stored
        if (!originalValues.hasOwnProperty('fname')) {
            originalValues.fname = firstNameInput.value;
            originalValues.lname = lastNameInput.value;
            originalValues.dob = dobInput.value;
            originalValues.age = ageInput.value;
            originalValues.gender = genderInput.value;
            originalValues.uname = usernameInput.value;
            originalValues.pass = passwordInput.value;
            originalValues.emails = emailInput.value;
        }

        firstNameInput.style.border = '1px solid #1EB9C3';
        lastNameInput.style.border = '1px solid #1EB9C3';
        dobInput.style.border = '1px solid #1EB9C3';
        ageInput.style.border = '1px solid #1EB9C3';
        genderInput.style.border = '1px solid #1EB9C3';
        usernameInput.style.border = '1px solid #1EB9C3';
        passwordInput.style.border = '1px solid #1EB9C3';
        emailInput.style.border = '1px solid #1EB9C3';
        profilePicInput.style.border = '1px solid #1EB9C3';
    } else {
        // Restore original values
        firstNameInput.value = originalValues.fname;
        lastNameInput.value = originalValues.lname;
        dobInput.value = originalValues.dob;
        ageInput.value = originalValues.age;
        genderInput.value = originalValues.gender;
        usernameInput.value = originalValues.uname;
        passwordInput.value = originalValues.pass;
        emailInput.value = originalValues.emails;

        firstNameInput.style.border = 'none';
        lastNameInput.style.border = 'none';
        dobInput.style.border = 'none';
        ageInput.style.border = 'none';
        genderInput.style.border = 'none';
        usernameInput.style.border = 'none';
        passwordInput.style.border = 'none';
        emailInput.style.border = 'none';
        profilePicInput.style.border = 'none';
    }
}


function calculateAge() {
    var dob = document.getElementById('dob').value;
    var dobDate = new Date(dob);
    var today = new Date();
    var age = today.getFullYear() - dobDate.getFullYear();
    var m = today.getMonth() - dobDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
        age--;
    }
    document.getElementById('age').value = age;
}

function showNoteContent(noteElementOrId, title, description) {
    var noteElement;
    if (typeof noteElementOrId === 'string') {
        // If noteElementOrId is a string, assume it's an ID and fetch the corresponding element
        noteElement = document.getElementById(noteElementOrId);
    } else {
        // Otherwise, assume it's already the note element
        noteElement = noteElementOrId;
    }

    // Update the content of the noteId element with the ID of the selected note
    var noteIdElement = document.getElementById('noteId');
    noteIdElement.textContent = noteElement.querySelector('.nId').textContent; // Get the ID from the note container

    // Remove the 'selected' class from all note containers
    var allNotes = document.querySelectorAll('.noteContainer');
    allNotes.forEach(function(note) {
        note.classList.remove('selected');
    });

    // Add the 'selected' class to the clicked note container
    noteElement.classList.add('selected');

    // Display the title and description of the clicked note
    var selectedNoteTitle = document.getElementById('selectedNoteTitle');
    var selectedNoteDescription = document.getElementById('selectedNoteDescription');
    selectedNoteTitle.innerHTML = title;

    // Set the innerHTML of selectedNoteDescription to display the provided description
    selectedNoteDescription.innerHTML = description;
}

// Call showNoteContent for the first note to display its content initially
var firstNoteElement = document.querySelector('.noteContainer');
var firstNoteId = firstNoteElement.querySelector('.nId').textContent; // Get the ID of the first note
var firstNoteTitle = firstNoteElement.querySelector('.fulltitle').innerHTML;
var firstNoteDescription = firstNoteElement.querySelector('.fullDescription').textContent; // Retrieve the full description
showNoteContent(firstNoteElement, firstNoteTitle, firstNoteDescription);


function handleButtonClick(btnIndex) {
    // Remove 'selected' class from all buttons
    var buttons = document.querySelectorAll('.btncon');
    buttons.forEach(function(button) {
        button.classList.remove('selected');
    });

    // Add 'selected' class to the clicked button
    var clickedButton = document.querySelector('.btncon' + btnIndex);
    clickedButton.classList.add('selected');
}
// Set default button as selected
handleButtonClick(1);


//SA ARCHIVE UG EDIT NI DAPITA
document.addEventListener('DOMContentLoaded', function() {
    var optionsIcon = document.getElementById('optionsIcon');
    var optionsContainer = document.getElementById('optionsContainer');

    optionsIcon.addEventListener('click', function() {
        // Toggle visibility of options container
        optionsContainer.style.display = optionsContainer.style.display === 'block' ? 'none' : 'block';
    });

    // Close options container when clicking outside of it
    document.addEventListener('click', function(event) {
        if (!optionsContainer.contains(event.target) && event.target !== optionsIcon) {
            optionsContainer.style.display = 'none';
        }
    });

    // Handle click on archive option
    var archiveOption = document.getElementById('archiveOption');
    archiveOption.addEventListener('click', function() {
        // Your code to handle archive option click
        console.log('Archive option clicked');
        hideOptionsContainer();
    });

    // Handle click on edit option
    var editOption = document.getElementById('editOption');
    editOption.addEventListener('click', function() {
        // Your code to handle edit option click
        console.log('Edit option clicked');
        hideOptionsContainer();
    });

    // Handle click on Full Screen option
    var fsOption = document.getElementById('fsOption');
    fsOption.addEventListener('click', function() {
        // Your code to handle full screen option click
        console.log('Full Screen option clicked');
        hideOptionsContainer();
    });
});

function hideOptionsContainer() {
    // Hide options container immediately
    var optionsContainer = document.getElementById('optionsContainer');
    optionsContainer.style.display = 'none';
}
