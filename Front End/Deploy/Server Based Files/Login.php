<?php 
      $error = "";     
      // check submit value
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST["inputEmail"]; 
        $passwd = $_POST["inputPassword"]; 
        //Connect to database
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

        //there is not such an account
        if($result->num_rows ==0){
          $error =  "抱歉 無此使用者 請點上方連結註冊";
          //Release memory
          mysqli_free_result($result);     
      }
        else{

            $row = $result->fetch_assoc();
            //check password
            if($passwd!=$row['Password']){
              $error = "密碼錯誤!";
              //Release memory
              mysqli_free_result($result);     
            }
            else{
              // Send account and password to index.php through cookie
              setcookie("email",$email);
              setcookie("passed","TRUE");
              //Release memory
              mysqli_free_result($result);
              header("Location: index.php");
            }
          }
        $conn->close();
      }
     $jsonError = json_encode($error);
    ?>   
<!DOCTYPE html>
<!-- saved from url=(0059)https://getbootstrap.com/docs/4.0/examples/floating-labels/ -->
<html lang="en" class="gr__getbootstrap_com"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./image/favicon.ico">

    <title>Sign In</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/floating-labels.css" rel="stylesheet">

    <script type="text/javascript" src="./js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/popper.min.js"></script>
    <script type="text/javascript" src="./js/tooltip.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.bundle.min.js"></script>

  <style></style>
  </head>

  <body data-gr-c-s-loaded="true" style="">
    <form class="form-signin" action="Login.php" method='POST'>

      <div class="alert alert-warning alert-dismissible fade show" id = "Error" role="alert">
        <strong><?php echo $error?></strong>
        <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>

      <script type="text/javascript">
      var error = <?php echo $jsonError ?>;
      var x = document.getElementById("Error"); 
      //Check error existence and adjust display style
      if(error)x.style.display = "block";
      else x.style.display = "none";
      </script>
     

      <div class="text-center mb-4">
        <img class="mb-4" src="./image/chick.svg" alt="" width="100" height="100">
        <h1 class="h3 mb-3 font-weight-normal white-font"><b>Sign In</b></h1>
      </div>

      <div class="form-label-group">
        <input type="email" name="inputEmail" id = "inputEmail"  class="form-control" placeholder="Email address"  required="" autofocus="">
        <label for="inputEmail">Email address</label>
      </div>

      <div class="form-label-group">
        <input type="password" name="inputPassword" id="inputPassword"  placeholder="Password" class="form-control" required="">
        <label for="inputPassword">Password</label>
      </div>

      <div class="checkbox mb-3 white-font">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <a href="SignUp.html" class="btn btn-lg btn-outline-secondary btn-block" role="button">Sign up</a>
      <p class="mt-4 mb-3 text-muted text-center">© 2017-2018</p>
    </form>

</body></html>
