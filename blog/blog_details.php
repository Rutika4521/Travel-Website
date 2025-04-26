<?php
$conn = new mysqli('localhost', 'root', '', 'blog_posts');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$post_id = $_GET['id'];
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();

// Fetch related places, hotels, restaurants
$places_sql = "SELECT * FROM places WHERE post_id = $post_id";
$places = $conn->query($places_sql);

$hotels_sql = "SELECT * FROM hotels WHERE post_id = $post_id";
$hotels = $conn->query($hotels_sql);

$restaurants_sql = "SELECT * FROM restaurants WHERE post_id = $post_id";
$restaurants = $conn->query($restaurants_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $blog['title']; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center"><?php echo $blog['title']; ?></h1>

    <div class="card mb-4">
        <?php if (!empty($blog['image'])): ?>
        <img src="<?php echo $blog['image']; ?>" class="card-img-top img-fluid" alt="Blog Image" style="height: 300px; object-fit: cover;">
        <?php endif; ?>
        <div class="card-body">
            <p class="card-text">By: <?php echo $blog['author']; ?> | Date: <?php echo $blog['date']; ?></p>
            <p><?php echo $blog['content']; ?></p>
        </div>
    </div>

    <!-- Places Section -->
    <?php if ($places->num_rows > 0): ?>
    <h4>Places to Visit:</h4>
    <ul>
        <?php while ($place = $places->fetch_assoc()): ?>
        <li>
            <strong><?php echo $place['name']; ?>:</strong> 
            <?php echo $place['description']; ?>
            <?php if (!empty($place['image'])): ?>
            <div class="place-image mt-2">
                <img src="<?php echo $place['image']; ?>" class="img-fluid" alt="<?php echo $place['name']; ?>" style="height: 150px; object-fit: cover;">
            </div>
            <?php endif; ?>
        </li>
        <?php endwhile; ?>
    </ul>
    <?php endif; ?>

    <!-- Hotels Section -->
    <?php if ($hotels->num_rows > 0): ?>
    <h4>Hotels:</h4>
    <ul>
        <?php while ($hotel = $hotels->fetch_assoc()): ?>
        <li>
            <strong><?php echo $hotel['name']; ?>:</strong> 
            <?php echo $hotel['description']; ?>
            <?php if (!empty($hotel['image'])): ?>
            <div class="hotel-image mt-2">
                <img src="<?php echo $hotel['image']; ?>" class="img-fluid" alt="<?php echo $hotel['name']; ?>" style="height: 150px; object-fit: cover;">
            </div>
            <?php endif; ?>
        </li>
        <?php endwhile; ?>
    </ul>
    <?php endif; ?>

    <!-- Restaurants Section -->
    <?php if ($restaurants->num_rows > 0): ?>
    <h4>Restaurants:</h4>
    <ul>
        <?php while ($restaurant = $restaurants->fetch_assoc()): ?>
        <li>
            <strong><?php echo $restaurant['name']; ?>:</strong> 
            <?php echo $restaurant['description']; ?>
            <?php if (!empty($restaurant['image'])): ?>
            <div class="restaurant-image mt-2">
                <img src="<?php echo $restaurant['image']; ?>" class="img-fluid" alt="<?php echo $restaurant['name']; ?>" style="height: 150px; object-fit: cover;">
            </div>
            <?php endif; ?>
        </li>
        <?php endwhile; ?>
    </ul>
    <?php endif; ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
