<?php
include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
}else{
    $tutor_id = '';
    header('location:login.php');
}

$count_content = $conn->prepare("SELECT * FROM `content` WHERE tutor_id= ?");
$count_content->execute([$tutor_id]);
$total_contents = $count_content->rowCount();

$count_playlist = $conn->prepare("SELECT * FROM `playlists` WHERE tutor_id= ?");
$count_playlist->execute([$tutor_id]);
$total_playlists = $count_playlist->rowCount();

$count_like = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id= ?");
$count_like->execute([$tutor_id]);
$total_likes = $count_like->rowCount();

$count_comment = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id= ?");
$count_comment->execute([$tutor_id]);
$total_comments = $count_comment->rowCount();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

    <!-- Header section link -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Dashboard Section -->

    <section class="dashboard">

        <h1 class="heading">Dashboard</h1>

        <div class="box-container">

            <div class="box">
                <h3>Welcome!</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <a href="profile.php" class="btn">View Profile</a>
            </div>

            <div class="box">
                <h3><?= $total_contents; ?></h3>
                <p>Contents Uploaded</p>
                <a href="add_content.php" class="btn">Add New Content</a>
            </div>

            <div class="box">
                <h3><?= $total_playlists; ?></h3>
                <p>Playlists Uploaded</p>
                <a href="add_playlist.php" class="btn">Add New Playlist</a>
            </div>

            <div class="box">
                <h3><?= $total_likes; ?></h3>
                <p>Total Likes</p>
                <a href="contents.php" class="btn">View Contents</a>
            </div>

            <div class="box">
                <h3><?= $total_comments; ?></h3>
                <p>Total Comments</p>
                <a href="comments.php" class="btn">View Comments</a>
            </div>

            <div class="box">
                <h3>Quick links</h3>
                <p>login or register</p>
                <div class="flex-btn">
                    <a href="login.php" class="option-btn">login</a>
                    <a href="register.php" class="option-btn">register</a>
                </div>
            </div>

        </div>

    </section>

    <!-- Dashboard Section End -->

    <!-- Footer section link -->
    <?php include '../components/footer.php'; ?>

    <!-- Custom JS -->
    <script src="../js/admin.js"></script>
</body>
</html>