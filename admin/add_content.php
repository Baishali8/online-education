<?php
include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
}else{
    $tutor_id = '';
    header('location:login.php');
}

if(isset($_POST['submit'])){
    $id = unique_id();
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);

    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    $playlist_id = $_POST['playlist'];
    $playlist_id = filter_var($playlist_id, FILTER_SANITIZE_STRING);
    
    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename_thumb = unique_id().'.'.$thumb_ext;
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_folder = '../uploaded_files/'.$rename_thumb;
    
    $video = $_FILES['thumb']['name'];
    $video = filter_var($video, FILTER_SANITIZE_STRING);
    $video_ext = pathinfo($video, PATHINFO_EXTENSION);
    $rename_video = unique_id().'.'.$video_ext;
    $video_tmp_name = $_FILES['video']['tmp_name'];
    $video_folder = '../uploaded_files/'.$rename_video;

    $verify_content = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ? AND title = ? AND description = ?");
    $verify_content->execute([$tutor_id, $title, $description]);

    if($verify_content->rowCount() > 0){
        $message[] = 'content Already Created!';
    }else{
        if($thumb_size > 2000000){
            $message[] = 'image size is too large!';
        }else{
            $add_content = $conn->prepare("INSERT INTO `content` (id, tutor_id, playlist_id, title, description, video, thumb, status) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
            $add_content->execute([$id, $tutor_id, $playlist_id, $title, $description, $rename_video, $rename_thumb, $status]);
            move_uploaded_file($thumb_tmp_name, $thumb_folder);
            move_uploaded_file($video_tmp_name, $video_folder);
            $message[] = 'New content Created!';
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Content</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

    <!-- Header section link -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Add Content Starts -->

    <section class="crud-form">
        <h1 class="heading">Add Content</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <p>Content Status <span>*</span></p>
            <select name="status" required class="box">
                <option  value="Active">Active</option>
                <option  value="Deactive">Deactive</option>
            </select>

            <p>Content Title <span>*</span></p>
            <input type="text" class="box" name="title" maxlength="100" placeholder="Enter the Content Title">

            <p>Content Description <span>*</span></p>
            <textarea name="description" class="box" cols="30" rows="10" required placeholder="Enter Description" maxlength="1000"></textarea>

            <select name="playlist" class="box" required>
                <option value="" disabled selected>Select Playlist</option>
                <?php
                    $select_playlist = $conn->prepare("SELECT * FROM `playlists` WHERE tutor_id = ?");
                    $select_playlist->execute([$tutor_id]);

                    if($select_playlist->rowCount() > 0){
                        while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)){
                ?>
                <option value="<?= $fetch_playlist['id']; ?>"><?= $fetch_playlist['title']; ?></option>
                <?php 
                        }
                    }else{
                        echo '<option value="" disabled>No Playlist Created Yet!</option>';
                    }
                ?>
            </select>
                
            <p>Select Thumbnail <span>*</span></p>
            <input type="file" name="thumb" required accept="image/*" class="box">
                    
            <p>Select Video <span>*</span></p>
            <input type="file" name="video" required accept="video/*" class="box">

            <input type="submit" value="Add Content" name="submit" class="btn">
        </form>
    </section>

    <!-- Add Content Ends -->

    <!-- Footer section link -->
    <?php include '../components/footer.php'; ?>

    <!-- Custom JS -->
    <script src="../js/admin.js"></script>
</body>
</html>