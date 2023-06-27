<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
    $user_id = $_COOKIE['user_id'];
}else{
    $user_id = '';
    header('location:home.php');
}

if(isset($_POST['submit'])){
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
    $select_user->execute([$user_id]);
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    if(!empty($name)){
        $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
        $update_name->execute([$name, $user_id]);
        $message[] = 'Name Updated Sucessfully!'; 
    }

    if(!empty($email)){
        $select_user_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select_user_email->execute([$email]);
        if($select_user_email->rowCount() > 0){
            $message[] = 'Email already taken!';
        }else{
            $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
            $update_email->execute([$email, $user_id]);
            $message[] = 'Email Updated Sucessfully!'; 
        }
    }
    
    $prev_img = $fetch_user['image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id().'.'.$ext;
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = './uploaded_files/'.$rename;

    if(!empty($image)){
        if($image_size > 2000000){
            $message[] = 'Image size is too large';
        }else{
            $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
            $update_image->execute([$rename, $user_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            if($prev_img != '' AND $prev_img != $rename){
                unlink('./uploaded_files/'.$prev_img);
            }
            $message[] = 'Image Updated Sucessfully!';
        }
    }

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $prev_pass = $fetch_user['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);

    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

    $c_pass = sha1($_POST['c_pass']);
    $c_pass = filter_var($c_pass, FILTER_SANITIZE_STRING);

    if($old_pass != $empty_pass){
        if($old_pass != $prev_pass){
            $message[] = 'Old Password Not Matched!';
        }elseif($new_pass != $c_pass){
            $message[] = 'Confirm Password Not Matched';
        }else{
            if($new_pass != $empty_pass){
                $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                $update_pass->execute([$c_pass, $user_id]);
                $message[] = 'Password Updated Sucessfully!'; 
            }else{
                $message[] = 'Please Enter New Password';
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>

    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Header Starts -->
    <?php include 'components/user_header.php'; ?>
    <!-- Header Ends -->

    <!-- Update Profile Section -->

    <section class="form-container">

        <form action="" method="post" enctype="multipart/form-data">
            <h3>Update Profile</h3>
            <div class="flex">
                <div class="col">
                    <p>Your Name</p>
                    <input type="text" name="name" class="box" maxlength="50" placeholder="<?= $fetch_profile['name']; ?>">
                    <p>Your Email</p>
                    <input type="email" name="email" class="box" maxlength="50" placeholder="<?= $fetch_profile['email']; ?>">
                    <p>Upload Photo</p>
                    <input type="file" name="image" class="box" accept="image/*">
                </div>
                <div class="col">
                    <p>Old Password</p>
                    <input type="password" name="old_pass" class="box" maxlength="20" placeholder="Enter Old Password">
                    <p>Your Password</p>
                    <input type="password" name="new_pass" class="box" maxlength="20" placeholder="Create new Password">
                    <p>Confirm Password</p>
                    <input type="password" name="c_pass" class="box" maxlength="20" placeholder="Confirm new Password">
                </div>
                
            </div>
            <input type="submit" value="Update" name="submit" class="btn">
        </form>

    </section>

    <!-- Update Profile Section End -->

    <!-- Footer Starts -->
    <?php include 'components/footer.php'; ?>
    <!-- Footer Ends -->

    <!-- Custom JS -->
    <script src="js/script.js"></script>
</body>
</html>