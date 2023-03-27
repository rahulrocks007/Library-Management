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
    <title>Online Library Management System</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <div class="banner">
        <div class="form">
            <div class="form-container">
                <div class="form-btn">
                    <span onclick="login()">Login</span>
                    <span onclick="reg()">Register</span>
                    <hr id="indicator">
                </div>
                <form action="" id="loginform" method="post">
                    <input type="email" placeholder="Email" name="Email" required>
                    <input type="password" placeholder="Password" name="Password" id="Pass" required>
                    <span class='show-hide'><i class="fas fa-eye" id="eye"></i></span>
                    <button type="submit" class="btn" name="login" style="margin-top:-10px;">Login</button>
                    <a href="user_forgot_password.php">Forgot Password?</a>
                    <div class="signup">
                        <p>New to this website?</p><span onclick="reg()">SignUp</span>
                    </div>
                </form>
                <form action="" id="regform" method="post" enctype="multipart/form-data">
                    <input type="text" placeholder="Full Name" name="FullName" required>
                    <input type="email" placeholder="Email" name="Email" required>
                    <input type="password" placeholder="Password" name="Password" id="Pass-reg" style="margin-bottom: 0;" required>
                    <span class='show-hide-reg'><i class="fas fa-eye" id="eye-reg"></i></span>
                    <input type="text" name="PhoneNumber" placeholder="Phone Number" style="margin-top:-15px;" required>
                    <div class="label">
                        <label for="pic">Upload Picture :</label>
                    </div>
                    <input type="file"  name="file" class="file" value="">
                    <button type="submit" class="btn" name="register">Register</button>
                </form>
            </div>
        </div>
    </div>

    <?php
		if(isset($_POST['login']))
		{
			$email = strtolower($_POST['Email']);
			function isValidEmail($email)
            {
                return preg_match('/\A[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}\z/', $email) && preg_match('/^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/', $email);
            }
			
			if(!isValidEmail($email))
			{
				?>
				<script type="text/javascript">
					alert("Email-ID Contains Invalid Characters.");

				</script>
				<?php
			}
			$res = mysqli_query($db,"SELECT * FROM `user` WHERE Email='$email' AND password='$_POST[Password]';");
			$count = mysqli_num_rows($res);
			$row = mysqli_fetch_assoc($res);
			if($count == 0)
			{
				?>
				<script type="text/javascript">
					alert("The Email-ID or password doesn't match.");
				</script>
				<?php
			}
			else
			{
				$_SESSION['Logged_in_Email'] = $_POST['Email'];
				$_SESSION['userid'] = $row['userid'];
                $_SESSION['pic'] = $row['userpic'];
				?>
				<script type="text/javascript">
					window.location="user_dashboard.php";
				</script>
				<?php
			}
		}
	?>
    <?php

    if(isset($_POST['register']))
    {
        $count = 0;
        $sql = "SELECT * from user";
        $res = mysqli_query($db,$sql);
		$tempemail = strtolower($_POST['Email']);
        
		function isValidEmail($tempemail)
        {
            return preg_match('/\A[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}\z/', $tempemail) && preg_match('/^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/', $tempemail);
        }
		
		if(isValidEmail($tempemail))
		{		
			$mail = $tempemail;
			$mail = explode('@', $mail); $mailp = $mail[1];
			if($mailp !== "gmail.com" AND $mailp !== "hotmail.com" AND $mailp !== "rediffmail.com" AND $mailp !== "yahoo.com" AND $mailp !== "yahoo.co.in")
			{
				?>
					<script type="text/javascript">
						alert("Email-ID provider doesn't support.");
	
					</script>
				<?php
			}
			else
			{
				while($row = mysqli_fetch_assoc($res))
				{
					if($row['Email'] == $tempemail)
					{
						$count = $count+1;
					}
				}
				if($count == 0)
				{
					if(!empty($_FILES['file']['name']))
					{
						move_uploaded_file($_FILES['file']['tmp_name'],"images/".$_FILES['file']['name']);
						$pic = $_FILES['file']['name'];
					}
					else
					{
						$pic = "default.png";
					}
					mysqli_query($db,"INSERT INTO `user` VALUES('','$_POST[FullName]','$tempemail','$_POST[Password]','$_POST[PhoneNumber]','$pic');");
					?>
						<script type="text/javascript">
						alert("Registration successful ");
						</script>
					<?php		
				}
				else
				{
					?>
						<script type="text/javascript">
						alert("This Email is already registered.");
						</script>
					<?php
				}
			}
		}
		else
		{
			?>
				<script type="text/javascript">
					alert("Email-ID Contains Invalid Characters.");
				</script>
			<?php
		}		
    }
    ?>
    <script>
        var LoginForm = document.getElementById("loginform");
        var regform = document.getElementById("regform");
        var indicator = document.getElementById("indicator");
        
        function reg(){
            regform.style.transform = "translateX(-365px)";
            LoginForm.style.transform = "translateX(-400px)";
            indicator.style.transform = "translateX(150px)";
        }
        function login(){
            regform.style.transform = "translateX(0px)";
            LoginForm.style.transform = "translateX(0px)";
            indicator.style.transform = "translateX(0px)";
        }
    
    </script>
    <script>
        var pass = document.getElementById("Pass");
        var showbtn = document.getElementById("eye");
        showbtn.addEventListener("click",function(){
            if(pass.type === "password"){
                pass.type = "text";
                showbtn.classList.add("hide");
            }
            else{
                pass.type = "password";
                showbtn.classList.remove("hide");
            }
        });
    </script>
    <script>
        var pass2 = document.getElementById("Pass-reg");
        var showbtn2 = document.getElementById("eye-reg");
        showbtn2.addEventListener("click",function(){
            if(pass2.type === "password"){
                pass2.type = "text";
                showbtn2.classList.add("hide");
            }
            else{
                pass2.type = "password";
                showbtn2.classList.remove("hide");
            }
        });
    </script>
</body>
</html>