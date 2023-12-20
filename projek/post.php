<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>
<body>
    <h2>Create Post</h2>
    <form action="post_process.php" method="post" enctype="multipart/form-data">
        Content: <textarea name="content" required></textarea><br>
        Image: <input type="file" name="image"><br>
        <input type="submit" value="Post">
    </form>
</body>
</html>
