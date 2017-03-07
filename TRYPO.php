<!DOCTYPE html>

	<!-- START OF PHP -->
		<?php
		require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');

		session_start();
		

		$flag=0;
	
	if (isset($_POST['AddSupplier'])){

		$message=NULL;

		if (empty($_POST['supname'])){
		$supname=FALSE;
		$message.='Supplier Name is a required field!';
		}else
		$supname=$_POST['supname'];
						  

		if (empty($_POST['address1'])){
		$address1=FALSE;
		$message.='Address 1 is a required field!';
		}else
		$address1=$_POST['address1'];
	
		if (empty($_POST['address2'])){
		$address2=FALSE;
		$message.='Address 2 is a required field!';
		}else
		$address2=$_POST['address2'];
						  
		if (empty($_POST['contactperson'])){
		$contactperson=FALSE;
		$message.='Contact Person is a required field!';
		}else
		$contactperson=$_POST['contactperson'];
					  
		if (empty($_POST['emailad'])){
		$emailad=FALSE;
		$message.='Email Address is a required field!';
		}else
		$emailad=$_POST['emailad'];
	
		if (empty($_POST['cellnumber'])){
		$cellnumber=FALSE;
		$message.='Cellphone number is a required field!';
		}else
		$cellnumber=$_POST['cellnumber'];
	
		if (empty($_POST['phonenumber'])){
		$phonenumber=FALSE;
		$message.='Telephone number is a required field!';
		}else
		$phonenumber=$_POST['phonenumber'];
	
					  

		if(!isset($message)){
		require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
		$query="insert into ref_suppliers (SUPPLIERNAME,DATEADDED,CONTACTPERSON,CELLPHONENUMBER,TELEPHONENUMBER,EMAILADDRESS,ADDRESS,2NDADDRESS) 
		values ('{$supname}',now(),'{$contactperson}','{$cellnumber}','{$phonenumber}','{$emailad}','{$address1}','{$address2}')";
		$result=mysqli_query($dbc,$query);
		$message= "{$supname} has been added to supplier list!";
		$flag=1;
		}

						 

		}/*End of Add Supplier conditional*/
		
	if (isset($message)){
      echo'
      <script type="text/javascript">
        alert("'.$message.'");
      </script>
      ';
    
		
		}	
		
	
	if (isset($_POST['AddMaterial'])){

		$message=NULL;

		if (empty($_POST['matName'])){
		$matName=FALSE;
		$message.='Material name is a required field!';
		}else
		$matName=$_POST['matName'];
						  
		if (empty($_POST['quantity'])){
		$quantity=FALSE;
		$message.='Quantity is a required field!';
		}else
		$quantity=$_POST['quantity'];

		if (empty($_POST['unitMat'])){
		$unitMat=FALSE;
		$message.='Unit is a required field!';
		}else
		$unitMat=$_POST['unitMat'];
	
						  
		 if (empty($_POST['criticallvl'])){
			 
		$criticallvl=FALSE;
		$message.='Critical Level is a required field!';
		}else
		 $criticallvl=$_POST['criticallvl'];
	 
		
		if (empty($_POST['supplier'])){
		$supplier=FALSE;
		$message.='Supplier is a required field!';
		}else
		 $supplier=$_POST['supplier'];	

		if (empty($_POST['description'])){
		$description=TRUE;
		}else
		 $description=$_POST['description'];
		
						  
						  

		if(!isset($message)){
		require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
		
		/* INSERT INTO MATERIALS */
		$query="insert into materials (MATERIALNAME,QUANTITYINSTOCK, UNIT,CRITICALLEVEL,DESCRIPTION,SUPPLIERID) 
		values ('{$materialname}','{$quantity}','{$unit}','{$criticallvl}','{$description}','{$supplier}')";
		$result=mysqli_query($dbc,$query) or die("Error: ".mysqli_error($dbc));
		
		$message="{$matName} has been added to material list! ";
		$flag=1;
		
		
		}
		 

		}/*End of Add Material conditional*/

		
		
		 if (isset($message)){
      echo'
      <script type="text/javascript">
        alert("'.$message.'");
      </script>
      ';
    
		
		}	
		
		
		
	if (isset($_POST['submit'])){

		$message=NULL;
		if (empty($_POST['supplier'])){
		$supplier=FALSE;
		$message.='Supplier is a required field!';
		}else
		$supplier=$_POST['supplier'];
		
		if (empty($_POST['item'])){
		$item=FALSE;
		$message.='Item is a required field!';
		}else
		$item=$_POST['item'];
						  
		if (empty($_POST['quantity'])){
		$quantity=FALSE;
		$message.='Quantity is a required field!';
		}else
		$quantity=$_POST['quantity'];
			
		if (empty($_POST['unit'])){
		$unit=FALSE;
		$message.='Unit is a required field!';
		}else
		$unit=$_POST['unit'];
	
		
		if(!isset($message)){
		
		$query="insert into purchaseorders (DATE,STATUSCODE) 
		values (now(), 1)";
		$result=mysqli_query($dbc,$query) or die("Error: ".mysqli_error($dbc));
		
		if(isset($_POST["item"])){
		$materialarraysize = count($_POST["item"]);
			for($count = 0; $count < $materialarraysize; $count++){
				
				$query2 = "SELECT MAX(PURCHASEORDERNO) FROM PURCHASEORDERS";
				$result2 = mysqli_query($dbc, $query2);
				$qgetlastpo = mysqli_fetch_array($result2, MYSQLI_ASSOC);
				$po = $qgetlastpo['MAX(PURCHASEORDERNO)'];
				
				$matcode = $_POST["item"][$count];
				$qtyIndex = $_POST["quantity"][$count];
				$unitIndex = $_POST["unit"][$count];
				
				
				 if($unitIndex == "g (Gram)" or $unitIndex == "mL (Milliliter)" )
				{
					
					
					$query4 = "SELECT UNIT, VALUE, CONVERTEDUNIT, CONVERTEDVALUE 
							   FROM ref_conversion
							   WHERE unit = '$unitIndex'";
					$result4 =mysqli_query($dbc, $query4);
					
					$getConvertedUnitValue = mysqli_fetch_array($result4, MYSQLI_ASSOC);

					$qtyIndex = $getConvertedUnitValue ['CONVERTEDVALUE'] * $qtyIndex;
					$unitIndex = $getConvertedUnitValue ['CONVERTEDUNIT'];
					
					
				}	

				
				$query1="insert into purchaseorderdetails (PURCHASEORDERNO,QTYORDERED, MATERIALCODE,UNIT) 
				values ('{$po}','{$qtyIndex}','{$matcode}','{$unitIndex}')";
				$result1=mysqli_query($dbc,$query1) or die("Error: ".mysqli_error($dbc));
				
			}
			
		}
		
		
		$query3 = "SELECT SUPPLIERID, EMAILADDRESS FROM REF_SUPPLIERS WHERE SUPPLIERID = '$supplier' ";
		$result3 = mysqli_query($dbc, $query3);
		while($row = mysqli_fetch_array($result3, MYSQLI_ASSOC)){
			$supplierEmail = $row['EMAILADDRESS'];
		}
		
		require 'PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer;

		$mail->isSMTP();  

		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);  
									   // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                            // Enable SMTP authentication
		$mail->Username = 'bubbalab.marikina@gmail.com';          // SMTP username
		$mail->Password = 'bubbalabfoodservices'; // SMTP password
		$mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                 // TCP port to connect to

		$mail->setFrom('bubbalab.marikina@gmail.com', 'Bubba Lab Marikina');
		//$mail->addReplyTo('email@codexworld.com', 'CodexWorld');
		$mail->addAddress("{$supplierEmail}");   // Add a recipient
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		$mail->isHTML(true);  // Set email format to HTML

		$bodyContent = '<h1>Bubba Lab - Purchase Order Form</h1>';
		
		
		$query="select  pod.PURCHASEORDERNO, pod.MATERIALCODE, pod.QTYORDERED, pod.UNIT,  m.MATERIALCODE, m.MATERIALNAME
				from purchaseorderdetails pod join materials m on m.MATERIALCODE = pod.MATERIALCODE
				where PURCHASEORDERNO = '$po'";
		$result=mysqli_query($dbc,$query) or die("Error: ".mysqli_error($dbc));
		
		
		
		
		
		
		 $bodyContent = '<h1>Bubba Lab - Purchase Order Form</h1>';
		 
		 $bodyContent = '<p> </p>';
		
	
		
		
		
		
		$mail->Subject = 'Bubbalab Marikina - Purchase Order Form';
		$mail->Body    = $bodyContent ;
		
		$mail->Body    = "Click the <b><a href='http://localhost/APPDEV/production/ConfirmOrder.php?PO=".$po."' >link </a> </b>for confirmation</p>";
			
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			$message="Purchase Order Form has been sent to {$supplierEmail}!";	
			$flag=1;
		}
		

		
			
		
		
		}
		
		
		
		
		}
		/* END OF PO FORM CONDITION */
	
		
		
		 if (isset($message)){
      echo'
      <script type="text/javascript">
        alert("'.$message.'");
      </script>
      ';
    
		
		}	

		?>
		

	<!-- END -->
	
