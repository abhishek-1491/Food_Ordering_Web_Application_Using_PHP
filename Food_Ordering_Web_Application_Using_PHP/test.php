<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foodapp";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle image upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $image_name = $_FILES["image"]["name"];  // Get image name
    $image_tmp = $_FILES["image"]["tmp_name"];  // Get temp file path
    $image_data = file_get_contents($image_tmp);  // Convert image to binary

    // Insert image into database
    $stmt = $conn->prepare("INSERT INTO images (image_name, image_data) VALUES (?, ?)");
    $stmt->bind_param("sb", $image_name, $image_data);
    
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Image uploaded successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Fetch images from database
$result = $conn->query("SELECT id, image_name FROM images");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Image Upload</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        form { margin: 20px; }
        img { margin: 10px; border: 2px solid #ddd; padding: 5px; width: 200px; }
    </style>
</head>
<body>

    <h2>Upload Image</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="image" required>
        <button type="submit">Upload</button>
    </form>

    <h2>Uploaded Images</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
        <p><?php echo $row['image_name']; ?></p>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image_data']); ?>" >
    <?php endwhile; ?>

</body>
</html>

<?php
$conn->close();
?>
