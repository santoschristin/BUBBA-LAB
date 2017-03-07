<!DOCTYPE html>
<?php
session_start();
require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');

if (isset($_POST['submit'])){

	$message=NULL;

	 if (empty($_POST['username'])){
	  $_SESSION['username']=FALSE;
	  $message.='You forgot to enter your username!';
	 } else {
	  $_SESSION['username']=$_POST['username']; 
	 }

	 if (empty($_POST['password'])){
	  $_SESSION['password']=FALSE;
	  $message.='You forgot to enter your password!';
	 } else {
	  $_SESSION['password']=$_POST['password']; 

	 }
	 
	$exists = 1;
	$loginquery = "SELECT USERNAME FROM USERS WHERE USERNAME = '{$_SESSION['username']}'";
	$loginresult = mysqli_query($dbc, $loginquery) or die("Error: ".mysqli_error($dbc));

	if(mysqli_num_rows($loginresult) == 0){
		$exists = 0;
	}
	else{
		$qpassword = "SELECT PASSWORD  FROM USERS WHERE USERNAME = '{$_SESSION['username']}'";
		$passresult = mysqli_query($dbc, $qpassword) or die("Error: ".mysqli_error($dbc));
		while($row = mysqli_fetch_array($passresult, MYSQLI_ASSOC)){
			$pass = $row['PASSWORD'];
		}

	}
	
#error messages
if($exists == 0){
	$message .= "Username does not exist!";
}
else if($exists == 1 && $_SESSION['password'] != $pass){
	$message .= "Incorrect password!";
}

	
#login success
else{
	
	if($pass == $_SESSION['password']){
		
		$_SESSION['usertype'] = 0;
		
		$typequery = "SELECT USERTYPE 
						FROM REF_TITLES RT JOIN EMPLOYEES E
											 ON RT.TITLE = E.TITLE
										   JOIN USERS U
										     ON E.EMPLOYEENO = U.EMPLOYEENO
					   WHERE U.USERNAME = '{$_SESSION['username']}'";
										 										
																
		$typeresult = mysqli_query($dbc, $typequery);
		
		$typerow = mysqli_fetch_array($typeresult, MYSQLI_ASSOC) or die("Error: ".mysqli_error($dbc));
		
		$_SESSION['usertype'] = $typerow['USERTYPE'];
		
		if($_SESSION['usertype'] == 0)
		{
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/DashboardCashier.php");
			
			
		
		}
		
		else {
			
			if($_SESSION['usertype'] == 1)
				header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/Dashboard.php");
			
		}
		
		echo $_SESSION['usertype'];
		
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
      echo'
      <script type="text/javascript">
        alert("'.$message.'");
      </script>
      ';
    
		
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

  <body >
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
		    <img class="center" src="LOGO.png" alt="Mountain View" style="width:350px;height:90px;">
            <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-label-left" >
              <h1>Login Form</h1>
              <div>
                <input type="text" name= "username" class="form-control" placeholder="Username" required="" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button class="btn  btn-primary"  type="submit"  name="submit" >Login</button>
				
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
