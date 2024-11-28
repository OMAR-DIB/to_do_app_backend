<?php
require "connection.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./style.css">
    <!-- <link rel="stylesheet" href="./style2.css"> -->
    <title>My ToDoApp</title>
  </head>
  <body>

    <header>
      <h1><?php
      // echo $_SESSION['user_id'];
      if (!isset($_SESSION["username"])) {
        header("Location: ./login/login.php"); // Redirect to login page
        exit(); // Ensure no further code is executed
    }
    
      if (isset($_SESSION["username"])) {
            $username = $_SESSION['username'];
          echo  $username . "'s TODO ";
      } 
      
      ?></h1>
      <form action="" method="POST">
        <input type="text"  class="myInput" placeholder="Title..." name="title" required />
        <input type="text"  class="myInput" placeholder="Description..." name="description" required />
        <input name="due_date" type="date" id="" require ></input>
        <select name="category_id" id="">
            <?php
                    $query = "SELECT * FROM `categories` ";

                       $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value=".$row["id"].">".$row['name']."</option>";
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
                      // Convert category name to a CSS-friendly class
                      
                      $category_class = $row["category_name"]; // e.g., "To Do" -> "to-do"

                      echo '<li class="task-card" id='. $category_class .'>';
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
                      echo '</li>';
                  }
            ?>
        </ul>

        <div class="logout-container">
            <?php
         if (isset($_SESSION['user_id'])) {

            echo '<a href="logout.php"><button class="button logout">Logout</button></a>';
         }
        ?>
         </div>
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
        $task_title = $_POST["title"];
        $task_description = $_POST["description"];
        $task_category = $_POST['category_id'];
        $task_due_date = $_POST["due_date"];
        $user_id = intval($_SESSION['user_id']);

        $query = "INSERT INTO tasks (user_id, category_id, title, description, due_date) 
                  VALUES ($user_id, $task_category, '$task_title', '$task_description', '$task_due_date')";

        if (mysqli_query($conn, $query)) {
            echo "Task added successfully!";
            
            unset($_POST);
            
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

