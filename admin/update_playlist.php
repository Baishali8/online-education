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

    $update_playlist = $conn->prepare("UPDATE `playlists` SET title = ?, description = ?, status = ? WHERE id = ?");
    $update_playlist->execute([$title, $description, $status, $get_id]);
    $message[] = 'Playlist Updated';
    
    $old_thumb = $_POST['old_thumb'];
    $old_thumb = filter_var($old_thumb, FILTER_SANITIZE_STRING);
    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_folder = '../uploaded_files/'.$rename;

    if(!empty($thumb)){
        if($thumb_size > 2000000){
            $message[] = 'image size is too large!';
        }else{
            $update_thumb = $conn->prepare("UPDATE `playlists` SET thumb = ? WHERE id = ?");
            $update_thumb->execute([$rename, $get_id]);
            move_uploaded_file($thumb_tmp_name, $thumb_folder);
            if($old_thumb != '' AND $old_thumb != $rename){
                    unlink('../uploaded_files/'.$old_thumb);
            }
        }
    }
}

if(isset($_POST['delete_playlist'])){

    $verify_playlist = $conn->prepare("SELECT * FROM `playlists` WHERE id = ?");
    $verify_playlist->execute([$get_id]);

    if($verify_playlist->rowCount() > 0){
        $fetch_thumb = $verify_playlist->fetch(PDO::FETCH_ASSOC);
        $prev_thumb = $fetch_thumb['thumb'];

        if($prev_thumb != ''){
            unlink('../uploaded_files/'.$prev_thumb);
        }
        $delete_bookmark = $conn->prepare("DELETE FROM `bookmarks` WHERE playlist_id = ?");
        $delete_bookmark->execute([$get_id]);
        $delete_playlist = $conn->prepare("DELETE FROM `playlists` WHERE id = ?");
        $delete_playlist->execute([$get_id]);
        header('location:playlists.php');
    }else{
        $message[] = 'playlist was already deleted';
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Playlist</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

    <!-- Header section link -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Update Playlist Starts -->

    <section class="crud-form">
        <h1 class="heading">Update playlists</h1>

        <?php
            $select_playlist = $conn->prepare("SELECT * FROM `playlists` WHERE id = ?");
            $select_playlist->execute([$get_id]);

            if($select_playlist->rowCount() > 0){
                while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)){
                    $playlist_id = $fetch_playlist['id'];


            ?>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="old_thumb" value="<?= $fetch_playlist['thumb']; ?>">
            <p>Update Status</p>
            <select name="status" class="box" required>
                <option  value="<?= $fetch_playlist['status']; ?>" selected><?= $fetch_playlist['status']; ?></option>
                <option  value="Active">Active</option>
                <option  value="Deactive">Deactive</option>
            </select>

            <p>Update Title</p>
            <input type="text" class="box" required name="title" maxlength="100" value="<?= $fetch_playlist['title']; ?>">

            <p>Update Description</p>
            <textarea name="description" class="box" required cols="30" rows="10" placeholder="Enter Description" maxlength="1000"><?= $fetch_playlist['description']; ?></textarea>
             
            <p>Update Thumbnail</p>
            <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" class="media" alt="">
            <input type="file" name="thumb" accept="image/*" class="box">

            <input type="submit" value="Update Playlist" name="update" class="btn">
            <div class="flex-btn">
                <input type="submit" value="Delete Playlist" name="delete_playlist" class="delete-btn">
                <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="option-btn">View Playlist</a>
            </div>
        </form>
        <?php
                }
            }else{
                echo '<p class="empty">No Playlist Found!</p>';
            }
        ?>
    </section>

    <!-- Update Playlist Ends -->

    <!-- Footer section link -->
    <?php include '../components/footer.php'; ?>

    <!-- Custom JS -->
    <script src="../js/admin.js"></script>
</body>
</html>