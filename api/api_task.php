<?php
require_once '../connection.php';
require '../task/task.php';
global $method;

// Utility function to send JSON responses
function sendResponse($status, $message, $data = []) {
    http_response_code($status);
    echo json_encode(["message" => $message, "data" => $data]);
    exit();
}

if ($method === 'GET') {
    // Check if a category ID is provided
    if (isset($_GET['category_id'])) {
        $categoryId = intval($_GET['category_id']);
        $tasks = getTasksByCategoryId($categoryId);
        if ($tasks) {
            sendResponse(200, "Tasks retrieved successfully.", $tasks);
        } else {
            sendResponse(404, "No tasks found for the specified category.");
        }
    } else {
        // Fetch all tasks
        $tasks = getTasks();
        if ($tasks) {
            sendResponse(200, "All tasks retrieved successfully.", $tasks);
        } else {
            sendResponse(404, "No tasks found.");
        }
    }
} else {
    sendResponse(405, "Method not allowed.");
}
?>
