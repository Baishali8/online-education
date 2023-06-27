<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
}

if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
}else{
    $get_id = '';
    header('location:courses.php');
}

if(isset($_POST['save_list'])){
    if($user_id != ''){
        $list_id = $_POST['list_id'];
        $list_id = filter_var($list_id, FILTER_SANITIZE_STRING);

        $verify_list = $conn->prepare("SELECT * FROM `bookmarks` WHERE user_id = ? AND playlist_id = ?");
        $verify_list->execute([$user_id, $list_id]);

        if($verify_list->rowCount() > 0){
            $remove_list = $conn->prepare("DELETE FROM `bookmarks` WHERE user_id = ? AND playlist_id = ?");
            $remove_list->execute([$user_id, $list_id]);
            $message[] = 'Playlist Removed!';
        }else{
            $add_list = $conn->prepare("INSERT INTO `bookmarks`(user_id, playlist_id) VALUES(?,?)");
            $add_list->execute([$user_id, $list_id]);
            $message[] = 'Playlist Saved!';
        }
    }else{
        $message[] = 'Please Login First!';
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Playlists</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Header Starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header Ends -->

    <!-- View Playlist Section -->

    <section class="playlist-details">
        <h1 class="heading">Playlist Details</h1>

        <div class="row">
            <?php
                $select_playlist = $conn->prepare("SELECT * FROM `playlists` WHERE id = ? AND status = ? LIMIT 1");
                $select_playlist->execute([$get_id, 'Active']);
                if($select_playlist->rowCount() > 0){
                    while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)){  
                        $playlist_id = $fetch_playlist['id'];

                        $count_content = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ? AND status = ?");
                        $count_content->execute([$playlist_id, 'Active']);
                        $total_contents = $count_content->rowCount();

                        $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ? LIMIT 1");
                        $select_tutor->execute([$fetch_playlist['tutor_id']]);
                        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

                        $select_bookmark = $conn->prepare("SELECT * FROM `bookmarks` WHERE user_id = ? AND playlist_id = ?");
                        $select_bookmark->execute([$user_id, $playlist_id]);
            ?>
            <div class="col">
                <form action="" method="post">
                    <input type="hidden" name="list_id" value="<?= $playlist_id; ?>">
                    <?php if($select_bookmark->rowCount() > 0){ ?>
                        <button type="submit" name="save_list" class="inline-btn"><i class="fas fa-bookmark"></i><span>Saved</span></button>
                    <?php }else{ ?>
                        <button type="submit" name="save_list" class="inline-option-btn"><i class="far fa-bookmark"></i><span>Save List</span></button>
                    <?php } ?>
                </form>
                <div class="thumb">
                    <span><?= $total_contents; ?></span>
                    <img src="./uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="">
                </div>
            </div>
            <div class="col">
                <div class="tutor">
                    <img src="./uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                    <div>
                        <h3><?= $fetch_tutor['name']; ?></h3>
                        <span><?= $fetch_tutor['profession']; ?></span>
                    </div>
                </div>
                <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
                <p class="description"><?= $fetch_playlist['description']; ?></p>
                <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
            </div>
            <?php
                    }
                }else{
                    echo '<p class="empty">Playlist Was Not Found!</p>';
                }
            ?>
        </div>
    </section>

    <!-- View Playlist Section End -->

    <!-- Playlist Videos Section -->

    <section class="playlist-videos">
        <h1 class="heading">Playlist Video</h1>

        <div class="box-container">
        <?php
            $select_content = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ? AND status = ? ORDER BY date DESC");
            $select_content->execute([$playlist_id, 'Active']);
            if($select_content -> rowCount() > 0){
                while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){
        ?>

        <a href="watch_video.php?get_id=<?= $fetch_content['id']; ?>" class="box">
            <i class="fas fa-play"></i>
            <img src="./uploaded_files/<?= $fetch_content['thumb']; ?>" alt="">
            <h3><?= $fetch_content['title']; ?></h3>
        </a>

        <?php
                }
            }else{
                echo '<p class="empty">Content Not Added Yet!</p>';
            }
        ?>
        </div>
    </section>

    <!-- Playlist Videos Section End -->

    <!-- Footer Starts -->
    <?php include 'components/footer.php'; ?>
    <!-- Footer Ends -->

    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>