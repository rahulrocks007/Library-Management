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
        <div class="request-container">
            <h2 class="request-title">List of Requested Books</h2>
            <?php
	    if(isset($_SESSION['Logged_in_Email']))
		{
			$q1 = mysqli_query($db,"SELECT userid from user where userid='$_SESSION[userid]';");
		    $row = mysqli_fetch_assoc($q1);

			$q = mysqli_query($db,"SELECT books.bookpic,books.bookid,books.bookname,books.ISBN,books.price,books.quantity,authors.authorname,category.categoryname from  `temp` join `books` on temp.bid=books.bookid join `user`on user.userid=temp.uid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid where user.userid ='$_SESSION[userid]' ; ");
			if(mysqli_num_rows($q) == 0)
			{
				echo "There's no pending request";
			}
			else
			{
				echo "<table class='rtable'>";
                echo "<tr style='background-color: teal;'>";
                echo "<th>"; echo "Books"; echo "</th>";
                echo "<th>"; echo "Author Name"; echo "</th>";
                echo "<th>"; echo "Category Name"; echo "</th>";
                echo "<th>"; echo "ISBN"; echo "</th>";
                echo "</tr>";

                while($row = mysqli_fetch_assoc($q))
                {
                    echo "<tr>";
                    // echo "<td>"; echo $row['bookid']; echo "</td>";
                    echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['bookpic']."'>
                        <div>
                            <p>";echo $row['bookname'];echo"</p>
                            <small>Price: ";echo $row['price'];echo" INR.</small><br>";?>
                            <a href="?req=<?php echo $row['bookid'];?>"><button type='submit' name='remove'>Remove</button></a>
                        </div>
                    </div>
                    </td><?php
                    echo "<td>"; echo $row['authorname']; echo "</td>";
                    echo "<td>"; echo $row['categoryname']; echo "</td>";
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
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
		mysqli_query($db,"DELETE FROM temp where bid=$id AND uid = '$_SESSION[userid]';");
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