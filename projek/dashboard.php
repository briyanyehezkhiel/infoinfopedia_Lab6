<?php
session_start();
require_once 'db.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Jika tidak, mungkin redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Pengguna sudah login, tampilkan halaman dashboard

// Ambil semua posting dan informasi pengguna dari database
$search = isset($_GET['search']) ? $_GET['search'] : '';
$stmt = $conn->prepare("SELECT posts.*, users.username 
                        FROM posts 
                        JOIN users ON posts.user_id = users.id 
                        WHERE posts.content LIKE ? OR users.username LIKE ?
                        ORDER BY posts.created_at DESC");
$stmt->execute(["%$search%", "%$search%"]);
$posts = $stmt->fetchAll();
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
     <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <title>Feed</title>
    <style type="text/css">
        .putih {
            background-color: white;
        }
        .navbar {
            width: 100%;
        }
        .isi {
            margin-top: 3%;
        }
    </style>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    

 <nav class="navbar navbar-expand-lg bg-body-tertiary border-gray sticky-top putih ">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
        <img src="src\logo.png" width="150px" height="50px">
    </a>
    <button class="navbar-toggler border-gray" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon border-gray"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php"><img src="src/world.png" width="30px" height="25px"></a>
        </li>
        <!-- <li class="nav-item dropdown bg-second-color">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Kategori
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li> -->
      </ul>
      <form class="">
        
        <span class="fw-bold username"><?php echo $_SESSION['username']; ?></span>
        <button type="button" class="post-button post-button-bg border-0 rounded-circle text-black p-1">
                                    <a href="logout.php"><img src="https://w7.pngwing.com/pngs/857/381/png-transparent-computer-icons-login-logout-angle-text-black-thumbnail.png" width="25" class="p-1">
                                     </a>
                                </button>
        
      </form>
    </div>
  </div>
</nav>

    <!-- akhir navbar -->

    <!-- left bar -->
     <div class="isi bg-light pt-4">
        <div class="container mb-5">
            <div class="row isi"> <!-- isi -->

                    <!-- <div id="left-list" class="col-2 d-flex flex-column">
                        <a class="bg-second-color" href="#">
                            <span class="rounded ">+</span>
                            <span>Create Space</span>
                        </a>
                        <a href="#">
                            <span class="position-relative me-auto">
                                <img src="src/pic1.jpg">
                                <span class="position-absolute top-0 start-50 translate-middle ms-2 p-1 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            </span>
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>
                        <a href="#">
                            <img src="src/pic1.jpg">
                            <span>PhD Advice Hub</span>
                        </a>

                    </div>
                     --><!-- akhir left bar -->
                     
                       <!-- tempat nanya -->
                    <div class="col-7 besar">
                        <div class="bg-white border-gray">
                            <div class="row">
                                <div class="col">    
                                    <!-- <input class="w-75 border-gray text-gray-dark rounded-pill bg-light ps-2 text-start" type="button" value="What do you want to ask or share?"> -->
                                    <form class="d-flex w-75 ps-2 text-start rounded-pill anu" role="search" action="dashboard.php" method="get">
                                    <input class="form-control me-2 cari" type="search" placeholder="search..." aria-label="Search" name="search" id="search"><button class="btn btn-outline-success" type="submit" name="cari" value="Search">Search</button>
                                   </form>
                                </div>
                            </div>
                            <div class="row text-gray-darker pb-2 ps-4 pe-4">
                                <!-- <div class="col text-center border-end hover-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h4l3 3 3-3h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 16h-4.83l-.59.59L12 20.17l-1.59-1.59-.58-.58H5V4h14v14zm-8-3h2v2h-2zm1-8c1.1 0 2 .9 2 2 0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4S8 6.79 8 9h2c0-1.1.9-2 2-2z"/></svg>
                                    <span>Ask</span>
                                </div>
                                <div class="col text-center border-end hover-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><rect fill="none" height="24" width="24"/><path d="M3,10h11v2H3V10z M3,8h11V6H3V8z M3,16h7v-2H3V16z M18.01,12.87l0.71-0.71c0.39-0.39,1.02-0.39,1.41,0l0.71,0.71 c0.39,0.39,0.39,1.02,0,1.41l-0.71,0.71L18.01,12.87z M17.3,13.58l-5.3,5.3V21h2.12l5.3-5.3L17.3,13.58z"/></svg>
                                    <span>Answer</span>
                                </div> -->
                                <div class="col text-center hover-dark">
                                    <a href="post.php" style="text-decoration: none; color: black;"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z"/></svg>
                                    <span>Create Article</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- akhir tempat nanya -->

                        <!-- akhir tempat nanya -->

 <?php if (count($posts) > 0): ?>
        <?php foreach ($posts as $post): ?>
            <div class="bg-white border-gray mt-4">
                            <div class="d-flex pt-2">
                                <div class="col d-flex">
                                    <!-- profil foto disini -->
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold fs-6 username"><?php echo $post['username']; ?></span>
                                        <!-- kategori artikel -->
                                        <span class="text-gray-darker fs-6 kategori"><?php echo $post['created_at']; ?></span>
                                    </div>
                                </div>
                                <?php if (isset($_SESSION['user_id']) && $post['user_id'] == $_SESSION['user_id']): ?>
                   
                                <div class="p-2 text-gray-darker">
                                    <container class="nav-item dropdown bg-second-color">
                                  <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="src/more.png" width="20px" height="20px">
                                  </a>
                                  <ul class="dropdown-menu">
                                    <li><form action="edit_post.php" method="post">
                                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                    <input type="submit" value="Edit">
                                </form></li>
                                <li>
                                    <form action="delete_post.php" method="post">
                                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                        <input type="submit" value="Delete">
                                    </form>
                                </li>
                                  </ul>
                                </li>
                                </div>
                                <?php endif; ?>

                                <div class="p-2 text-gray-darker">
                                    <!-- <button class="btn rounded-circle hover-dark p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="currentColor"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>
                                    </button> -->
                                </div>
                            </div>
                            <div class="post-body pt-2 ps-3">
                               <!--  <div class="post-title fw-bold">
                                    <a class="text-decoration-none text-black" href="#">
                                        inidksdfj
                                    </a>    
                                </div> -->
                                <div class="post-text pt-1">
                                   <?php echo $post['content']; ?>      
                                </div>
                            </div>
                            <div class="post-image pt-2">
                                <?php if ($post['image_path']): ?>
                                <img class="img-fluid" src="<?php echo $post['image_path']; ?>">
                                <?php endif; ?>
                            </div>
                            <div class="post-footer p-2">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="left-button post-button bg-second-color border-0 text-black p-1 like">
                                        <img src="src/like.png" width="20" class="ms-2">
                                        15
                                    </button>
                                    <button type="button" class="right-button post-button bg-second-color border-0 text-black p-1">
                                        <img src="src/dislike.png" width="20" class="me-2">

                                    </button>
                                </div>
                               <!--  <button type="button" class="post-button post-button-bg border-0 rounded-circle text-black p-1">
                                    <img src="src/refresh.png" width="20" class="">
                                    1
                                </button> -->
                                <button type="button" class="post-button post-button-bg border-0 rounded-circle text-black p-1">
                                    <img src="src/komen.png" width="25" class="p-1">
                                    123
                                </button>
                            </div>
                        </div>

        <?php endforeach; ?>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>


 