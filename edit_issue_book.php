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
			
			$userid = $_GET['ed'];
			$bookid = $_GET['ed1'];

            $var = '<p style="color:yellow; background-color:red;">EXPIRED</p>';
			$q = "SELECT user.userid,FullName,userpic,issueinfo.bookid,books.bookname,ISBN,price,bookpic,issuedate,returndate,expectedreturndate,fine,authors.authorname,category.categoryname From issueinfo inner join user on issueinfo.userid=user.userid inner join books on issueinfo.bookid=books.bookid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid where user.userid=$userid and issueinfo.bookid=$bookid";
			$res = mysqli_query($db,$q) or die(mysqli_error());
			$row = mysqli_fetch_assoc($res);
			
			$userid = $row['userid'];
			$userpic = $row['userpic'];
			$FullName = $row['FullName'];
			$bookid = $row['bookid'];
			$bookpic = $row['bookpic'];
			$bookname = $row['bookname'];
			$authorname = $row['authorname'];
			$categoryname = $row['categoryname'];
			$ISBN = $row['ISBN'];
			$price = $row['price'];
			$fine = $row['fine'];
            $issuedate = $row['issuedate'];
			$expectedreturndate = $row['expectedreturndate'];
	    ?>
        <div class="form form-book">
            <div class="form-container edit-form-container issue-book-container edit-book-container">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Edit Issue Info</span>
                    <hr id="indicator" class="add-author">
                </div>
                <form action="" id="loginform" method="post" enctype="multipart/form-data">
                    <div class="label">
                        <?php echo "<img width='50px' height='50px' src='images/".$userpic."'>"?>
                    </div>
                    <div class="label">
                        <label for="userid">User ID : </label>
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
			                echo $price;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="userid">Issue Date : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $issuedate;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="status">Expected Return Date : </label>
                    </div>
                    <input type="date"  name="expectedreturndate" value="<?php echo $expectedreturndate; ?>">
                    <button type="submit" class="btn" name="submit" style="margin-top: 20px;">Update</button> 
                </form>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit']))
        {
			$e = 0;
            $expectedreturndate = $_POST['expectedreturndate'];
			$date1 = strtotime(date("Y-m-d"));
			$date2 = strtotime($expectedreturndate);
			$diff = abs($date2 - $date1);
			$years = floor($diff / (365*60*60*24));
			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
			
			if(($date2 - $date1)<0)
			{
				$day = floor($diff/(60*60*24));
				$e = $e+1;
				$var ='<p style="color:yellow; background-color:red;">EXPIRED</p>';
				$fine = $day*10;
				mysqli_query($db,"UPDATE issueinfo SET fine=$fine,expired='1' where `expectedreturndate`='$row[expectedreturndate]' and userid=$userid and bookid=$bookid limit $e;");
			}
						
            $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
            
            $q1="UPDATE issueinfo SET expectedreturndate='$expectedreturndate',fine='$fine' where bookid=$bookid and userid=".$userid.";";
            
            if(mysqli_query($db,$q1))
            {
                ?>

                <script type="text/javascript">
                    alert("Issued book updated successfully.");
                    window.location="manage_issued_books.php";
                </script>
                <?php
            }
        }
		?>
</body>
</html>