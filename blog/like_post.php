<?php
session_start();
include 'db_connect.php'; // Include database connection

// Ensure the request is a POST request and the user is logged in
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login
    $post_id = $_POST['post_id'];

    // Check if the user has already liked this post
    $check_stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
    $check_stmt->bind_param("ii", $user_id, $post_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // User has already liked this post
        echo json_encode(['status' => 'error', 'message' => 'You have already liked this post']);
    } else {
        // Insert like into the likes table
        $like_stmt = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
        $like_stmt->bind_param("ii", $user_id, $post_id);
        if ($like_stmt->execute()) {
            // Increment like count in posts table
            $update_stmt = $conn->prepare("UPDATE posts SET likes = likes + 1 WHERE id = ?");
            $update_stmt->bind_param("i", $post_id);
            if ($update_stmt->execute()) {
                // Fetch new like count
                $new_like_count_stmt = $conn->prepare("SELECT likes FROM posts WHERE id = ?");
                $new_like_count_stmt->bind_param("i", $post_id);
                $new_like_count_stmt->execute();
                $like_result = $new_like_count_stmt->get_result();
                $post = $like_result->fetch_assoc();

                // Return success response with new like count
                echo json_encode(['status' => 'success', 'newLikeCount' => $post['likes']]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error updating like count']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error liking post']);
        }
    }
} else {
    // Invalid request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}

// Close the database connection
$conn->close();
?>
