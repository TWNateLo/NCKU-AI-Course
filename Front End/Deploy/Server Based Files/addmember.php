<!DOCTYPE html>
<html lang="en" class="gr__getbootstrap_com">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="description" content="">
	  <meta name="author" content="">
	  <link rel="icon" href="./image/favicon.ico">
    <title>Add Member</title>
		<!-- Bootstrap core CSS -->
		<link href="./css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="./css/floating-labels.css" rel="stylesheet">

		<script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="./js/bootstrap.min.js"></script>
		<script type="text/javascript" src="./js/popper.min.js"></script>
		<script type="text/javascript" src="./js/tooltip.min.js"></script>
		<script type="text/javascript" src="./js/bootstrap.bundle.min.js"></script>


    <style>
    	/*CSS for user data table*/
		table {
		    font-family: arial, sans-serif;
		    border-collapse: collapse;
		    width: 50%;
		}

		td, th {
		    border: 1px solid #dddddd;
		    text-align: left;
		    padding: 8px;
		}

		tr:nth-child(even) {
		    background-color: #dddddd;
		}
</style>
</head>
<body>
	<?php
		// Get Form data
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$email = $_POST["inputEmail"];
	    $passwd = $_POST["inputPassword"];
	    $confirm_passwd = $_POST["inputCPassword"];
	    $gender = $_POST["inputState"];
		$is_usertype = false;
		$score = 0;
		$lv = 0;

		if($confirm_passwd != $passwd){
			echo "您輸入的密碼不相同 請回上頁重新註冊";
		}
		else{
			echo "您好: "."$firstname"."<br>";
			$is_usertype = true;

			// Connect database
			include_once("dbtool.inc");
			$servername = "localhost";
			$username = "aicourse";
			$password = "";
			$dbname = "aicourse";

	  	    // Check connection
	        $conn = create_connection($servername, $username, $password, $dbname);

	        //Check whether there is same account name
	        $sql = "SELECT * FROM users Where Email = '$email'";
	        $result = $conn->query($sql);

	        // There exists same account
	        if($result->num_rows !=0){
	        	mysqli_free_result($result);
	        	echo "抱歉 您的Email已經註冊過了 請按上一頁重新註冊";
	        }
	        // Unique account
	        else{
	        	echo "註冊成功";
	        	// SQL Insert account and password to user table
	        	$sql = "INSERT INTO users (Email,Firstname,Lastname,Gender,Password,Score,Lv)
				VALUES ('$email','$firstname','$lastname','$gender','$passwd','%score','$lv')";
				//Insert and Check whthere successful
				if ($conn->query($sql) === false) {
				    echo "Error: " . $sql . "<br>" . $conn->error;
				mysqli_free_result($result);
				$conn->close();
	        	}
	    }
		}
?>

<div class="container-fluid form-signin">

	<div class="row">
	<div class="col">
	<div class="col-12 text-center white-font">
	<h3><p style="display: inline;"><?php echo $firstname." "  ;?></p>您註冊的資料如下</h3>

	<table class="table table-hover">
	  <tr>
	    <th scope="col">Gender</th>
	    <th scope="col">Email</th>
	    <th scope="col">Password</th>
	  </tr>
	  <tr>
	    <td><?php echo $gender ?></td>
	    <td><?php echo $email ?></td>
	    <td><?php echo $passwd ?></td>
	  </tr>
	</table>
	<a href="./Login.php" class="btn btn-lg btn-primary btn-block" role="button">Return to Login</a>

</div></div></div>


</div>

</body>
</html>
