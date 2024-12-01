<?php
require "connection.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./style2.css">
    <title>My ToDoApp</title>
</head>
<body>
    <header>
        <h1>
            <?php
            if (!isset($_SESSION["username"])) {
                header("Location: ./login/login.php");
                exit();
            }
            $username = $_SESSION['username'];
            echo $username . "'s TODO ";
            ?>
        </h1>
        <form action="" method="POST">
            <input type="text" class="myInput" placeholder="Title..." name="title" required />
            <input type="text" class="myInput" placeholder="Description..." name="description" required />
            <input name="due_date" type="date" required />
            <select name="category_id" id="">
                <?php
                $query = "SELECT * FROM `categories`";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value=" . $row["id"] . ">" . $row['name'] . "</option>";
                }
                ?>
            </select>
            <button class="button" type="submit">Add</button>
        </form>
    </header>

    <div class="container">
        <div class="task-filter">
            <input
                type="text"
                id="taskFilterInput"
                placeholder="Search tasks..."
                class="filter-input"
                onkeyup="searchTask(this.value)"
            />
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
                echo '<li class="task-card" id="' . $category_class . '">'; // Add category as ID
                echo '<div class="mark">';
                if ($category_class === "done") {
                    echo '<span class="checkmark">✔</span>'; // Green check for Done
                } elseif ($category_class === "todo") {
                    echo '<span class="todo-indicator">⚡</span>'; // Orange for To Do
                }
                echo '</div>';
                echo '<div class="task-design">';
                echo '<div class="task-details">';
                echo '<div class="task-title">Title: ' . htmlspecialchars($row["title"]) . '</div>';
                echo '<div class="task-description">Description: ' . htmlspecialchars($row["description"]) . '</div>';
                if (!empty($row["due_date"])) {
                    echo '<div class="task-due-date">Due Date: ' . htmlspecialchars($row["due_date"]) . '</div>';
                } else {
                    echo '<div class="task-due-date">Due Date: Not specified</div>';
                }
                echo '</div>';
                echo '<div class="task-actions">';
                echo '<form action="updateTask.php" method="GET" style="display: inline;">';
                echo '<input type="hidden" name="task_id" value="' . $row["id"] . '">';
                echo '<button class="button update" type="submit">Update</button>';
                echo '</form>';
                echo '<form action="deleteTask.php" method="POST" style="display: inline;">';
                echo '<input type="hidden" name="task_id" value="' . $row["id"] . '">';
                echo '<button class="button delete" type="submit">Delete</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</li>';
            }            
            ?>
        </ul>
    </div>
    <div class="logout-container">
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="logout.php"><button class="button logout">Logout</button></a>';
        }
        ?>
    </div>
    <script>     
      function searchTask(str) {

        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("result").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "./api/searchByName.php?task_title="+ str, true);
        xmlhttp.send();
}
    </script>
</body>
</html>

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
            // Handle error without output
            error_log("Error adding task: " . mysqli_error($conn));
        }
    }
}
?>