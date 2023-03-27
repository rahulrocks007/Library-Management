<?php
	include "connection.php";
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
    if(isset($_GET['req']))
	{
		$var = '<p style="color:yellow; background-color:red;">EXPIRED</p>';
		$q = mysqli_query($db,"SELECT userid from user where Email='$_SESSION[Logged_in_Email]';");
		$row = mysqli_fetch_assoc($q);
		$userid = "{$row['userid']}";
		$id = $_GET['req'];
		$tempbook = mysqli_query($db,"SELECT * from temp where uid=$userid and bid=$id;");
		$tempstatus = mysqli_num_rows($tempbook);
		if($tempstatus >= 1)
		{
			?>
			<script type="text/javascript">
				alert("You request is pending wait for approval.");
			</script>
			<script>
            	window.location="user_books.php";
        	</script>
			<?php
		}
		else
		{
			$q2	= mysqli_query($db,"SELECT * from issueinfo where userid=$userid and bookid=$id and issued=1;");
			$q3	= mysqli_query($db,"SELECT * from issueinfo where userid=$userid and issued=1;");
			$total = mysqli_num_rows($q3);
			if($total == 3)
			{
				?>
				<script type="text/javascript">
					alert("You already requested three books. You must return one book first.");
				</script>
				<script>
					window.location="user_books.php";
				</script>
				<?php
			}
			else if(mysqli_num_rows($q2) != 0)
			{
				?>
				<script type="text/javascript">
					alert("You already requested this book. You must return it first.");
				</script>
				<script>
					window.location="user_books.php";
				</script>
				<?php
			}
			else
			{
				$q1 = mysqli_query($db,"SELECT * FROM books where bookid=$id and quantity>=1;");
				if(mysqli_num_rows($q1) != 0)
				{
					$requestedtime = date('Y-m-d H:i:s',time());
					mysqli_query($db,"INSERT INTO temp VALUES('$userid','$id','$requestedtime');");
					$res = mysqli_query($db,"SELECT quantity from books where bookid=$id;");
					while($row = mysqli_fetch_assoc($res))
					{
						if($row['quantity'] == 0)
						{
							?>
							<script type="text/javascript">
								alert("This book is not available you can't request.");
							</script>
							<script>
								window.location="user_books.php";
							</script>
							<?php
						}
					}
						?>
					<script type="text/javascript">
						alert("book Requested successfully.");
					</script>
					<script>
						window.location="user_books.php";
					</script>
					<?php
				}
				else
				{
					?>
					<script type="text/javascript">
						alert("No Books Available.");
					</script>
					<script>
						window.location="user_books.php";
					</script>
					<?php
				}
			}
		}
	}
?>
</body>
</html>
