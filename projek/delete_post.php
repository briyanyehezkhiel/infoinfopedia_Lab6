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

    // Periksa apakah pengguna adalah pemilik posting
    $stmt = $conn->prepare("SELECT user_id FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    $post = $stmt->fetch();

    if ($post && $post['user_id'] == $_SESSION['user_id']) {
        // Hapus posting jika pengguna adalah pemiliknya
        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$postId]);

        echo "Post deleted successfully.";
    } else {
        echo "Unable to delete post. You are not the owner.";
    }
} else {
    echo "Invalid request.";
}
?>
