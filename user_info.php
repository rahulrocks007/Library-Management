<?php
	include "connection.php";
    include "admin_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="search-bar admin-search">
        <form action="" method='post'>
            <input type="search" name='search' placeholder='Search by User ID' required>
            <button type='submit' name='submit'><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="request-table">
        <div class="request-container">
            <h2 class="request-title user-info-title">List of Users</h2>
            <?php

		if(isset($_POST['submit']))
		{
			$q = mysqli_query($db,"SELECT userid,FullName,Email,PhoneNumber,userpic FROM  `user` where userid ='$_POST[search]';");
			if(mysqli_num_rows($q) == 0)
			{
				echo "Sorry! No user found. Try searching again";
			}
			else
			{
				echo "<table class='rtable'>";
                echo "<tr style='background-color: teal;'>";
                //Table header
                echo "<th>"; echo "Users"; echo "</th>";
                echo "<th>"; echo "Email"; echo "</th>";
                echo "<th>"; echo "Phone Number"; echo "</th>";
                echo "</tr>";

                while($row = mysqli_fetch_assoc($q))
                {
                    echo "<tr>";
                    echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['userpic']."'>
                        <div>
                            <p>User ID: ";echo $row['userid'];echo"</p>
                            <p>";echo $row['FullName'];echo"</p><br>";?>
                        </div>
                    </div>
                    </td><?php
                    echo "<td>"; echo $row['Email']; echo "</td>";
                    echo "<td>"; echo $row['PhoneNumber']; echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
		    }
		}
			//if button is not pressed
		else
		{
			$res = mysqli_query($db,"SELECT userid,FullName,Email,PhoneNumber,userpic FROM `user`;");
            echo "<table class='rtable'>";
            echo "<tr style='background-color: teal;'>";
            //Table header
            echo "<th>"; echo "Users"; echo "</th>";
            echo "<th>"; echo "Email"; echo "</th>";
            echo "<th>"; echo "Phone Number"; echo "</th>";
            echo "</tr>";

            while($row = mysqli_fetch_assoc($res))
            {
                echo "<tr>";
                echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['userpic']."'>
                        <div>
                            <p>User ID: ";echo $row['userid'];echo"</p>
                            <p>";echo $row['FullName'];echo"</p><br>";?>
                        </div>
                    </div>
                    </td><?php
                echo "<td>"; echo $row['Email']; echo "</td>";
                echo "<td>"; echo $row['PhoneNumber']; echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?> 
        </div>
    </div>
</body>
</html>