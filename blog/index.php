<?php
include 'db_connect.php'; // Include the database connection

// Fetch blog posts from the 'posts' table
$sql = "SELECT * FROM posts ORDER BY date DESC";
$result = $conn->query($sql);

function userHasLiked($user_id, $post_id, $conn) {
    $stmt = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->bind_param("ii", $user_id, $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0; // Return true if the user has liked the post
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Blogs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background-color: antiquewhite; font-size: xx-large;">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Travel Guide</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Travel Blogs</h1>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($blog = $result->fetch_assoc()): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <?php if (!empty($blog['image'])): ?>
                                <img src="<?php echo $blog['image']; ?>" class="card-img-top img-fluid" alt="Blog Image" style="height: 300px; object-fit: cover;">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $blog['title']; ?></h5>
                                <p class="card-text">By: <?php echo $blog['author']; ?> | Date: <?php echo $blog['date']; ?></p>
                                <p class="card-text"><?php echo substr($blog['content'], 0, 150); ?>...</p>
                                <!-- Like Button -->
                                <button class="like-btn" onclick="likePost(<?php echo $blog['id']; ?>)" 
                                <?php if (isset($_SESSION['user_id']) && userHasLiked($_SESSION['user_id'], $blog['id'], $conn)) { echo 'disabled'; } ?>>❤️</button>

                                <span id="likes_<?php echo $blog['id']; ?>"><?php echo $blog['likes']; ?> Likes</span>


                            </div>
                            <!-- Comments Section -->
                            <div class="card-footer">
                                <h6>Comments</h6>
                                <!-- Comment Form -->
                                <form id="commentForm" method="POST" action="submit_comment.php">
                                    <input type="hidden" name="post_id" value="<?php echo $blog['id']; ?>">
                                    <div class="form-group">
                                        <label for="author">Author</label>
                                        <input type="text" class="form-control" id="author" name="author" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment">Comment</label>
                                        <textarea class="form-control" id="comment" name="comment" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                                </form>

                                <?php
                // Fetch comments for the current post
                $post_id = $blog['id'];
                $comment_sql = "SELECT * FROM comments WHERE post_id = ?";
                $stmt = $conn->prepare($comment_sql);
                $stmt->bind_param("i", $post_id);
                $stmt->execute();
                $comment_result = $stmt->get_result();
                ?>
                <div class="comments-section">
                    <?php if ($comment_result->num_rows > 0): ?>
                        <ul>
                            <?php while ($comment = $comment_result->fetch_assoc()): ?>
                                <li><strong><?php echo htmlspecialchars($comment['author']); ?>:</strong> <?php echo htmlspecialchars($comment['comment']); ?></li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p>No comments yet.</p>
                    <?php endif; ?>
                </div>





                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No blog posts found.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-3 mt-5">
        <p>&copy; 2024 Travel Guide. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#commentForm').submit(function(e) {
                e.preventDefault(); // Prevent default form submission
                
                $.ajax({
                    type: 'POST',
                    url: 'submit_comment.php', // Make sure this is the correct path to your PHP file
                    data: $(this).serialize(),
                    success: function(response) {
                        // Reload comments or append the new comment dynamically
                        $('#commentsList').append('<li><strong>' + response.author + ':</strong> ' + response.comment + '</li>');
                        $('#commentForm')[0].reset(); // Reset the form
                    },
                    error: function() {
                        alert('Error submitting the comment');
                    }
                });
            });
        });

        function likePost(postId) {
            $.ajax({
                type: 'POST',
                url: 'like_post.php',
                data: { post_id: postId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        // Update the like count on the page
                        $('#likes_' + postId).text(response.newLikeCount + ' Likes');
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Error liking the post');
                }
            });
        }


    </script>


</body>
</html>

<?php
// Close the database connection
$conn->close();
