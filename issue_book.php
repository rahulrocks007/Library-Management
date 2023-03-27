<?php
	include "connection.php";
    include "admin_navbar.php";
    $res1 = mysqli_query($db,"SELECT * FROM authors");
	$res2 = mysqli_query($db,"SELECT * FROM category");
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
			
			$userid=$_GET['ed'];
			$bookid=$_GET['ed1'];

			$q = "SELECT user.userid,FullName,userpic,temp.bid,books.bookname,ISBN,price,bookpic,authors.authorname,category.categoryname From temp inner join user on temp.uid=user.userid inner join books on temp.bid=books.bookid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid where user.userid=$userid and temp.bid=$bookid";
			$res = mysqli_query($db,$q) or die(mysqli_error());
			
			$row = mysqli_fetch_assoc($res);
			
			$userid=$row['userid'];
			$userpic=$row['userpic'];
			$FullName=$row['FullName'];
			$bookid=$row['bid'];
			$bookpic=$row['bookpic'];
			$bookname=$row['bookname'];
			$authorname=$row['authorname'];
			$categoryname=$row['categoryname'];
			$ISBN=$row['ISBN'];
			$price=$row['price'];
	    ?>
        <div class="form form-book">
            <div class="form-container edit-form-container issue-book-container edit-book-container">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Issue Book</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" id="loginform" method="post" enctype="multipart/form-data">
                    <div class="label">
                        <?php echo "<img width='50px' height='50px' src='images/".$userpic."'>"?>
                    </div>
                    <div class="label">
                        <label for="userid">user ID : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $userid;
			            ?>
                    </b><br>
                    </div> 
                    <div class="label">
                        <label for="userid">Full Name : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $FullName;
			            ?>
                    </b><br>
                    </div> 
                    <div class="label" style="margin-top: 10px;">
                        <?php echo "<img width='50px' height='50px' src='images/".$bookpic."'>"?>
                    </div>
                    <div class="label">
                        <label for="userid">Book ID : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $bookid;
			            ?>
                    </b><br>
                    </div> 
                    <div class="label">
                        <label for="userid">Book Name : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $bookname;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="userid">Author Name : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $authorname;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="userid">Category Name : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $categoryname;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="userid">ISBN : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $ISBN;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="userid">Price : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $price . ' INR';
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="status">Issue Date : </label>
                    </div>
                    <input type="date"  name="issuedate">
                    <button type="submit" class="btn" name="submit" style="margin-top: 20px;">Issue</button> 
                </form>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit']))
        {
            $dbInsertDate = date('Y-m-d H:i:s', strtotime($_POST['issuedate']));
            mysqli_query($db,"INSERT into timer VALUES('$userid','$bookid','$dbInsertDate');");
            $issuedate = $_POST['issuedate'];
			$expectedreturndate = date('Y-m-d H:i:s',strtotime($_POST['issuedate'].' +7 days'));

            $q1 = "INSERT INTO `issueinfo` VALUES('$userid','$bookid','$issuedate','','0','$expectedreturndate','1','0','0');";
            if(mysqli_query($db,$q1))
            {
				mysqli_query($db,"DELETE FROM temp where temp.uid='$userid' and temp.bid='$bookid';");
				$bookres = mysqli_query($db,"SELECT quantity from books where bookid=$bookid;");
				while($bookrow = mysqli_fetch_assoc($bookres))
				{
					if($bookrow['quantity'] == 0)
					{
						?>
						<script type="text/javascript">
							alert("No Book Available.");
							window.location="request_info.php";
						</script>
						<?php
					}
					else
					{
						mysqli_query($db,"UPDATE books SET quantity=quantity-1 where bookid=$bookid;");
					}
				}
                ?>
                <script type="text/javascript">
                    alert("Book issued successfully.");
                    window.location="request_info.php";
                </script>
                <?php
            }
        }
	?>
</body>
</html>