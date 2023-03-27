<?php

	include "connection.php";
    include "user_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="edit-profile-container">
    <?php
		$userid=$_SESSION['userid'];
		$q= "SELECT * FROM user where  userid='$_SESSION[userid]'";
		$res=mysqli_query($db,$q) or die(mysqli_error());

		while($row=mysqli_fetch_assoc($res))
		{
			$FullName=$row['FullName'];
			$Email=$row['Email'];
			$PhoneNumber=$row['PhoneNumber'];
		}
	?>
        <div class="form">
            <div class="form-container edit-form-container">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Edit Profile</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" id="loginform" method="post" enctype="multipart/form-data">
                    <div class="label">
                        <label for="userid">User ID : </label>
                        <b style="font-size: 15px;">
                        <?php
			                echo $userid;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="FullName">Full Name : </label>
                    </div>
                    <input type="text"  name="FullName" value="<?php echo $FullName; ?>">
                    <div class="label">
                        <label for="Email">Email : </label>
                    </div>
                    <input type="email"  name="Email" value="<?php echo $Email; ?>">
                    <div class="label">
                        <label for="PhoneNumber">Phone Number : </label>
                    </div>
                    <input type="text" name="PhoneNumber" value="<?php echo $PhoneNumber; ?>">
                    <button type="submit" class="btn" name="change">Update</button>
                </form>
            </div>
        </div>
    </div>
    <?php
		if(isset($_POST['change']))
		{
            $user_email = $_POST['Logged_in_Email'];
			$FullName=$_POST['FullName'];
			$Email=$_POST['Email'];
			$PhoneNumber=$_POST['PhoneNumber'];
			$_SESSION['login_user_username']=$_POST['user_username'];
			$q1="UPDATE user SET FullName='$FullName',Email='$Email',PhoneNumber='$PhoneNumber' where userid='".$_SESSION['userid']."' and Email='".$_SESSION['Logged_in_Email']."';";
			if(mysqli_query($db,$q1))
            {
                ?>
                <script type="text/javascript">
                    alert("Profile is updated successfully.");
                    window.location="profile.php";
                </script>
                <?php
            }
		}
	?>
</body>
</html>