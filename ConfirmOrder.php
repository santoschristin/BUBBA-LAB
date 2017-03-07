<!DOCTYPE html>

 <?php
	

		
		if(isset($_POST['submit'])){
			
			$message=NULL;
			
			$NewQuantity = $_POST['qtyavb'];
		
			
			
		if(!isset($message)){
		require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
		
		/* UPDATE PO DETAILS */
		
			$queryPO = "SELECT MAX(PURCHASEORDERNO) FROM PURCHASEORDERS";
			$resultPO = mysqli_query($dbc, $queryPO);
			$qgetlastpo = mysqli_fetch_array($resultPO, MYSQLI_ASSOC);
			$po = $qgetlastpo['MAX(PURCHASEORDERNO)'];
		
			
			
			$query="SELECT PURCHASEORDERNO, QTYAVAILABLE, MATERIALCODE
					  FROM PURCHASEORDERDETAILS
					  WHERE PURCHASEORDERNO = '$po' ";
			$result=mysqli_query($dbc,$query)  or die("Error: ".mysqli_error($dbc));
			$i=0;
			while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$query2 = "UPDATE PURCHASEORDERS SET STATUSCODE = '2' WHERE PURCHASEORDERNO = '$po'";
					if(mysqli_query($dbc,$query2)){
							
					$query3 ="UPDATE PURCHASEORDERDETAILS
									 SET QTYAVAILABLE={$NewQuantity[$i]}
									 WHERE MATERIALCODE = {$row['MATERIALCODE']} 
									 AND PURCHASEORDERNO = '$po'";
						$result3=mysqli_query($dbc,$query3)  or die("Error: ".mysqli_error($dbc));
		
					}
					$i++;
					
			}
			
			$message="Purchase Order confirmed! ";
		$flag=1;
		
		
		}

						 

		}/*End of main Submit conditional*/

		
		
		 if (isset($message)){
      echo'
      <script type="text/javascript">
        alert("'.$message.'")
		window.location.href = "ThankYou.php";
      </script>
      ';
    
		}


		if(isset($_POST["cancel"])){
		require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
		
		$queryPO = "SELECT MAX(PURCHASEORDERNO) FROM PURCHASEORDERS";
		$resultPO = mysqli_query($dbc, $queryPO);
		$qgetlastpo = mysqli_fetch_array($resultPO, MYSQLI_ASSOC);
		$po = $qgetlastpo['MAX(PURCHASEORDERNO)'];
		
		
			$query="SELECT PURCHASEORDERNO, QTYAVAILABLE, MATERIALCODE
					  FROM PURCHASEORDERDETAILS
					  WHERE PURCHASEORDERNO = '$po' ";
			$result=mysqli_query($dbc,$query)  or die("Error: ".mysqli_error($dbc));
			$i=0;
			while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$query2 = "UPDATE PURCHASEORDERS SET STATUSCODE = '4' WHERE PURCHASEORDERNO = '$po'";
					if(mysqli_query($dbc,$query2)){
							
					$query3 ="UPDATE PURCHASEORDERDETAILS
									 SET QTYAVAILABLE='0'
									 WHERE MATERIALCODE = {$row['MATERIALCODE']} 
									 AND PURCHASEORDERNO = '$po'";
						$result3=mysqli_query($dbc,$query3)  or die("Error: ".mysqli_error($dbc));
		
					}
					$i++;
					
			}
		
		$message="Purchase Order cancelled! ";
		}

		
		 if (isset($message)){
      echo'
      <script type="text/javascript">
        alert("'.$message.'")
		window.location.href = "ThankYou.php";
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
        <!-- page content -->
        <div class="col-md-12">
          <div class="col-middle">
            <div class="text-center">
              <h1 class="error-number"></h1>
              
			  <img src="LOGO.png" alt="Mountain View" style="width:400px;height:80px;">
			  <h1>Purchase Order Form</h1>
			
			     <div class="clearfix"></div>  <div class="clearfix"></div>
				 
			   <div class="form-group">
                 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Purchase Order Form 
					
					<small> Generated on: 
					<?php
						$uri = $_SERVER['REQUEST_URI'];
						$int = filter_var($uri, FILTER_SANITIZE_NUMBER_INT);
						
						require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
						$query3 = "SELECT MAX(PURCHASEORDERNO), DATE FROM PURCHASEORDERS WHERE PURCHASEORDERNO = {$int} ";
						$result3 = mysqli_query($dbc, $query3);
						while($row = mysqli_fetch_array($result3, MYSQLI_ASSOC)){
							$dateSent = $row['DATE'];
						}
						
						echo $dateSent;
						
						?></small> </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

				  
				  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal "  >
                  <div class="x_content">

                   
                    <div class="table-responsive">
                     

                        <tbody>
						<?php
							
							$requestedPO = $_GET['PO'];
							
							require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
							$query="select  pod.PURCHASEORDERNO, pod.MATERIALCODE, pod.QTYORDERED, pod.UNIT,  m.MATERIALCODE, m.MATERIALNAME
							from purchaseorderdetails pod join materials m on m.MATERIALCODE = pod.MATERIALCODE
							where PURCHASEORDERNO = '$requestedPO' ";
							$result=mysqli_query($dbc,$query) or die("Error: ".mysqli_error($dbc));
							
							
							
							
							echo '<table id="datatable-responsive" class="table table-striped jambo_table bulk_action" cellspacing="0" width="100%">
							 <thead>
							<tr class="headings">
							
						
							<td width="30%"><div align="center"><b>Item Name
							</div></b></td>
							<td width="20%"><div align="center"><b>Quantity Ordered
							</div></b></td>
							<td width="20%"><div align="center"><b>Unit
							</div></b></td>
							<td width="20%"><div align="center"><b>Quantity Available
							</div></b></td>
							
							
							
							</tr>
							</thead>
							
							
							<tbody>';
							
						
							
							while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

							echo "<tr class=\"even pointer\">
							
							
							 				
							<td width=\"30%\"><div align=\"center\"   value = {$row['MATERIALCODE']}>{$row['MATERIALNAME']}
							</div></td>
							
							<td width=\"20%\"><div align=\"center\">{$row['QTYORDERED']}
							</div></td>
							<td width=\"20%\"><div align=\"center\">{$row['UNIT']}
							</div></td>
							<td>
							 <input type=\"number\" name=\"qtyavb[]\" size=\"20\" maxlength=\"30\" class=\"form-control col-md-3 col-xs-3\">
                           
                            </td>
							
							</tr>";

							}
						  
						
						
						
						
						?>
                          
                         
                          
                         
                          
                        
                          

                         
                          
                        </tbody>
                      </table>
                    </div>
					
					
               </div>
            </div>
			
				 <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          
						  <button type="submit" name="cancel" class="btn btn-lg btn-default">Cancel</button>
						  <button type="submit" name="submit" value="submit" class="btn btn-lg btn-primary" >Confirm</button>
                        </div>
			</div>
          </div>
        </div>        
						
               </div>
			   
			   
              
			  
			   
			   
              <div class="mid_center">
			  
                
              </div>
			  
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
  </body>
</html>