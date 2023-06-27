<?php
include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
}else{
    $tutor_id = '';
    header('location:login.php');
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>

    <!-- Header section link -->
    <?php include '../components/admin_header.php'; ?>

    <section class="contents">

        <h1 class="heading">Content</h1>

        <div class="box-container">
            <?php
                if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
                    $search_box = $_POST['search_box'];

                    $select_content = $conn->prepare("SELECT * FROM `content` WHERE title LIKE '%{$search_box}%' AND tutor_id = ? ORDER BY date DESC");
                    $select_content->execute([$tutor_id]);

                    if($select_content->rowCount() > 0){
                        while($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)){
                            
                ?>
                <div class="box">
                    <div class="flex">
                        <p><i class="fas fa-dot-circle" style="color:<?php if($fetch_content['status']=='Active'){echo 'limegreen';}else{echo 'red';} ?>;"></i><span style="color:<?php if($fetch_content['status']=='Active'){echo 'limegreen';}else{echo 'red';} ?>;"><?= $fetch_content['status']; ?></span></p>
                        <p><i class="fas fa-calendar"></i><span><?= $fetch_content['date']; ?></span></p>
                    </div>
                    <img src="../uploaded_files/<?= $fetch_content['thumb']; ?>" alt="">
                    <h3 class="title"><?= $fetch_content['title']; ?></h3>
                    <a href="view_content.php?get_id=<?= $fetch_content['id']; ?>" class="btn">View Content</a>
                    <form action="" method="POST" class="flex-btn">
                        <input type="hidden" name="content_id" value="<?= $fetch_content['id']; ?>">
                        <a href="update_content.php?get_id=<?= $fetch_content['id']; ?>" class="option-btn">update</a>
                        <input type="submit" value="delete" name="delete_content" class="delete-btn">
                    </form>
                </div>
                <?php
                        }
                    }else{
                        echo '<p class="empty">No Contents was Found!</p>';
                    }
                }else{
                    echo '<p class="empty">Search Something!</p>';
                }
            ?>
            
        </div>

    </section>

    <section class="playlists">
        <h1 class="heading">Playlists</h1>

        <div class="box-container">

            <?php
                if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
                    $search_box = $_POST['search_box'];

                    $select_playlist = $conn->prepare("SELECT * FROM `playlists` WHERE title LIKE '%{$search_box}%' AND tutor_id = ? ORDER BY date DESC");
                    $select_playlist->execute([$tutor_id]);

                    if($select_playlist->rowCount() > 0){
                        while($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)){
                            $playlist_id = $fetch_playlist['id'];

                            $count_content = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
                            $count_content->execute([$playlist_id]);
                            $total_contents = $count_content->rowCount();
            ?>
                <div class="box">
                    <div class="flex">
                        <div><i class="fas fa-dot-circle" style="color:<?php if($fetch_playlist['status']=='Active'){echo 'limegreen';}else{echo 'red';} ?>;"></i><span style="color:<?php if($fetch_playlist['status']=='Active'){echo 'limegreen';}else{echo 'red';} ?>;"><?= $fetch_playlist['status']; ?></span></div>
                        <div><i class="fas fa-calendar"></i><span><?= $fetch_playlist['date']; ?></span></div>
                    </div>
                    <div class="thumb">
                        <span><?= $total_contents; ?></span>
                        <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="">
                    </div>
                    <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
                    <p class="description"><?= $fetch_playlist['description']; ?></p>
                    <form action="" method="POST" class="flex-btn">
                        <input type="hidden" name="delete_id" value="<?= $playlist_id; ?>">
                        <a href="update_playlist.php?get_id=<?= $playlist_id;?>" class="option-btn">Update</a>
                        <input type="submit" value="Delete" name="delete_playlist" class="delete-btn">
                    </form>
                    <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">View Playlist</a>
                </div>

            <?php
                        }
                    }else{
                        echo '<p class="empty">No Playlists Found!</p>';
                    }
                }else{
                    echo '<p class="empty">Search Something!</p>';
                }
            ?>
        </div>
    </section>


    <!-- Footer section link -->
    <?php include '../components/footer.php'; ?>

    <!-- Custom JS -->
    <script src="../js/admin.js"></script>

    <script>

        document.querySelectorAll('.description').forEach(content =>{
            if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
        });
        document.querySelectorAll('.title').forEach(content =>{
            if(content.innerHTML.length > 25) content.innerHTML = content.innerHTML.slice(0, 25);
        });

    </script>
</body>
</html>