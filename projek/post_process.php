<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $userId = $_SESSION['user_id'];

    // Handle image upload
    $imagePath = null;
    if ($_FILES['image']['size'] > 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        $imagePath = $targetFile;
    }

    // Insert post into database
    $stmt = $conn->prepare("INSERT INTO posts (user_id, content, image_path) VALUES (?, ?, ?)");
    $stmt->execute([$userId, $content, $imagePath]);

    echo "Post created successfully. <a href='dashboard.php'>Go back to dashboard</a>.";
}
?>
