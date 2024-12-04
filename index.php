<?php
require "connection.php";
session_start();

// Language handling
$_SESSION['lang'] = $_SESSION['lang'] ?? 'en';
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Include language file
include "lang/" . $_SESSION['lang'] . ".php";

// Redirect to login if not logged in
if (!isset($_SESSION["username"])) {
    header("Location: ./login/login.php");
    exit();
}

// Get theme from session or set default to light-mode
$theme = isset($_SESSION['theme']) ? $_SESSION['theme'] : 'light-mode';
?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./style/style.css">
    <style>
        .language-switcher a {
            display: inline-block;
            margin: 0 2px;
            padding: 3px 3px;
            text-decoration: none;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
            background-color: #2d3e51;
            border: 2px solid transparent;
            border-radius: 5px;
            transition: background-color 0.3s, border-color 0.3s;
        }
    </style>
    <title><?php echo $lang['title']; ?></title>
</head>

<body class="<?php echo $theme; ?>">
    <?php include "popup.php"; ?>

    <header class="<?php echo $theme; ?>">
        <div class="language-switcher">
            <a href="?lang=en" class="selected">English</a>
            <a href="?lang=es">Español</a>
        </div>
        <h1>
            <?php
            $username = $_SESSION['username'];
            echo htmlspecialchars($username) . "'s TODO ";
            ?>
        </h1>
        <form action="index.php" method="POST">
            <input type="text" class="myInput" placeholder="<?php echo $lang['title_placeholder']; ?>" name="title" required />
            <input type="text" class="myInput" placeholder="<?php echo $lang['description_placeholder']; ?>" name="description" required />
            <input name="due_date" type="date" required />
            <select name="category_id" id="">
                <?php
                $query = "SELECT * FROM `categories`";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value=" . $row["id"] . ">" . htmlspecialchars($row['name']) . "</option>";
                }
                ?>
            </select>
            <button class="button add <?php echo $theme; ?>" type="submit"><?php echo $lang['add_task']; ?></button>
        </form>
    </header>

    <div class="container <?php echo $theme; ?>">
        <div class="task-filter">
            <input
                type="text"
                id="taskFilterInput"
                placeholder="<?php echo $lang['search_placeholder']; ?>"
                class="filter-input"
                onkeyup="searchTask(this.value)" />
        </div>
        <ul class="list-container" id="result">
            <?php
            $user_id = $_SESSION['user_id'];
            $query = "SELECT tasks.*, categories.name AS category_name FROM tasks 
                      JOIN categories ON tasks.category_id = categories.id 
                      WHERE tasks.user_id = $user_id";

            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_array($result)) {
                $category_class = strtolower($row["category_name"]);
                echo '<li class="task-card ' . $theme . '" id="' . htmlspecialchars($category_class) . '">';
                echo '<div class="mark">';
                if ($category_class === "done") {
                    echo '<span class="checkmark">✔</span>';
                } elseif ($category_class === "todo") {
                    echo '<span class="todo-indicator">⚡</span>';
                }
                echo '</div>';
                echo '<div class="task-design">';
                echo '<div class="task-details">';
                echo '<div class="task-title">' . $lang['task_title'] . ' ' . htmlspecialchars($row["title"]) . '</div>';
                echo '<div class="task-description">' . $lang['task_description'] . ' ' . htmlspecialchars($row["description"]) . '</div>';
                echo '<div class="task-due-date">' . $lang['task_due_date'] . ' ' . htmlspecialchars($row["due_date"] ?? 'Not specified') . '</div>';
                echo '</div>';
                echo '<div class="task-actions">';
                echo '<form action="updateTask.php" method="GET" style="display: inline;">';
                echo '<input type="hidden" name="task_id" value="' . htmlspecialchars($row["id"]) . '">';
                echo '<button class="button update ' . $theme . '" type="submit">' . $lang['update_button'] . '</button>';
                echo '</form>';
                echo '<form action="deleteTask.php" method="POST" style="display: inline;">';
                echo '<input type="hidden" name="task_id" value="' . htmlspecialchars($row["id"]) . '">';
                echo '<button class="button delete ' . $theme . '" type="submit">' . $lang['delete_button'] . '</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>
    <div class="logout-container">
        <img id="themeToggle" class="light-dark" src="./assets/night-mode.png" alt="light-dark">
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="logout.php"><img class="button logout ' . $theme . '" src="./assets/logout.svg" alt="logout"></a>';
        }
        ?>
    </div>
    <script src="./js/main.js"></script>
    <script>
        function searchTask(str) {
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    document.getElementById("result").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "./api/searchByName.php?task_title=" + str, true);
            xmlhttp.send();
        }
    </script>
</body>

</html>

<!-- Rest of the existing PHP code remains the same -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["due_date"])) {
        $task_title = mysqli_real_escape_string($conn, $_POST["title"]);
        $task_description = mysqli_real_escape_string($conn, $_POST["description"]);
        $task_category = intval($_POST['category_id']);
        $task_due_date = mysqli_real_escape_string($conn, $_POST["due_date"]);
        $user_id = intval($_SESSION['user_id']);

        $query = "INSERT INTO tasks (user_id, category_id, title, description, due_date) 
                  VALUES ($user_id, $task_category, '$task_title', '$task_description', '$task_due_date')";

        if (mysqli_query($conn, $query)) {
            // Remove any echo statements
            $_POST = []; // Clear POST data
            header("Location: " . $_SERVER['PHP_SELF']);
            exit(); // Ensure script stops after redirect
        } else {
            error_log("Error adding task: " . mysqli_error($conn));
        }
    }
}
?>