<?php if (isset($_SESSION['welcome_message']) && $_SESSION['welcome_message'] === true): ?>
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="welcomePopup">
        <h2>Welcome Back, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <button onclick="closePopup()">Close</button>
    </div>
    <script>
        // Show the popup when the page loads
        document.addEventListener("DOMContentLoaded", function () {
            const popup = document.getElementById('welcomePopup');
            const overlay = document.getElementById('overlay');
            popup.style.display = 'block';
            overlay.style.display = 'block';
        });

        // Close popup function
        function closePopup() {
            const popup = document.getElementById('welcomePopup');
            const overlay = document.getElementById('overlay');
            popup.style.display = 'none';
            overlay.style.display = 'none';
        }
    </script>
    <style>
        /* Popup styling */
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 2px solid #4caf50;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            display: none;
            z-index: 1000;
        }
        .popup h2 {
            margin: 0 0 10px;
        }
        .popup button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .popup button:hover {
            background-color: #3e8e41;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }
    </style>
<?php unset($_SESSION['welcome_message']); ?>
<?php endif; ?>
