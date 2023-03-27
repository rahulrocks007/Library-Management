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
            <input type="search" name='search' placeholder='Search by user ID' required>
            <button type='submit' name='submit'><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="request-table">
        <div class="request-container book-container"  style="max-width: 1600px;">
            <h2 class="request-title user-info-title">Information of issued books</h2>
            <?php
        $e=0;
		if(isset($_POST['submit']))
		{
            $var = '<p style="color:yellow; background-color:red;">EXPIRED</p>';
			$q = mysqli_query($db,"SELECT user.userid,FullName,userpic,books.bookid,bookname,ISBN,price,bookpic,authors.authorname,category.categoryname,issueinfo.issuedate,issued,returned,expired,expectedreturndate,fine FROM user inner join issueinfo on user.userid=issueinfo.userid inner join books on issueinfo.bookid=books.bookid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid where issueinfo.userid='$_POST[search]' ORDER BY `issueinfo`.`expectedreturndate` ASC;");
			if(mysqli_num_rows($q) == 0)
			{
				echo "Sorry! There's no issued book by this user ID";
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
                echo "<th>"; echo "Fine"; echo "</th>";
                echo "<th style='padding-left: 80px;'>"; echo "Action"; echo "</th>";
                echo "</tr>";

                while($row = mysqli_fetch_assoc($q))
                {
					if($row['issued'] == '1' && $row['returned'] == '0')
					{
						$date1 = strtotime(date("Y-m-d"));
						$date2 = strtotime($row['expectedreturndate']);
						$diff = abs($date2 - $date1);
						$years = floor($diff / (365*60*60*24));
						$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
						$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
						$userid = $row['userid'];
						$bookid = $row['bookid'];
						
						if(($date2 - $date1)<0)
						{
							$day = floor($diff/(60*60*24));
							$e=$e+1;
							$var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
							$fine = $day*10;
							mysqli_query($db,"UPDATE issueinfo SET fine=$fine,expired='1' where `expectedreturndate`='$row[expectedreturndate]' and userid=$userid and bookid=$bookid limit $e;");
						}
					
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
						echo "<td>";if($date2 < $date1)
									{ 
										echo "Expired ".$days." Days Ago";
									}
									else
									{
										echo "Not Returned Yet (".$days." Days Remaining)";
									}
									echo "</td>";
						echo "<td>"; echo $row['fine']; echo " INR."; echo "</td>";
						echo "<td>";?><a href="edit_issue_book.php?ed=<?php echo $row['userid'];?>&ed1=<?php echo $row['bookid'];?>"><button style="font-weight:bold; width: 100px;" type="submit" name="submit1" class="btn btn-default actionbtn">Edit
						</button>
						</a>
						<a href="return_book.php?ed=<?php echo $row['userid'];?>&ed1=<?php echo $row['bookid'];?>"><button style="font-weight:bold; width: 100px;" type="submit" name="submit1" class="btn btn-default actionbtn">Return
						</button>
						</a>
						<?php 
						echo "</td>";
						echo "</tr>";
					}
                }
                echo "</table>";
		    }
		}
			//if button is not pressed
		else
		{
			$var = '<p style="color:yellow; background-color:red;">EXPIRED</p>';
			$res = mysqli_query($db,"SELECT user.userid,FullName,userpic,books.bookid,bookname,ISBN,price,bookpic,authors.authorname,category.categoryname,issueinfo.issuedate,issued,returned,issued,expired,expectedreturndate,fine FROM user inner join issueinfo on user.userid=issueinfo.userid inner join books on issueinfo.bookid=books.bookid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid ORDER BY `issueinfo`.`expectedreturndate` ASC;");
            if(mysqli_num_rows($res) == 0)
			{
				echo "There's no issued books.";
			}
            else
			{
                echo "<table class='rtable booktable'>";
				echo "<tr style='background-color: teal;'>";
				//Table header
				echo "<th>"; echo "users"; echo "</th>";
				echo "<th>"; echo "Books"; echo "</th>";
				echo "<th>"; echo "Issue Date"; echo "</th>";
				echo "<th>"; echo "Return Date"; echo "</th>";
				echo "<th>"; echo "Fine"; echo "</th>";
				echo "<th style='padding-left: 80px;'>"; echo "Action"; echo "</th>";
				echo "</tr>";
	
				while($row = mysqli_fetch_assoc($res))
				{
					if($row['issued'] == '1' && $row['returned'] == '0')
					{
						$date1 = strtotime(date("Y-m-d"));
						$date2 = strtotime($row['expectedreturndate']);
						$diff = abs($date2 - $date1);
						$years = floor($diff / (365*60*60*24));
						$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
						$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
						
						$userid = $row['userid'];
						$bookid = $row['bookid'];
						
						if(($date2 - $date1)<0)
						{
							$day = floor($diff/(60*60*24));
							$e=$e+1;
							$var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
							$fine = $day*10;
							mysqli_query($db,"UPDATE issueinfo SET fine=$fine,expired='1' where `expectedreturndate`='$row[expectedreturndate]' and userid=$userid and bookid=$bookid limit $e;");
						}
						
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
						echo "<td>";if($date2 < $date1)
									{
										echo "Expired ".$days." Days Ago";
									}
									else
									{
										echo "Not Returned Yet (".$days." Days Remaining)";
									}
									echo "</td>";
						echo "<td>"; echo $row['fine']; echo " INR."; echo "</td>";
						echo "<td>";?><a href="edit_issue_book.php?ed=<?php echo $row['userid'];?>&ed1=<?php echo $row['bookid'];?>"><button style="font-weight:bold; width: 100px;" type="submit" name="submit1" class="btn btn-default actionbtn">Edit
						</button>
						</a>
						<a href="return_book.php?ed=<?php echo $row['userid'];?>&ed1=<?php echo $row['bookid'];?>"><button style="font-weight:bold; width: 100px;" type="submit" name="submit1" class="btn btn-default actionbtn">Return
						</button>
						</a>
						<?php 
						echo "</td>";
						echo "</tr>";
					}
				}
			echo "</table>";
            }
        }
        ?> 
        </div>
    </div>    
</body>
</html>