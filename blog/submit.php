<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect if not logged in
    exit();
}

include 'db_connect.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate form inputs
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $content = $conn->real_escape_string($_POST['content']);
    $date = date('Y-m-d H:i:s');

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    } else {
        $image = NULL; // No image uploaded
    }

    // Insert data into the 'posts' table
    $sql = "INSERT INTO posts (title, author, content, image, date) 
            VALUES ('$title', '$author', '$content', '$image', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "Blog post submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- HTML form for submitting a blog post -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Blog Post</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <input type="text" name="author" placeholder="Author" required>
        <textarea name="content" placeholder="Content" required></textarea>
        <input type="file" name="image">
        <button type="submit">Submit</button>
    </form>
    <style>
       body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    input[type="text"],
    textarea,
    input[type="file"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 16px;
    }

    input[type="file"] {
        border: none;
    }

    button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #0056b3;
    }

    h3 {
        margin-top: 20px;
        border-bottom: 2px solid #007bff;
        padding-bottom: 5px;
    }

    div {
        margin-bottom: 15px;
    }

    #places, #hotels, #restaurants {
        margin-bottom: 20px;
    }

    @media (max-width: 600px) {
        input[type="text"],
        textarea,
        input[type="file"],
        button {
            width: 100%;
        }
    }
    
    </style>
</body>
</html>
