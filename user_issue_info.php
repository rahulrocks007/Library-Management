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
    <div class="request-table">
        <div class="request-container book-container">
            <h2 class="request-title user-info-title" style="padding-top: 50px;">List of Issued Books</h2>
            <?php
        $e = 0;
	    if(isset($_SESSION['Logged_in_Email']))
		{
			$q1 = mysqli_query($db,"SELECT userid from user where userid='$_SESSION[userid]';");
		    $row = mysqli_fetch_assoc($q1);

			$q = mysqli_query($db,"SELECT books.bookid,books.bookname,books.ISBN,books.bookpic,price,issueinfo.issuedate,issueinfo.expectedreturndate,issueinfo.issued,expired,returned,issueinfo.returndate,
			issueinfo.fine,authors.authorname,category.categoryname,user.userid from  `issueinfo` join `books` on issueinfo.bookid=books.bookid join `user`on user.userid=issueinfo.userid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid where user.userid ='$_SESSION[userid]' and issueinfo.issued='1' ORDER BY `issueinfo`.`expectedreturndate` ASC; ");
			if(mysqli_num_rows($q) == 0)
			{
				echo "There's no issued books";
			}
			else
			{
				$row1 = mysqli_query($db,"SELECT sum(fine),user.userid,FullName,issued from issueinfo join user on user.userid=issueinfo.userid where user.userid ='$_SESSION[userid]';");
                $res1 = mysqli_fetch_assoc($row1);
				
				if(mysqli_num_rows($row1) != 0)
				{
					?>
					<h2 style="padding-left: 1050px;">Your Fine is: &nbsp;<?php echo $res1['sum(fine)'] . " INR.";?></h2>
					<?php
				}
				
				echo "<table class='rtable'>";
				echo "<tr style='background-color: teal;'>";
				echo "<th>"; echo "Books"; echo "</th>";
				echo "<th>"; echo "Author Name"; echo "</th>";
				echo "<th>"; echo "Category Name"; echo "</th>";
				echo "<th>"; echo "ISBN"; echo "</th>";
				echo "<th>"; echo "Issue Date"; echo "</th>";
				echo "<th>"; echo "Return Date"; echo "</th>";
				echo "<th>"; echo "Fine"; echo "</th>";
				echo "</tr>";
		
				while($row = mysqli_fetch_assoc($q))
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
						<img src='images/".$row['bookpic']."'>
						<div>
							<p>";echo $row['bookname'];echo"</p>
							<small>Price: ";echo $row['price'];echo" INR.</small><br>";?>
						</div>
					</div>
					</td><?php
					echo "<td>"; echo $row['authorname']; echo "</td>";
					echo "<td>"; echo $row['categoryname']; echo "</td>";
					echo "<td>"; echo $row['ISBN']; echo "</td>";
					echo "<td>"; echo $row['issuedate']; echo "</td>";
					echo "<td>";if($row['expired'] == '1')
								{
									echo "Expired ".$days." Days Ago";
								}
								elseif($row['issued'] == '1' && $row['expired'] == '0')
								{
									echo "Not Returned Yet (".$days." Days Remaining)";
								}
								elseif($row['returned'] == '1')
								{ 
									echo "Returned on ".$row['returndate'];
								}
								echo "</td>";
					echo "<td>"; echo $row['fine']; echo "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
		}
            ?>
        </div>
    </div>
    <?php
    if(isset($_GET['req']))
	{
		$id = $_GET['req'];
		mysqli_query($db,"DELETE FROM temp where bookid=$id AND userid='$_SESSION[userid]';");
		?>	
		<script type="text/javascript">
			alert("Request Deleted successfully.");
		</script>
		<script type="text/javascript">
			window.location="request_book.php";
	    </script>
		<?php
	}
	?>
</body>
</html>