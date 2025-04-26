<?php
session_start();
include 'db_connect.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize the input
    $post_id = $_POST['post_id'];
    $author = htmlspecialchars($_POST['author']);
    $comment = htmlspecialchars($_POST['comment']);
    
    // Insert the comment into the database
    $stmt = $conn->prepare("INSERT INTO comments (post_id, author, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $post_id, $author, $comment);

    if ($stmt->execute()) {
        // Redirect back to the blog post page after successful submission
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
