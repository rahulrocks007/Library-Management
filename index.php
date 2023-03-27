<?php

    include "connection.php";
    include "index_navbar.php";
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="banner">
        <div class="banner-content">
            <h1>Welcome to Library</h1>
        </div>
    </div>
    <div class="trending-books all-books">
        <div class="small-container">
            <h2 class="co-title">Trending Books</h2>
            <div class="row">
            <?php
                $res = mysqli_query($db,"SELECT books.bookid,books.bookpic,books.bookname,category.categoryname,authors.authorname,books.ISBN,books.price,quantity from  `books` join `category` on category.categoryid=books.categoryid join `authors` on authors.authorid=books.authorid join trendingbook on trendingbook.bookid=books.bookid;");
                while($row = mysqli_fetch_assoc($res))
				{
                    ?>
                    <div class="card">
                        <?php
                            echo "<img src='images/".$row['bookpic']."'>";
                        ?>
                        <div class="card-body">
                            <h4 style="font-size: 18px;">
                                <?php
                                    echo $row['bookname'];
                                ?></h4>
                                <p style="font-size: 18px">Price: 
                                <?php
                                    echo $row['price'];
                                ?> INR.</p>
                            
                            <div class="overlay"></div>
                            <div class="sub-card">
                            <p><b>Book Name: &nbsp;</b> 
                            <?php
                                echo $row['bookname'];
                            ?></p>  
                            <p><b>Category Name: &nbsp;</b> 
                            <?php
                                echo $row['categoryname'];
                            ?></p>
                            <p><b>Author Name: &nbsp;</b> 
                            <?php
                                echo $row['authorname'];
                            ?></p>
                            <p><b>ISBN: &nbsp;</b> 
                            <?php
                                echo $row['ISBN'];
                            ?></p>
                            <p><b>Quantity: &nbsp;</b> 
                            <?php
                                echo $row['quantity'];
                            ?></p>
                            <p><b>Price:</b> 
                            <?php
                                echo $row['price'];
                            ?> INR.</p> 
                            <p><b>Status: &nbsp;</b>
                            <span>
                            <?php
                                if($row['quantity'] >= 1)
								{
									echo "Available";
								}
								else
								{
									echo "Not Available";
								}
                            ?></span> </p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
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
</body>
</html>