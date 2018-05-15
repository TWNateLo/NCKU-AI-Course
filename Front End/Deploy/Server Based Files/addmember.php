<!DOCTYPE html>
<html lang="en" class="gr__getbootstrap_com">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Add Member</title>

    
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
<link rel="icon" href="image/chickvago.png" type="image/x-icon">
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

	<h3><p style="display: inline;"><?php echo $firstname." "  ;?></p>您註冊的資料如下</h3>
	
	<table>
	  <tr>
	    <th>Gender</th>
	    <th>Email</th>
	    <th>Password</th>
	  </tr>
	  <tr>
	    <td><?php echo $gender ?></td>
	    <td><?php echo $email ?></td>
	    <td><?php echo $passwd ?></td>
	  </tr>
	</table>
</body>
</html>