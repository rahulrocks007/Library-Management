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
        <div class="request-container book-container"  style="max-width: 1600px;">
            <h2 class="request-title user-info-title">List of Returned books</h2>
            <form action="" method="post">
                <button type='submit' name='clear' class="clearbtn">Clear</button>
            </form>
            <?php
		if(isset($_POST['submit']))
		{
            $var = '<p style="color:yellow; background-color:green;">RETURNED</p>';
			$q = mysqli_query($db,"SELECT user.userid,FullName,userpic,books.bookid,bookname,ISBN,price,bookpic,authors.authorname,category.categoryname,issueinfo.issuedate,returned,returndate,fine FROM user inner join issueinfo on user.userid=issueinfo.userid inner join books on issueinfo.bookid=books.bookid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid where issueinfo.userid='$_POST[search]' ORDER BY `issueinfo`.`returndate` DESC;");
			if(mysqli_num_rows($q) == 0)
			{
				echo "Sorry! There's no returned book by this User ID";
			}
			else
			{
				echo "<table class='rtable booktable'>";
                echo "<tr style='background-color: teal;'>";
                //Table header
                echo "<th>"; echo "Users"; echo "</th>";
                echo "<th>"; echo "Books"; echo "</th>";
                echo "<th>"; echo "Issue Date"; echo "</th>";
                echo "<th>"; echo "Return Date"; echo "</th>";
                echo "<th style='padding-left: 0;'>"; echo "Fine"; echo "</th>";
                echo "</tr>";

                while($row = mysqli_fetch_assoc($q))
                {
					if($row['returned'] == 1)
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
						echo "<td>"; echo $row['issuedate']; echo "</td>";
						echo "<td>"; echo $row['returndate']; echo "</td>";
						echo "<td>"; echo $row['fine']; echo " INR."; echo "</td>";
						echo "</tr>";
					}
                }
                echo "</table>";
		    }
		}
			//if button is not pressed
		else
		{
			$var = '<p style="color:yellow; background-color:green;">RETURNED</p>';
			$res = mysqli_query($db,"SELECT user.userid,FullName,userpic,books.bookid,bookname,ISBN,price,bookpic,authors.authorname,category.categoryname,issueinfo.issuedate,returned,returndate,fine FROM user inner join issueinfo on user.userid=issueinfo.userid inner join books on issueinfo.bookid=books.bookid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid ORDER BY `issueinfo`.`returndate` DESC;");
            if(mysqli_num_rows($res) == 0)
			{
				echo "There's no returned books.";
			}
            else
			{
                echo "<table class='rtable booktable'>";
				echo "<tr style='background-color: teal;'>";
				//Table header
				echo "<th>"; echo "Users"; echo "</th>";
				echo "<th>"; echo "Books"; echo "</th>";
				echo "<th>"; echo "Issue Date"; echo "</th>";
				echo "<th>"; echo "Return Date"; echo "</th>";
				echo "<th style='padding-left: 0;'>"; echo "Fine"; echo "</th>";
				echo "</tr>";
	
				while($row = mysqli_fetch_assoc($res))
				{
					if($row['returned'] == 1)
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
								<p>";echo $row['bookname'];echo"</p>";?>
							</div>
						</div>
						</td><?php
						echo "<td>"; echo $row['issuedate']; echo "</td>";
						echo "<td>"; echo $row['returndate']; echo "</td>";
						echo "<td>"; echo $row['fine']; echo " INR."; echo "</td>";
						echo "</tr>";
					}
				}
            echo "</table>";
            }
        }
        if(isset($_POST['clear']))
		{
            $var = '<p style="color:yellow; background-color:green;">RETURNED</p>';
            mysqli_query($db,"DELETE issueinfo FROM issueinfo where returned='1';");
		    ?>	
            <script type="text/javascript">
                alert("Cleared successfully.");
            </script>
            <script type="text/javascript">
                window.location="returned.php";
            </script>
		    <?php
        }
        ?> 
        </div>
    </div>
</body>
</html>