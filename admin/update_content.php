<?php
include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
}else{
    $tutor_id = '';
    header('location:login.php');
}

if(isset($_GET['get_id'])){
    $get_id = $_GET['get_id'];
}else{
    $get_id = '';
    header('location:playlists.php');
}

if(isset($_POST['update'])){
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);

    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);

    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);

    $playlist_id = $_POST['playlist'];
    $playlist_id = filter_var($playlist_id, FILTER_SANITIZE_STRING);

    $update_content = $conn->prepare("UPDATE `content` SET title = ?, description = ?, status = ? WHERE id = ?");
    $update_content->execute([$title, $description, $status, $get_id]);

    if(!empty($playlist_id)){
        $update_playlist = $conn->prepare("UPDATE `content` SET playlist_id = ? WHERE id = ?");
        $update_playlist->execute([$playlist_id, $get_id]);
    }

    $old_thumb = $_POST['old_thumb'];
    $old_thumb = filter_var($old_thumb, FILTER_SANITIZE_STRING);
    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename_thumb = unique_id().'.'.$thumb_ext;
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_folder = '../uploaded_files/'.$rename_thumb;
    
    if(!empty($thumb)){
        if($thumb_size > 2000000){
            $message[] = 'Image size is too large!';
        }else{
            $update_thumb = $conn("UPDATE `content` SET thumb = ? WHERE id = ?");
            $update_thumb->execute([$rename_thumb, $get_id]);
            move_uploaded_file($thumb_tmp_name, $thumb_folder);
            if($old_thumb != ''){
                unlink('../uploaded_files/'.$old_thumb);
            }
        }
    }

    $old_video = $_POST['old_video'];
    $old_video = filter_var($old_video, FILTER_SANITIZE_STRING);
    $video = $_FILES['thumb']['name'];
    $video = filter_var($video, FILTER_SANITIZE_STRING);
    $video_ext = pathinfo($video, PATHINFO_EXTENSION);
    $rename_video = unique_id().'.'.$video_ext;
    $video_tmp_name = $_FILES['video']['tmp_name'];
    $video_folder = '../uploaded_files/'.$rename_video;

    if(!empty($video)){
        $update_video = $conn("UPDATE `content` SET video = ? WHERE id = ?");
        $update_video->execute([$rename_video, $get_id]);
        move_uploaded_file($video_tmp_name, $video_folder);
        if($old_video != ''){
            unlink('../uploaded_files/'.$old_video);
        }
    }

    $message[] = 'Content Updated Sucessfully!';

}

if(isset($_POST['delete_content'])){
    $delete_id = $_POST['content_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
    $verify_content->execute([$delete_id]);

    if($verify_content->rowCount() > 0){
        $fetch_content = $verify_content->fetch(PDO::FETCH_ASSOC);
        unlink('../uploaded_files/'.$fetch_content['thumb']);
        unlink('../uploaded_files/'.$fetch_content['video']);
        $delete_comment = $conn->prepare("DELETE FROM `comments` WHERE content_id = ?");
        $delete_comment->execute([$delete_id]);
        $delete_likes = $conn->prepare("DELETE FROM `likes` WHERE content_id = ?");
        $delete_likes->execute([$delete_id]);
        $delete_content = $conn->prepare("DELETE FROM `content` WHERE id = ?");
        $delete_content->execute([$delete_id]);
        header('location:contents.php');
    }else{
        $message[] = 'content already deleted!';
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Content</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

    <!-- Header section link -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Update Content Starts -->

    <section class="crud-form">
        <h1 class="heading">Update Content</h1>

        <?php
            $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
            $select_content->execute([$get_id]);

            if($select_content->rowCount() > 0){
                while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){   
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="content_id" value="<?= $fetch_content['id']; ?>">
            <input type="hidden" name="old_video" value="<?= $fetch_content['video']; ?>">
            <input type="hidden" name="old_thumb" value="<?= $fetch_content['thumb']; ?>">

            <p>Content Status</p>
            <select name="status" class="box">
                <option  value="<?= $fetch_content['status']; ?>" selected><?= $fetch_content['status']; ?></option>
                <option  value="Active">Active</option>
                <option  value="Deactive">Deactive</option>
            </select>

            <p>Content Title</p>
            <input type="text" class="box" name="title" maxlength="100" value="<?= $fetch_content['title']; ?>">

            <p>Content Description</p>
            <textarea name="description" class="box" cols="30" rows="10" maxlength="1000"><?= $fetch_content['description']; ?></textarea>

            <p>Select Playlist</p>
            <select name="playlist" class="box"  >
                <option value="<?= $fetch_content['playlist_id']; ?>" selected>Select Playlist</option>
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
                
            <p>Update Thumbnail</p>
            <img src="../uploaded_files/<?= $fetch_content['thumb']; ?>" alt="" class="media">
            <input type="file" name="thumb" accept="image/*" class="box">
            
            <p>Update Video</p>
            <video src="../uploaded_files/<?= $fetch_content['video']; ?>" class="media" controls muted></video>
            <input type="file" name="video" accept="video/*" class="box">

            <input type="submit" value="Update Content" name="update" class="btn">
            <div class="flex-btn">
                <a href="view_content.php?get_id=<?= $get_id; ?>" class="option-btn">View Content</a>
                <input type="submit" value="Delete Content" name="delete_content" class="delete-btn">
            </div>
        </form>

        <?php
                }
            }else{
                echo '<p class="empty">Content Was Not Found!</p>';
            }
        ?>
    </section>

    <!-- Update Content Ends -->

    <!-- Footer section link -->
    <?php include '../components/footer.php'; ?>

    <!-- Custom JS -->
    <script src="../js/admin.js"></script>
</body>
</html>