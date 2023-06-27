<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
    header('location:home.php');
}

if(isset($_POST['delete'])){
    if($user_id != ''){
        $delete_id = $_POST['delete_id'];
        $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

        $verify_list = $conn->prepare("SELECT * FROM `bookmarks` WHERE user_id = ? AND playlist_id = ?");
        $verify_list->execute([$user_id, $delete_id]);

        if($verify_list->rowCount() > 0){
            $remove_list = $conn->prepare("DELETE FROM `bookmarks` WHERE user_id = ? AND playlist_id = ?");
            $remove_list->execute([$user_id, $delete_id]);
            $message[] = 'Playlist Removed!';
        }else{
            $message[] = 'Playlist Already Removed!';
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
    <title>Bookmarked</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Header Starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header Ends -->

    <!-- Courses Section -->

    <section class="course">
        <h1 class="heading">Saved Courses</h1>

        <div class="box-container">
            <?php 
                $select_bookmark = $conn->prepare("SELECT * FROM `bookmarks` WHERE user_id = ?");
                $select_bookmark->execute([$user_id]);
                if($select_bookmark->rowCount() > 0){
                    while($fetch_bookmark = $select_bookmark->fetch(PDO::FETCH_ASSOC)){

                $select_courses = $conn->prepare("SELECT * FROM `playlists` WHERE id = ? AND status = ? ORDER BY date DESC");
                $select_courses->execute([$fetch_bookmark['playlist_id'], 'active']);
                if($select_courses->rowCount() > 0){
                    while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
                        $course_id = $fetch_course['id'];

                        $count_course = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
                        $count_course->execute([$course_id]);
                        $total_courses = $count_course->rowCount();

                        $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                        $select_tutor->execute([$fetch_course['tutor_id']]);
                        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
            ?>

                        <div class="box">
                            <div class="tutor">
                                <img src="./uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                                <div>
                                    <h3><?= $fetch_tutor['name']; ?></h3>
                                    <span><?= $fetch_course['date']; ?></span>
                                </div>
                            </div>
                            <div class="thumb">
                                <span><?= $total_courses; ?></span>
                                <img src="./uploaded_files/<?= $fetch_course['thumb']; ?>" alt="">
                            </div>
                            <h3 class="title"><?= $fetch_course['title']; ?></h3>
                            <form action="" method="POST" class="flex-btn">
                                <input type="hidden" name="delete_id" value="<?= $course_id; ?>">
                                <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">View Course</a>
                                <input type="submit" value="Remove" name="delete" class="inline-delete-btn" onclick="return confirm('Remove From Bookmarked?');">
                            </form>
                        </div>

            <?php
                    }
                }else{
                    echo '<p class="empty">No Courses Added Yet!</p>';
                }
              }
            }else{
                echo '<p class="empty">Nothing Bookmarked Yet!</p>';
            }
            ?>

        </div>
    </section>

    <!-- Courses Section End -->

    <!-- Footer Starts -->
    <?php include 'components/footer.php'; ?>
    <!-- Footer Ends -->

    <!-- Custom JS -->
    <script src="js/script.js"></script>

    <script>
        document.querySelectorAll('.title').forEach(content =>{
            if(content.innerHTML.length > 25) content.innerHTML = content.innerHTML.slice(0, 25);
        });
    </script>
</body>
</html>