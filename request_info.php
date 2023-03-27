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
        <div class="request-container book-container">
            <h2 class="request-title user-info-title">Request Information</h2>
            <?php

		if(isset($_POST['submit']))
		{
			$q = mysqli_query($db,"SELECT user.userid,FullName,userpic,books.bookid,bookname,ISBN,price,bookpic,authors.authorname,category.categoryname FROM user inner join temp on user.userid=temp.uid inner join books on temp.bid=books.bookid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid where temp.uid='$_POST[search]';");
			if(mysqli_num_rows($q) == 0)
			{
				echo "Sorry! There's no book request by this user ID";
			}
			else
			{
				echo "<table class='rtable booktable'>";
                echo "<tr style='background-color: teal;'>";
                //Table header
                echo "<th>"; echo "Users"; echo "</th>";
                echo "<th>"; echo "Books"; echo "</th>";
                echo "<th>"; echo "Author Name"; echo "</th>";
                echo "<th>"; echo "Category Name"; echo "</th>";
                echo "<th>"; echo "ISBN"; echo "</th>";
                echo "<th>"; echo "Price"; echo "</th>";
                echo "<th style='padding-left: 40px;'>"; echo "Action"; echo "</th>";
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
                    echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['bookpic']."'>
                        <div>
                            <p>Book ID: ";echo $row['bookid'];echo"</p>
                            <p>";echo $row['bookname'];echo"</p><br>";?>
                        </div>
                    </div>
                    </td><?php
                    echo "<td>"; echo $row['authorname']; echo "</td>";
                    echo "<td>"; echo $row['categoryname']; echo "</td>";
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
                    echo "<td>"; echo $row['price']; echo " INR."; echo "</td>";
                    echo "<td>";?><a href="issue_book.php?ed=<?php echo $row['userid'];?>&ed1=<?php echo $row['bookid'];?>"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default actionbtn">Issue
			        </button>
                    </a>
			        <?php 
			        echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
		    }
		}
			//if button is not pressed
		else
		{
			$res = mysqli_query($db,"SELECT user.userid,FullName,userpic,books.bookid,bookname,ISBN,price,bookpic,authors.authorname,category.categoryname FROM user inner join temp on user.userid=temp.uid inner join books on temp.bid=books.bookid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid ;");
			//var_dump($res);
            if(mysqli_num_rows($res) == 0)
			{
				echo "There's no pending request.";
			}
            else
			{
                echo "<table class='rtable booktable'>";
				echo "<tr style='background-color: teal;'>";
				//Table header
				echo "<th>"; echo "Users"; echo "</th>";
				echo "<th>"; echo "Books"; echo "</th>";
				echo "<th>"; echo "Author Name"; echo "</th>";
				echo "<th>"; echo "Category Name"; echo "</th>";
				echo "<th>"; echo "ISBN"; echo "</th>";
				echo "<th>"; echo "Price"; echo "</th>";
				echo "<th style='padding-left: 40px;'>"; echo "Action"; echo "</th>";
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
						echo "<td>
						<div class='table-info'>
							<img src='images/".$row['bookpic']."'>
							<div>
								<p>Book ID: ";echo $row['bookid'];echo"</p>
								<p>";echo $row['bookname'];echo"</p><br>";?>
							</div>
						</div>
						</td><?php
						echo "<td>"; echo $row['authorname']; echo "</td>";
						echo "<td>"; echo $row['categoryname']; echo "</td>";
						echo "<td>"; echo $row['ISBN']; echo "</td>";
						echo "<td>"; echo $row['price']; echo " INR."; echo "</td>";
						echo "<td>";?><a href="issue_book.php?ed=<?php echo $row['userid'];?>&ed1=<?php echo $row['bookid'];?>"><button style="font-weight:bold;" type="submit" name="submit1" class="btn btn-default actionbtn">Issue
						</button>
						</a>
						
						<?php 
						echo "</td>";
						echo "</tr>";
				}
            echo "</table>";
            }
        }
        ?> 
        </div>
    </div>    
</body>
</html>