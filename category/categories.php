<?php

// Create Category
function createCategory($name) {
    global $conn;
    $query = "INSERT INTO categories (name) VALUES ('$name')";
    return mysqli_query($conn, $query);
}

// Read Categories
function getCategories() {
    global $conn;
    $query = "SELECT id, name, created_at FROM categories";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Update Category
function updateCategory($id, $name) {
    global $conn;
    $query = "UPDATE categories SET name = '$name' WHERE id = $id";
    return mysqli_query($conn, $query);
}

// Delete Category
function deleteCategory($id) {
    global $conn;
    $query = "DELETE FROM categories WHERE id = $id";
    return mysqli_query($conn, $query);
}
?>
