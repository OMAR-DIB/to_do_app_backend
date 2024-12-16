<?php
$messages = [
    "What you think, you become",
    "Upgrade your life in silence",
    "Who better to love you than you?",
    "The most beautiful people wear their hearts on their sleeves and their souls in their smiles",
    "There is a seat waiting for you at tables you haven't even seen",
    "The love you gave was never a waste",
    "Feelings are just visitors, let them come and go",
    "The fears we don't face become our limits",
    "Go laugh in the places you have cried. Change the narrative",
    "The future depends on what you do today",
    "A person can have good qualities and still be toxic for you",
    "It's normal to feel bad after making the right decision",
    "What you feel, you attract",
    "Everybody makes mistakes",
    "Don't let one bad day ruin your whole week",
    "Protect your energy from people who don't value theirs",
    "The most magnetic on earth is liking your own energy",
    "Your biggest enemy is your uncontrolled mind",
    "One who believes in themselves has no need to convince others",
    "Your older self is counting on you. Your younger self is believing in you",
    "Learn who you are. Unlearn who they told you to be",
    "You need to feel at peace more than you need to feel in control",
    "Attract someone who you can meditate with",
    "Choices made in anger cannot be undone",
    "Do everything with a good heart and expect nothing in return",
    "If it makes you happy it doesn't have to make sense to others",
    "Choose people who choose you",
    "Work on you for you",
    "What you imagine, you make",
    "Less ego, more soul",
    "You are not what happened to you, you are what you wish to become",
    "The less you want, the more you have",
    "Having high standards protects you from low quality",
    "When life gives you a new beginning, don't repeat old mistakes",
    "When your intentions are pure, you don't lose people, they lose you",
    "People can only meet you as deeply as they've met themselves",
    "Be private, vibe alone, grow in silence",
    "If you never try, you'll never know. No risk, no story",
    "So many doors will open when you realize that it's okay to start over",
    "Your self-respect has to be stronger than your feelings",
    "Sometimes you need to put yourself first",
    "Actions speak louder than words",
    "Don't live with regrets",
    "Bad days are normal",
    "It's okay to take time off",
    "Every mistake is a lesson",
    "It's okay to do it alone",
    "Mindset matters a lot, improve it every day",
    "Until it's done, tell none",
    "Make yourself proud",
    "Progress is impossible without change",
    "Give your energy to the right person",
    "Your fear of looking stupid is holding you back",
    "The biggest comeback is making yourself feel like yourself again",
    "Do everything with a clear heart"
];
$randomMessage = $messages[array_rand($messages)];
?>
<?php if (isset($_SESSION['welcome_message']) && $_SESSION['welcome_message'] === true): ?>
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="welcomePopup">
        <h2><?php echo htmlspecialchars($randomMessage); ?></h2>
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
    <link rel="stylesheet" href="./style/popup.css">
<?php unset($_SESSION['welcome_message']); ?>
<?php endif; ?>