<html>
  <head>
   
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
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="Dashboard.php" class="site_title"><i class="fa fa-coffee"></i> <span>BUBBA LAB</span></a>
            </div>

            <div class="clearfix"></div>

           <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                 <h2><?php  echo $_SESSION['employeename'];?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

              <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3> <?php  echo $_SESSION['title'];?></h3>
               <ul class="nav side-menu">
                  
				   <li><a href="Dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
				  
				
				  <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="AddNewProduct.php"><i class="fa fa-plus"></i>Add New Product</a></li>
					  <li><a href="AddNewSupplier.php"><i class="fa fa-plus"></i>Add New Supplier</a></li>
					  <li><a href="AddNewMaterial.php"><i class="fa fa-plus"></i>Add New Material</a></li>	
					  <li><a href="AddConversion.php"><i class="fa fa-plus"></i>Add Conversion </a></li>
					  <li><a href="AddCalibration.php"><i class="fa fa-plus"></i>Add Calibration</a></li>
					   <li><a href="AddSizes.php"><i class="fa fa-plus"></i>Add Sizes</a></li>
					   <li><a href="PurchaseOrderForm2.php"><i class="fa fa-shopping-cart"></i>Purchase Order Form</a></li>
                    </ul>
                  </li>
				   
				                    
				   <li><a href="ConfirmReplenish.php"><i class="fa fa-list-alt"></i> Confirm Delivery</a>
				   <li><a href="NewPullOut.php"><i class="fa fa-share"></i> Pull Out</a>
				   <li><a href="NewReturnStock.php"><i class="fa fa-check"></i> Return Stock</a>
					
					
                  <li><a><i class="fa fa-table"></i> Generate Reports <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					  <li><a href="GenerateSalesReport.php">Sales Report</a></li>
					  <li><a href="GenerateSuppliers.php">Suppliers Report</a></li>
					    <li><a href="GenerateDiscrepancy.php">Discrepancy Report</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					  <li><a href="DisplayProducts.php">Products</a></li>
					  <li><a href="Suppliers.php">Suppliers</a></li>
					  <li><a href="Inventory.php">Inventory</a></li>
					  
                    </ul>
                  </li>
			
                </ul>
              </div>
             

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/img.jpg" alt=""><?php  echo $_SESSION['employeename'];?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
		
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Create Purchase Order Form
				<br>
				<small>
						<?php
						date_default_timezone_set("Asia/Manila");
						echo date("l").', '.date("Y/m/d"). ' ';
						echo date("h:i:sa").'<p>';
						?>
				</small>
				</br>
				</h3>
              </div>

              
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   
                    <ul class="nav navbar-right panel_toolbox">
                      <ol class="breadcrumb">
					<li><a href="Dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
					<li><a href="Dashboard.php">Forms</a></li>
					<li class="active">Purchase Order Form</li>
					</ol>
                    </ul>
					 <h3>Purchase Order Form</h3>	
                    <div class="clearfix"></div>
                  </div>
                  <div>
                   
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-label-left"  >
					  
					  
					 
                      <div class="form-group">
					  
                        <label class="control-label col-md-3 col-sm-3 col-xs-9">Supplier: 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-9">
                          <?php

								require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
								
								
								@$SUPID=$_GET['SUPID']; // Use this line or below line if register_global is off
								if(strlen($SUPID) > 0 and !is_numeric($SUPID)){ // to check if $cat is numeric data or not. 
								echo "Data Error";
								exit;
								}
								
								$quer2="SELECT SUPPLIERID, SUPPLIERNAME from ref_suppliers"; 
								
								
								
								
								echo '<select name="supplier" id="supplierList" onchange="reload(this.form)" class="form-control col-md-7 col-xs-12">';
								echo '<option default>Suppliers</option>';
								foreach ($dbc->query($quer2) as $noticia2) 
								{
								if($noticia2['SUPPLIERID']==@$SUPID){echo "<option selected value='$noticia2[SUPPLIERID]'>$noticia2[SUPPLIERNAME]</option>"."<BR>";}
								else{echo  "<option value='$noticia2[SUPPLIERID]'>$noticia2[SUPPLIERNAME]</option>";}
								}

								echo '</select>';
								
								
								
								
								
								
							?>
							
						
							
							
						  
                        </div>
						
						<div class="col-md-3 col-sm-3 col-xs-9">
							<button type="button" class="btn btn-primary pull-left btn-flat" data-toggle="modal" data-target="#myModal">
							Add New Supplier
							</button>	
					

                          <!-- Modal Add New Supplier Form -->
							<div class="modal fade modal-default" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h3 class="modal-title" id="myModalLabel">New Supplier</h3>
										</div>

									<div class="modal-body">
										<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-label-left" >
										
										  <div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Supplier Name: 
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
											  <input type="text" name="supname" size="20" maxlength="30"class="form-control col-md-7 col-xs-12"
											  value="<?php if (isset($_POST['supname']) && !$flag) echo $_POST['supname']; ?>"/>
											  
											</div>
										  </div>
										  
										 <div class="form-group">
											<label for="address1" class="control-label col-md-3 col-sm-3 col-xs-12">Address 1:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
											  <input class="form-control col-md-7 col-xs-12" type="text" name="address1" size="20" maxlength="30"
											  value="<?php if (isset($_POST['address1']) && !$flag) echo $_POST['address1']; ?>"/>
											
											</div>
										  </div>
										  
										  <div class="form-group">
											<label for="address2" class="control-label col-md-3 col-sm-3 col-xs-12">Address 2:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
											  <input class="form-control col-md-7 col-xs-12" type="text" name="address2" size="20" maxlength="30"
											  value="<?php if (isset($_POST['address2']) && !$flag) echo $_POST['address2']; ?>"/>
											
											</div>
										  </div>
										  
										  <div class="form-group">
											<label for="contactperson" class="control-label col-md-3 col-sm-3 col-xs-12">Contact Person: </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
											  <input  class="form-control col-md-7 col-xs-12" type="text" name="contactperson" size="20" maxlength="30" placeholder=""
											  value="<?php if (isset($_POST['contactperson']) && !$flag) echo $_POST['contactperson']; ?>"/>
											</div>
										  </div>
										  
										  <div class="form-group">
											<label for="cellnumber" class="control-label col-md-3 col-sm-3 col-xs-12">Cellphone Number: </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
											  <input  class="form-control col-md-7 col-xs-12" type="text" name="cellnumber" size="20" maxlength="30" placeholder=""
											  value="<?php if (isset($_POST['cellnumber']) && !$flag) echo $_POST['cellnumber']; ?>"/>
											</div>
										  </div>
										  
											
										  <div class="form-group">
											<label for="phonenumber" class="control-label col-md-3 col-sm-3 col-xs-12">Phone number: </label>
											<div class="col-md-6 col-sm-6 col-xs-12">
											  <input  class="form-control col-md-7 col-xs-12" type="text" name="phonenumber" size="20" maxlength="30" placeholder=""
											  value="<?php if (isset($_POST['phonenumber']) && !$flag) echo $_POST['phonenumber']; ?>"/>
											</div>
										  </div>
										  
										  <div class="form-group">
											<label for="emailad" class="control-label col-md-3 col-sm-3 col-xs-12">Email address:</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
											  <input  class="form-control col-md-7 col-xs-12" type="text" name="emailad" size="20" maxlength="40"
											  value="<?php if (isset($_POST['emailad']) && !$flag) echo $_POST['emailad']; ?>"/>
											</div>
										  </div>
										  
										</form>
									</div>
									
									<div class="modal-footer">
										<button type="button" class="btn btn-default"
												data-dismiss="modal">
													Close
										</button>
										 <button type="submit" name="AddSupplier" value="AddSupplier" class="btn btn-primary ">Add Supplier</button>
									</div>
								</div>
							
                        </div>
						  
                        </div>
						
                      </div>
					  

                      
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Items:</label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                          <TABLE id="orders" width="250px" border="1" class='table table-bordered table-hover text-center'>
						  
							<TR id="tr1">
								
								<TD id="mat">
								</TD>
								<TD id="quan">  </TD>
								
								<TD id="un">
								 
								</TD>
							</TR id ="tr2">
							
							
						</TABLE>
						
							<div align="left"><input type="button" class="btn btn-primary" name="adddrink" id = "ad" value="Add Item" /></div>
							
					</div>
					
					<div class="col-md-3 col-sm-3 col-xs-9">
							<button type="button" class="btn btn-primary pull-left btn-flat" data-toggle="modal" data-target="#materialModal">
							Add New Material
							</button>	
					

                          <!-- Modal Add New Material Form -->
							<div class="modal fade modal-default" id="materialModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h3 class="modal-title" id="myModalLabel">New Material</h3>
										</div>

									<div class="modal-body">
										<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-label-left" >
										
										     <div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Material Name: 
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
											  <input type="text" name="matName" size="20" maxlength="30" class="form-control col-md-7 col-xs-12"
											  value="<?php if (isset($_POST['matName']) && !$flag) echo $_POST['matName']; ?>"/>
											  
											</div>
										  </div>
										  
										  <div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Supplier: 
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
											  <?php

													require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
													$query="select SUPPLIERNAME, SUPPLIERID
															from ref_suppliers"; 
													$result=mysqli_query($dbc,$query)or die("Error: ".mysqli_error($dbc));
													
													echo '<select name="supplier" class="form-control col-md-3 col-xs-9">';
													echo '<option default>Supplier</option>';
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))

													{
														echo '<option value="'.$row['SUPPLIERID'].'" class="form-control col-md-3 col-xs-9"> '.$row['SUPPLIERNAME'].' </option>';
													}

													echo '</select>'

													
												?>
											</div>
										  </div>
										  
										    <div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Description: 
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
											  <input type="text" name="description" size="20" maxlength="30" required="required" class="form-control col-md-7 col-xs-12"
											  value="<?php if (isset($_POST['description']) && !$flag) echo $_POST['description']; ?>"/>
											  
											</div>
										  </div>
															  
										  <div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" >Quantity: 
											</label>
											<div class="col-md-3 col-sm-3  col-xs-9">
											  <input type="number"  name="quantity" size="20" maxlength="30"  class="form-control col-md-7 col-xs-12"
											  value="<?php if (isset($_POST['quantity']) && !$flag) echo $_POST['quantity']; ?>"/>
											</div>
											
											<div class="col-md-3 col-sm-3 col-xs-9">
											  <?php

													require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
													$query="select UNIT
															from ref_units"; 
													$result=mysqli_query($dbc,$query);
													
													echo '<select name="unitMat" class="form-control col-md-3 col-xs-9">';
													echo '<option default>Unit</option>';
													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))

													{
														echo '<option value="'.$row['UNIT'].'" class="form-control col-md-3 col-xs-9"> '.$row['UNIT'].' </option>';
													}

													echo '</select>'

													
												?>
											</div>
											
										  </div>
									
										  <div class="form-group">
											<label for="criticallvl" class="control-label col-md-3 col-sm-3 col-xs-12">Critical Level:</label>
											
											<div class="col-md-3 col-sm-3 col-xs-9">
											  <input class="form-control col-md-7 col-xs-12" type="number" name="criticallvl" size="20" maxlength="30"
											  value="<?php if (isset($_POST['criticallvl']) && !$flag) echo $_POST['criticallvl']; ?>"/>
											</div>
											
											
										  </div>
										  
										</form>
										
									</div>
									
									<div class="modal-footer">
										<button type="button" class="btn btn-default"
												data-dismiss="modal">
													Close
										</button>
										 <button type="submit" name="AddMaterial" value="AddMaterial" class="btn btn-primary ">Add Material</button>
									</div>
								</div>
							
                        </div>
						  
                        </div>
						
                      </div>
					</div>
						<div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-8">
                          
                         <!-- Button trigger modal Supplier -->
						<button type="button" class="btn btn-info pull-left btn-flat" data-toggle="modal" data-target="#suppliersModal">
							Display Suppliers
							</button>	
						<button type="button" class="btn btn-info pull-left btn-flat" data-toggle="modal" data-target="#inventoryModal">
							Display Inventory
							</button>	
							<!-- Modal DISPLAY INVENTORY -->
							<div class="modal fade modal-default" id="inventoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h3 class="modal-title" id="myModalLabel">Inventory</h3>
										</div>
										<div class="modal-body">
											<!-- MAIN CONTENT START -->
											<table id='example1' class='table table-bordered table-striped'>
												<thead>
													<tr>
														<th>Material Name</th>
														<th>Quantity in Stock</th>
														<th>Unit</th>
													</tr>
												</thead>
												<tbody>


													<?php
													require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
													$query2="SELECT MATERIALNAME, QUANTITYINSTOCK, UNIT
													FROM  materials";
													$result=mysqli_query($dbc,$query2)or die("Error: ".mysqli_error($dbc));

													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

														echo "<tr>
														
														<td>".$row['MATERIALNAME']."
														</td>
														<td>".$row['QUANTITYINSTOCK']."
														</td>
														<td>".$row['UNIT']."
														</td>
													</tr>";

												} 
												?>
											</tbody>

											<!-- /TABLE FOOTER -->
											<tfoot>
												<tr>
													<th class = "text-center" colspan="5">END OF REPORT</th>
												</tr>
											</tfoot>

										</table>
										<!-- END OF MAIN CONTENT -->
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
                        </div>
						
						<!-- Modal DISPLAY SUPPLIERS -->
							<div class="modal fade modal-default" id="suppliersModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h3 class="modal-title" id="myModalLabel">Suppliers</h3>
										</div>
										<div class="modal-body">
											<!-- MAIN CONTENT START -->
											<table id='example1' class='table table-bordered table-striped'>
												<thead>
													<tr>
														<th>Supplier Name</th>
														<th>Contact Person</th>
														<th>Telephone Number</th>
														<th>Email Address</th>
													</tr>
												</thead>
												<tbody>


													<?php
													require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
													$query2="SELECT *
													FROM ref_suppliers";
													$result=mysqli_query($dbc,$query2)or die("Error: ".mysqli_error($dbc));

													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

														echo "<tr>
														<td><a href='displaySuppliers2.php?SUPPLIER={$row['SUPPLIERID']}'>".$row['SUPPLIERNAME']."</a>
														</td>
														<td>".$row['CONTACTPERSON']."
														</td>
														<td>".$row['TELEPHONENUMBER']."
														</td>
														<td>".$row['EMAILADDRESS']."
														</td>
													</tr>";

												} 
												?>
											</tbody>

											<!-- /TABLE FOOTER -->
											<tfoot>
												<tr>
													<th class = "text-center" colspan="5">END OF REPORT</th>
												</tr>
											</tfoot>

										</table>
										<!-- END OF MAIN CONTENT -->
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
                        </div>
						
						
					
						
						
                      
					  </div>
					 </div>
					 
					  <div class="ln_solid"></div>
					  <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-5">
                          
						  <button type="submit" class="btn btn-default" href="Dashboard.php">Cancel</button>
                          <button type="submit" name="submit" value="Add!" class="btn btn-primary">Submit</button>
						  
                        </div>
                      </div>
                    
                     
                     

                    </form>
                 
                </div>
              </div>
            </div>
			

                  
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->


    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="../vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="../vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="../vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="../vendors/starrr/dist/starrr.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {
        $('#birthday').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker -->

    <!-- bootstrap-wysiwyg -->
    <script>
      $(document).ready(function() {
        function initToolbarBootstrapBindings() {
          var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
              'Times New Roman', 'Verdana'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
          $.each(fonts, function(idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
          });
          $('a[title]').tooltip({
            container: 'body'
          });
          $('.dropdown-menu input').click(function() {
              return false;
            })
            .change(function() {
              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
              this.value = '';
              $(this).change();
            });

          $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
              target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
          });

          if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editor').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
              top: editorOffset.top,
              left: editorOffset.left + $('#editor').innerWidth() - 35
            });
          } else {
            $('.voiceBtn').hide();
          }
        }

        function showErrorAlert(reason, detail) {
          var msg = '';
          if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
          } else {
            console.log("error uploading file", reason, detail);
          }
          $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }

        initToolbarBootstrapBindings();

        $('#editor').wysiwyg({
          fileUploadError: showErrorAlert
        });

        window.prettyPrint;
        prettyPrint();
      });
    </script>
    <!-- /bootstrap-wysiwyg -->

    <!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Select a state",
          allowClear: true
        });
        $(".select2_group").select2({});
        $(".select2_multiple").select2({
          maximumSelectionLength: 4,
          placeholder: "With Max Selection limit 4",
          allowClear: true
        });
      });
    </script>
    <!-- /Select2 -->

    <!-- jQuery Tags Input -->
    <script>
      function onAddTag(tag) {
        alert("Added a tag: " + tag);
      }

      function onRemoveTag(tag) {
        alert("Removed a tag: " + tag);
      }

      function onChangeTag(input, tag) {
        alert("Changed a tag: " + tag);
      }

      $(document).ready(function() {
        $('#tags_1').tagsInput({
          width: 'auto'
        });
      });
    </script>
    <!-- /jQuery Tags Input -->

    <!-- Parsley -->
    <script>
      $(document).ready(function() {
        $.listen('parsley:field:validate', function() {
          validateFront();
        });
        $('#demo-form .btn').on('click', function() {
          $('#demo-form').parsley().validate();
          validateFront();
        });
        var validateFront = function() {
          if (true === $('#demo-form').parsley().isValid()) {
            $('.bs-callout-info').removeClass('hidden');
            $('.bs-callout-warning').addClass('hidden');
          } else {
            $('.bs-callout-info').addClass('hidden');
            $('.bs-callout-warning').removeClass('hidden');
          }
        };
      });

      $(document).ready(function() {
        $.listen('parsley:field:validate', function() {
          validateFront();
        });
        $('#demo-form2 .btn').on('click', function() {
          $('#demo-form2').parsley().validate();
          validateFront();
        });
        var validateFront = function() {
          if (true === $('#demo-form2').parsley().isValid()) {
            $('.bs-callout-info').removeClass('hidden');
            $('.bs-callout-warning').addClass('hidden');
          } else {
            $('.bs-callout-info').addClass('hidden');
            $('.bs-callout-warning').removeClass('hidden');
          }
        };
      });
      try {
        hljs.initHighlightingOnLoad();
      } catch (err) {}
    </script>
    <!-- /Parsley -->

    <!-- Autosize -->
    <script>
      $(document).ready(function() {
        autosize($('.resizable_textarea'));
      });
    </script>
    <!-- /Autosize -->

    <!-- jQuery autocomplete -->
    <script>
      $(document).ready(function() {
        var countries = { AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates",AF:"Afghanistan",AG:"Antigua and Barbuda",AI:"Anguilla",AL:"Albania",AM:"Armenia",AN:"Netherlands Antilles",AO:"Angola",AQ:"Antarctica",AR:"Argentina",AS:"American Samoa",AT:"Austria",AU:"Australia",AW:"Aruba",AX:"Åland Islands",AZ:"Azerbaijan",BA:"Bosnia and Herzegovina",BB:"Barbados",BD:"Bangladesh",BE:"Belgium",BF:"Burkina Faso",BG:"Bulgaria",BH:"Bahrain",BI:"Burundi",BJ:"Benin",BL:"Saint Barthélemy",BM:"Bermuda",BN:"Brunei",BO:"Bolivia",BQ:"British Antarctic Territory",BR:"Brazil",BS:"Bahamas",BT:"Bhutan",BV:"Bouvet Island",BW:"Botswana",BY:"Belarus",BZ:"Belize",CA:"Canada",CC:"Cocos [Keeling] Islands",CD:"Congo - Kinshasa",CF:"Central African Republic",CG:"Congo - Brazzaville",CH:"Switzerland",CI:"Côte d’Ivoire",CK:"Cook Islands",CL:"Chile",CM:"Cameroon",CN:"China",CO:"Colombia",CR:"Costa Rica",CS:"Serbia and Montenegro",CT:"Canton and Enderbury Islands",CU:"Cuba",CV:"Cape Verde",CX:"Christmas Island",CY:"Cyprus",CZ:"Czech Republic",DD:"East Germany",DE:"Germany",DJ:"Djibouti",DK:"Denmark",DM:"Dominica",DO:"Dominican Republic",DZ:"Algeria",EC:"Ecuador",EE:"Estonia",EG:"Egypt",EH:"Western Sahara",ER:"Eritrea",ES:"Spain",ET:"Ethiopia",FI:"Finland",FJ:"Fiji",FK:"Falkland Islands",FM:"Micronesia",FO:"Faroe Islands",FQ:"French Southern and Antarctic Territories",FR:"France",FX:"Metropolitan France",GA:"Gabon",GB:"United Kingdom",GD:"Grenada",GE:"Georgia",GF:"French Guiana",GG:"Guernsey",GH:"Ghana",GI:"Gibraltar",GL:"Greenland",GM:"Gambia",GN:"Guinea",GP:"Guadeloupe",GQ:"Equatorial Guinea",GR:"Greece",GS:"South Georgia and the South Sandwich Islands",GT:"Guatemala",GU:"Guam",GW:"Guinea-Bissau",GY:"Guyana",HK:"Hong Kong SAR China",HM:"Heard Island and McDonald Islands",HN:"Honduras",HR:"Croatia",HT:"Haiti",HU:"Hungary",ID:"Indonesia",IE:"Ireland",IL:"Israel",IM:"Isle of Man",IN:"India",IO:"British Indian Ocean Territory",IQ:"Iraq",IR:"Iran",IS:"Iceland",IT:"Italy",JE:"Jersey",JM:"Jamaica",JO:"Jordan",JP:"Japan",JT:"Johnston Island",KE:"Kenya",KG:"Kyrgyzstan",KH:"Cambodia",KI:"Kiribati",KM:"Comoros",KN:"Saint Kitts and Nevis",KP:"North Korea",KR:"South Korea",KW:"Kuwait",KY:"Cayman Islands",KZ:"Kazakhstan",LA:"Laos",LB:"Lebanon",LC:"Saint Lucia",LI:"Liechtenstein",LK:"Sri Lanka",LR:"Liberia",LS:"Lesotho",LT:"Lithuania",LU:"Luxembourg",LV:"Latvia",LY:"Libya",MA:"Morocco",MC:"Monaco",MD:"Moldova",ME:"Montenegro",MF:"Saint Martin",MG:"Madagascar",MH:"Marshall Islands",MI:"Midway Islands",MK:"Macedonia",ML:"Mali",MM:"Myanmar [Burma]",MN:"Mongolia",MO:"Macau SAR China",MP:"Northern Mariana Islands",MQ:"Martinique",MR:"Mauritania",MS:"Montserrat",MT:"Malta",MU:"Mauritius",MV:"Maldives",MW:"Malawi",MX:"Mexico",MY:"Malaysia",MZ:"Mozambique",NA:"Namibia",NC:"New Caledonia",NE:"Niger",NF:"Norfolk Island",NG:"Nigeria",NI:"Nicaragua",NL:"Netherlands",NO:"Norway",NP:"Nepal",NQ:"Dronning Maud Land",NR:"Nauru",NT:"Neutral Zone",NU:"Niue",NZ:"New Zealand",OM:"Oman",PA:"Panama",PC:"Pacific Islands Trust Territory",PE:"Peru",PF:"French Polynesia",PG:"Papua New Guinea",PH:"Philippines",PK:"Pakistan",PL:"Poland",PM:"Saint Pierre and Miquelon",PN:"Pitcairn Islands",PR:"Puerto Rico",PS:"Palestinian Territories",PT:"Portugal",PU:"U.S. Miscellaneous Pacific Islands",PW:"Palau",PY:"Paraguay",PZ:"Panama Canal Zone",QA:"Qatar",RE:"Réunion",RO:"Romania",RS:"Serbia",RU:"Russia",RW:"Rwanda",SA:"Saudi Arabia",SB:"Solomon Islands",SC:"Seychelles",SD:"Sudan",SE:"Sweden",SG:"Singapore",SH:"Saint Helena",SI:"Slovenia",SJ:"Svalbard and Jan Mayen",SK:"Slovakia",SL:"Sierra Leone",SM:"San Marino",SN:"Senegal",SO:"Somalia",SR:"Suriname",ST:"São Tomé and Príncipe",SU:"Union of Soviet Socialist Republics",SV:"El Salvador",SY:"Syria",SZ:"Swaziland",TC:"Turks and Caicos Islands",TD:"Chad",TF:"French Southern Territories",TG:"Togo",TH:"Thailand",TJ:"Tajikistan",TK:"Tokelau",TL:"Timor-Leste",TM:"Turkmenistan",TN:"Tunisia",TO:"Tonga",TR:"Turkey",TT:"Trinidad and Tobago",TV:"Tuvalu",TW:"Taiwan",TZ:"Tanzania",UA:"Ukraine",UG:"Uganda",UM:"U.S. Minor Outlying Islands",US:"United States",UY:"Uruguay",UZ:"Uzbekistan",VA:"Vatican City",VC:"Saint Vincent and the Grenadines",VD:"North Vietnam",VE:"Venezuela",VG:"British Virgin Islands",VI:"U.S. Virgin Islands",VN:"Vietnam",VU:"Vanuatu",WF:"Wallis and Futuna",WK:"Wake Island",WS:"Samoa",YD:"People's Democratic Republic of Yemen",YE:"Yemen",YT:"Mayotte",ZA:"South Africa",ZM:"Zambia",ZW:"Zimbabwe",ZZ:"Unknown or Invalid Region" };

        var countriesArray = $.map(countries, function(value, key) {
          return {
            value: value,
            data: key
          };
        });

        // initialize autocomplete with custom appendTo
        $('#autocomplete-custom-append').autocomplete({
          lookup: countriesArray
        });
      });
    </script>
    <!-- /jQuery autocomplete -->

    <!-- Starrr -->
    <script>
      $(document).ready(function() {
        $(".stars").starrr();

        $('.stars-existing').starrr({
          rating: 4
        });

        $('.stars').on('starrr:change', function (e, value) {
          $('.stars-count').html(value);
        });

        $('.stars-existing').on('starrr:change', function (e, value) {
          $('.stars-count-existing').html(value);
        });
      });
    </script>
    <!-- /Starrr -->
	
	</script>

<SCRIPT language=JavaScript>
function reload(form)
{
var val=form.supplier.options[form.supplier.options.selectedIndex].value;
self.location='TRYPO.php?SUPID=' + val ;
}

</script>

<script src = "jquery.js"></script>
	<script>
	var materialarray = 0;
	
	
	$(document).ready(function()
	{
		
		$("#ad").click(function() {
			
			var getmaterialname = "<?php $materialname = "SELECT MATERIALCODE, MATERIALNAME, SUPPLIERID FROM MATERIALS WHERE SUPPLIERID =$SUPID";
			$result=mysqli_query($dbc,$materialname); 
			echo "<option default>Item</option>"; 
			while($row=mysqli_fetch_array($result,MYSQLI_ASSOC))  
			{  echo "<option value = '{$row['MATERIALCODE']}'>{$row['MATERIALNAME']}</option>";} ?>";
			
			
			
			
			var getunit = "<?php $unit = "SELECT UNIT FROM REF_UNITS"; $result = mysqli_query($dbc, $unit);  
			echo "<option default>Unit</option>"; while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) { echo "<option value = '{$row['UNIT']}'>{$row['UNIT']}</option>";}?>";
			
			$("#tr1").append('<tr>');
			$("#mat").append('<select name = "item[]" class="form-control col-md-7 col-xs-12"  placeholder="Item" > '  + getmaterialname + ' </select>' );
			$("#quan").append('<input type = "number" name = "quantity[]" size = "1" maxlength = "30" placeholder="Quantity" class="form-control col-md-7 col-xs-12"/>');
		
			$("#un").append('  <select name = "unit[]" class="form-control col-md-7 col-xs-12"  placeholder="Units"> ' + getunit + ' </select>' );
			$("#tr2").append('</tr>');
		}
		);
		
		
	
						
		
		
	}
	); 


</script>
	
  </body>
</html>
