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
    
    $thumb = $_FILES['thumb']['name'];
    $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
    $ext = pathinfo($thumb, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
    $thumb_size = $_FILES['thumb']['size'];
    $thumb_folder = '../uploaded_files/'.$rename;

    $verify_playlist = $conn->prepare("SELECT * FROM `playlists` WHERE tutor_id = ? AND title = ? AND description = ?");
    $verify_playlist->execute([$tutor_id, $title, $description]);

    if($verify_playlist->rowCount() > 0){
        $message[] = 'Playlist Already Created!';
    }else{
        $add_playlist = $conn->prepare("INSERT INTO `playlists` (id, tutor_id, title, description, thumb, status) VALUES(?, ?, ?, ?, ?, ?)");
        $add_playlist->execute([$id, $tutor_id, $title, $description, $rename, $status]);
        move_uploaded_file($thumb_tmp_name, $thumb_folder);
        $message[] = 'New Playlist Created!';
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Playlist</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

    <!-- Header section link -->
    <?php include '../components/admin_header.php'; ?>

    <!-- Add Playlist Starts -->

    <section class="crud-form">
        <h1 class="heading">Add playlists</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <p>Playlist Status <span>*</span></p>
            <select name="status" required class="box">
                <option  value="Active">Active</option>
                <option  value="Deactive">Deactive</option>
            </select>

            <p>Playlist Title <span>*</span></p>
            <input type="text" class="box" name="title" maxlength="100" placeholder="Enter the Playlist Title">

            <p>Playlist Description <span>*</span></p>
            <textarea name="description" class="box" cols="30" rows="10" required placeholder="Enter Description" maxlength="1000"></textarea>
             
            <p>Playlist Thumbnail <span>*</span></p>
            <input type="file" name="thumb" required accept="image/*" class="box">

            <input type="submit" value="Create Playlist" name="submit" class="btn">
        </form>
    </section>

    <!-- Add Playlist Ends -->

    <!-- Footer section link -->
    <?php include '../components/footer.php'; ?>

    <!-- Custom JS -->
    <script src="../js/admin.js"></script>
</body>
</html>