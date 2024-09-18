<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iNote</title>
    <style>
        body {
            background-color: #252424;
        }
                
        .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #252323;
        font-family: 'Inter', sans-serif;
        color: #fff;
        width: 450px;
        height: 200px;   
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1), 0 0 0 1000px rgba(0, 0, 0, 0.95);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 100000; /* Ensures popup is above confetti canvas */
        border-radius: 10px; /* Adds rounded corners for better aesthetics */
        }

        #my-canvas {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        z-index: 100001;
        pointer-events: none; /* Prevent interaction with the confetti */
        }

        .close {
        position: absolute;
        top: 0;
        right: 0;
        padding: 10px 20px;
        background: rgb(237, 147, 58);
        color: #fff;
        cursor: pointer;
        border-top-right-radius: 10px;
        font-weight: bold; /* Make the 'X' button stand out more */
        z-index: 100002; /* Higher z-index for the close button to be clickable */
        }

        .success {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        }

        .bx-check-circle {
        color: #5deb91;
        font-size: 80px;
        }
    </style>
</head>
<body>
         <!-- Popup message -->
         <div class="popup">
            <div class="success">
                <i class='bx bx-check-circle'></i>
                <h2>REGISTERED SUCCESSFULLY</h2>
            </div>
            <b id="close-button" class="close">X</b>
            </div>
        </div>
        <canvas id="my-canvas"></canvas>

        <script src="js/index.min.js"></script>
        <script src="js/script.js"></script>
        <script>
            document.getElementById('close-button').addEventListener('click', function() {
                window.location.href = 'index.php';
            });
        </script>
</body>
</html>