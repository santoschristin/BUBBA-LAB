<!DOCTYPE html>
<?php
session_start();
require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
if (isset($_POST['submit'])){

	$message=NULL;

	 if (empty($_POST['username'])){
	  $_SESSION['username']=FALSE;
	  $message.='<p>You forgot to enter your username!';
	 } else {
	  $_SESSION['username']=$_POST['username']; 
	 }

	 if (empty($_POST['password'])){
	  $_SESSION['password']=FALSE;
	  $message.='<p>You forgot to enter your password!';
	 } else {
	  $_SESSION['password']=$_POST['password']; 

	 }
	 
	$exists = 1;
	$loginquery = "SELECT USERNAME, PASSWORD FROM USERS WHERE USERNAME = '{$_SESSION['username']}'";
	$loginresult = mysqli_query($dbc, $loginquery) or die("Error: ".mysqli_error($dbc));

	if(mysqli_num_rows($loginresult == 0)){
		$exists = 0;
	}
	else{
		while($loginrow = mysqli_fetch_array($loginresult, MYSQLI_ASSOC)){
		$pass = $loginrow['PASSWORD'];
		}
	}
	
#error messages
if($exists == 0){
	$message .= "<p> Username does not exist!";
}
else if($exists == 1 && $_SESSION['password'] != $pass){
	$message .= "<p> Incorrect password!";
}
#login success
else{
	if($pass == $_SESSION['password']){
		$_SESSION['usertype'] = 0;
		
		$typequery = "SELECT USERTYPE 
						FROM REF_TITLES
					   WHERE TITLE = (SELECT TITLE 
										FROM EMPLOYEES 
									   WHERE EMPLOYEENUMBER = (SELECT EMPLOYEENUMBER 
																 FROM USERS
																WHERE USERNAME = {$_SESSION['username']}))";												
																
		$_SESSION['usertype'] = mysqli_query($dbc, $typequery);
		
		if($_SESSION['usertype'] == 0) header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/DashboardCashier.php");
		else header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/Dashboard.php");
		
		$namequery = "SELECT EMPLOYEENAME, TITLE
						FROM EMPLOYEES E JOIN USERS U
						  ON E.EMPLOYEENO = U. EMPLOYEENO
					   WHERE U.USERNAME = '{$_SESSION['username']}'";
		
		$nameresult = mysqli_query($dbc, $namequery);
		$namerow = mysqli_fetch_array($nameresult, MYSQLI_ASSOC);
		$_SESSION['employeename'] = $namerow['EMPLOYEENAME'];
		$_SESSION['title'] = $namerow['TITLE'];
	}
}

}

/*End of main Submit conditional*/

if (isset($message)){
 echo '<font color="red">'.$message. '</font>';
}

?>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
	<title>BUBBA LAB | Tea.Juice.Coffee </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
		    <img class="center" src="LOGO.png" alt="Mountain View" style="width:350px;height:90px;">
            <form>
              <h1>Login Form</h1>
              <div>
                <input type="text" name= "username" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <a class="btn btn-lg btn-primary submit" href="Dashboard.html">Log in</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
             

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-coffee"></i> Bubba Lab Food Services</h1>
                  <p>©2016 All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

		
      </div>
    </div>
  </body>
</html>
