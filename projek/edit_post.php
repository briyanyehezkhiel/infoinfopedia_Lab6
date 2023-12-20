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
    $stmt = $conn->prepare("SELECT user_id, content, image_path FROM posts WHERE id = ?");
    $stmt->execute([$postId]);
    $post = $stmt->fetch();

    if ($post && $post['user_id'] == $_SESSION['user_id']) {
        // Formulir edit postingan
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Post</title>
        </head>
        <body>
            <h2>Edit Post</h2>
            <form action="update_post.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
                <textarea name="content" required><?php echo $post['content']; ?></textarea><br>
                <input type="file" name="image"> <!-- Tambahkan input file untuk memilih gambar baru -->
                <?php if ($post['image_path']): ?>
                    <img src="<?php echo $post['image_path']; ?>" alt="Current Image">
                <?php endif; ?>
                <br>
                <input type="submit" value="Update">
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Unable to edit post. You are not the owner.";
    }
} else {
    echo "Invalid request.";
}
?>
