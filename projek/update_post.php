<?php
session_start();
require_once 'db.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Jika tidak, mungkin redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Periksa apakah ada data yang dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
    $postId = $_POST['post_id'];
    $newContent = $_POST['content'];

    // Periksa apakah pengguna adalah pemilik posting
    $stmt = $conn->prepare("SELECT user_id, image_path FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    $post = $stmt->fetch();

    if ($post && $post['user_id'] == $_SESSION['user_id']) {
        // Update posting jika pengguna adalah pemiliknya

        // Periksa apakah ada file gambar yang diunggah
        if ($_FILES['image']['name']) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES['image']['name']);

            // Pindahkan file gambar yang diunggah ke direktori uploads
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Hapus gambar lama jika ada
                if ($post['image_path']) {
                    unlink($post['image_path']);
                }

                // Update posting dengan konten dan path gambar yang baru
                $stmt = $conn->prepare("UPDATE posts SET content = ?, image_path = ? WHERE id = ?");
                $stmt->execute([$newContent, $targetFile, $postId]);
            } else {
                echo "Failed to upload image.";
            }
        } else {
            // Update posting tanpa mengubah gambar jika tidak ada file gambar yang diunggah
            $stmt = $conn->prepare("UPDATE posts SET content = ? WHERE id = ?");
            $stmt->execute([$newContent, $postId]);
        }

        echo "Post updated successfully. <a href='dashboard.php'>Go back to dashboard</a>.";
    } else {
        echo "Unable to update post. You are not the owner.";
    }
} else {
    echo "Invalid request.";
}
?>
