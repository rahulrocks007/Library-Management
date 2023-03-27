<?php
	session_start();
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
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php
    if(isset($_SESSION['Logged_in_Email']))
    {
        $var = '<p style="color:yellow; background-color:red;">EXPIRED</p>';
        $r = mysqli_query($db,"SELECT COUNT(status) as total FROM message where status='no' and Email='$_SESSION[Logged_in_Email]' and sender='admin';");
        $c = mysqli_fetch_assoc($r);
        $b = mysqli_query($db,"SELECT * FROM issueinfo where userid='$_SESSION[userid]' ORDER BY returndate ASC limit 0,1;");
        $var1 = mysqli_num_rows($b);
        $bi = mysqli_fetch_assoc($b);
        ?>
        <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                   <a href="index.php"><img src="images/logo2.jpg" alt="Logo" style="border-radius: 50%;"></a> 
                </div>
                <div class="title user-title">
                <a href="index.php"><h3 style="font-size: 15px;">Online Library Management System</h3></a>
                </div>
                <div class="user-navbar">
                
                    <ul id="menuitems">
                    <?php
                    if($var1 == 1)
					{
                        $t = mysqli_query($db,"SELECT * FROM issueinfo where userid='$_SESSION[userid]' and bookid='$bi[bookid]';");
                        $res = mysqli_fetch_assoc($t);
					} 
					?>
                        <li><p style="color: #ff1509; font-size:20px; font-weight: bold;padding-right:10px;" id='demo'></p></li>
                        <li><a href="user_dashboard.php" >Dashboard</a></li>
                        <li><a href="user_books.php" >Books</a></li>
                        <li><a href="request_book.php" >Requested Books</a></li>
                        <li><a href="user_issue_info.php" >Issue Info</a></li>
                        <li><a href="feedback.php" >Feedback</a></li>
                        <li><a href="message.php" id="envelope" ><i class="fas fa-envelope"></i>
                        <?php
                        if($c['total'] > 0 && $c['total'] <= 9)
						{
                            ?>
                            <sup style="border-radius: 50px; background-color: red; padding: 0 5px;"><?php echo $c['total'];?></sup>
                            <?php
                        }
                        else if($c['total'] > 9)
						{
                            ?>
                            <sup style="border-radius: 50px; background-color: red; padding: 0 5px;">9+</sup>
                            <?php
                        }
                        ?>
                        </a></li>
                        <li class="dropdown">
                            <button onclick="myFunction()" class="dropbtn">
                            <?php
                                echo "<img class='user-img' src='images/".$_SESSION['pic']."'>";
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$_SESSION['Logged_in_Email'];
                            ?>&nbsp;&nbsp;<i class="fas fa-caret-down"></i></button>
                            <ul class="dropdown-content" id="myDropdown">
                                <li><a href="profile.php">My Profile</a></li>
                                <li><a href="user_update_password.php">Change Password</a></li>
                                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> &nbsp; Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    else
    {
        ?>
        <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                   <a href="index.php"><img src="images/logo2.jpg" alt="Logo" style="border-radius: 50%;"></a> 
                </div>
                <div class="title">
                <a href="index.php"><h3>Online Library Management System</h3></a>
                </div>
                <nav>
                    <ul id="menuitems">
                        <li><a href="index.php"><i class="fas fa-home"></i>  Home</a></li>
                        <li><a href="index_books.php"><i class="fas fa-book"></i> Books</a></li>
                        <li><a href="admin.php"><i class="fas fa-user-shield"></i> Admin</a></li>
                        <li><a href="user.php"><i class="fas fa-users"></i> User</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        </div>
        <?php
    }
?>
    <script>
        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
    <script>
        const currentlocation = location.href;
        const menuitem = document.querySelectorAll('a');
        const menulength = menuitem.length;
        for(let i=0; i<menulength;i++){
            if(menuitem[i].href===currentlocation){
                menuitem[i].className = "active";
            }
        }
    </script>
</body>
</html>