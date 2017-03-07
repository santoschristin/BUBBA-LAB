<!DOCTYPE html>

	<!-- START OF PHP -->
		<?php
		session_start();
		require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');

		
		$flag=0;
		
	
				
		if(isset($_POST["placeorder"])){
		$getempnoquery = "SELECT EMPLOYEENO FROM USERS WHERE USERNAME = '{$_SESSION['username']}'";
		$getempnoresult = mysqli_query($dbc, $getempnoquery) or die ("Error: ".mysqli_error($dbc));
		$getempnorow = mysqli_fetch_array($getempnoresult, MYSQLI_ASSOC) or die ("Error: ".mysqli_error($dbc));
		$employeeno = $getempnorow['EMPLOYEENO'];
		
		$qinsorderslip = "INSERT INTO ORDERSLIPS VALUES (null, '0',   '$employeeno', CURDATE(), CURTIME())";
		$result = mysqli_query($dbc,$qinsorderslip);
		$totalamount = 0; 

		if(isset($_POST["drinkname"])){
			$drinkarraysize = count($_POST["drinkname"]);
			for($count = 0; $count < $drinkarraysize; $count++){
				$query = "SELECT MAX(ORDERSLIPNO) FROM ORDERSLIPS";
				$result = mysqli_query($dbc, $query);
				$qgetlastosid = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$orderslipid = $qgetlastosid['MAX(ORDERSLIPNO)'];
				$prodname = $_POST["drinkname"][$count];
				$size = $_POST["size"][$count];
				$qgetprodid = "SELECT PRODUCTID FROM PRODUCTS WHERE PRODUCTNAME = '$prodname' AND SIZE = '$size'";
				$result = mysqli_query($dbc,$qgetprodid);
				$fetchprodid = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$prodid = $fetchprodid['PRODUCTID'];
				$toppingname = $_POST["topping"][$count];
				echo $toppingname;
				$qgettoppingcode = "SELECT TOPPINGCODE FROM DRINKTOPPINGS WHERE TOPPINGNAME = '$toppingname'";
				$result = mysqli_query($dbc,$qgettoppingcode);
				$fetchtopcode = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$topcode = $fetchtopcode['TOPPINGCODE'];
				$getquantityarray = $_POST["quantity"][$count];
				$getsugararray = $_POST["sugar"][$count];
				$insorderdetails = "INSERT INTO ORDERSLIPDETAILS VALUES ('$prodid', '$getquantityarray', '$orderslipid' , '$topcode', '$getsugararray')";
				$result3 = mysqli_query($dbc, $insorderdetails);
				$qgetdrinkprice = "SELECT PRICE FROM PRODUCTS WHERE PRODUCTID = '$prodid'";
				$result4 = mysqli_query($dbc, $qgetdrinkprice);
				$fetchdrinkprice = mysqli_fetch_array($result4, MYSQLI_ASSOC);
				$drinkprice = $fetchdrinkprice['PRICE'];
				$totalamount += $drinkprice * $getquantityarray;
			}
			
		}

		if(isset($_POST["foodname"])){
			$foodarraysize = count($_POST["foodname"]);
			for($count = 0; $count < $foodarraysize; $count++){
				$query = "SELECT MAX(ORDERSLIPNO) FROM ORDERSLIPS";
				$result = mysqli_query($dbc, $query);
				$qgetlastosid = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$orderslipid = $qgetlastosid['MAX(ORDERSLIPNO)'];
				$foodprodname = $_POST["foodname"][$count];
				$qgetfoodprodid = "SELECT PRODUCTID FROM PRODUCTS WHERE PRODUCTNAME = '$foodprodname'";
				$result = mysqli_query($dbc,$qgetfoodprodid);
				$fetchfoodprodid = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$foodprodid = $fetchfoodprodid['PRODUCTID'];
				$getfoodquantityarray = $_POST["foodquantity"][$count];
				$insorderdetails = "INSERT INTO ORDERSLIPDETAILS VALUES ('$foodprodid', '$getfoodquantityarray', '$orderslipid', null, null)";
				$result = mysqli_query($dbc, $insorderdetails);
				$qgetfoodprice = "SELECT PRICE FROM PRODUCTS WHERE PRODUCTID = '$foodprodid'";
				$result4 = mysqli_query($dbc, $qgetfoodprice);
				$fetchfoodprice = mysqli_fetch_array($result4, MYSQLI_ASSOC);
				$foodprice = $fetchfoodprice['PRICE'];
				$totalamount += $foodprice * $getfoodquantityarray;
			}
		}
			$query = "SELECT MAX(ORDERSLIPNO) FROM ORDERSLIPS";
			$result = mysqli_query($dbc, $query);
			$qgetlastosid = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$orderslipid = $qgetlastosid['MAX(ORDERSLIPNO)'];
			$updateamount = "UPDATE `bubbalab`.`orderslips` SET `AMOUNT`='$totalamount' WHERE `ORDERSLIPNO`= '$orderslipid'";
			$result = mysqli_query($dbc, $updateamount);
			
			header("Location: http://".$_SERVER['HTTP_HOST'].  dirname($_SERVER['PHP_SELF'])."/ConfirmPaymentMain.php");
			
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
              <a href="DashboardCashier.php" class="site_title"><i class="fa fa-coffee"></i> <span>BUBBA LAB</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                 <h2><?php echo $_SESSION['employeename'];?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

               <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                    <h3><?php echo $_SESSION['title'];?></h3>
                <ul class="nav side-menu">
                  <li class="nav child_menu">
                      <li><a><i class="fa fa-home"></i><href="DashboardCashier.php">Dashboard</a></li>
                  </li>
                   <li><a href="PlaceOrder.php"><i class="fa fa-desktop"></i> Place Order</a>
				   
				   <li><a href="VerifySales.php"><i class="fa fa-table"></i> Verify Daily Sales</a>
				   
				    <li><a href="ChangeShift.php"><i class="fa fa-calendar"></i> Change Shift</a>
				   
                 
                  
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
                    <img src="images/img.jpg" alt=""><?php echo $_SESSION['employeename']."<br>";?>
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
                <h3>Place Order 
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

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   
                    <ul class="nav navbar-right panel_toolbox">
                      <ol class="breadcrumb">
					<li><a href="DashboardCashier.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
					<li class="active">Place Order</li>
					</ol>
                    </ul>
					 <h3>Place Order</h3>	
                    <div class="clearfix"></div>
                  </div>
                  <div>
                   
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal form-label-left"  >
					  
					 
                      <div class="form-group">
					  
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Drink Orders:
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12	">
                           <TABLE id="orders" width="250px" border="1" class='table table-bordered table-hover text-center'>
						  
							<TR id="tr1">
								
								<TD id="drink">
								</TD>
								<TD id="size">  </TD>
								<TD id="quan">  </TD>
								
								<TD id="topping">
								<TD id="sugarlevel">
								 
								</TD>
							</TR id ="tr2">
							
							
						</TABLE>
						
							<div align="left"><input type="button" class="btn btn-primary" name="adddrink" id = "ad" value="Add Drink" /></div> 
						  
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" > Food Orders:
                        </label>
                        <div class="col-md-7 col-sm-7 col-xs-12">
							<TABLE id="orders" width="250px" border="1" class='table table-bordered table-hover text-center'>
						  
							<TR id="tr1">
								
								<TD id="food">
								</TD>
								<TD id="quantity">  </TD>
								 
								
							</TR id ="tr2">
							
							
						</TABLE>
						
							<div align="left"><input type="button" class="btn btn-primary" name="adddrink" id = "af" value="Add Food" /></div> 
                        </div>
                      </div>
                      
					  
						<div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-10">
                          
                         <!-- Button trigger modal Supplier -->
						<button type="button" class="btn btn-info pull-left btn-flat" data-toggle="modal" data-target="#myModal">
							Display Products
							</button>	
						
							<!-- Modal DISPLAY INVENTORY -->
							<div class="modal fade modal-default" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h3 class="modal-title" id="myModalLabel">Products</h3>
										</div>
										<div class="modal-body">
											<!-- MAIN CONTENT START -->
											<table id='example1' class='table table-bordered table-striped'>
												<thead>
													<tr>
														<th>Product Name</th>
														<th>Price</th>
														<th>Size</th>
													</tr>
												</thead>
												<tbody>


													<?php
													require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
													$query2="SELECT PRODUCTNAME, PRICE, SIZE
													FROM products";
													$result=mysqli_query($dbc,$query2)or die("Error: ".mysqli_error($dbc));

													while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

														echo "<tr>
														
														<td>".$row['PRODUCTNAME']."
														</td>
														<td>".$row['PRICE']."
														</td>
														<td>".$row['SIZE']."
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
                           <button type="submit" class="btn btn-default">Cancel</button>
                          <button type="submit" name="placeorder" value="placeorder" class="btn btn-primary">Place Order</button>
						 
                        </div>
                      </div>

                    </form>
                  </div>
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


<script src = "jquery.js"></script>
</div>
<script>
	var drinkarray = 0;
	var foodarray = 0;
	$(document).ready(function()
	{
		$("#ad").click(function() {
		var getdrinkname = "<?php $qdrinkname = "SELECT PRODUCTNAME FROM PRODUCTS WHERE TYPE = 1 AND SIZE = 'Medium'"; $result=mysqli_query($dbc,$qdrinkname); echo "<option default>Drinks</option>"; while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){  echo "<option value = '{$row['PRODUCTNAME']}'>{$row['PRODUCTNAME']}</option>";} ?>";
		var getsize = "<?php $qsize = "SELECT SIZE FROM REF_SIZES WHERE SIZE != 'N/A'"; $result = mysqli_query($dbc, $qsize); echo "<option default>Size</option>"; while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){ echo "<option value = '{$row['SIZE']}'>{$row['SIZE']}</option>";}?>";
		var getsugarlevel = "<?php $qsugar = "SELECT SUGARLEVEL FROM REF_SUGARLEVELS"; $result=mysqli_query($dbc,$qsugar); echo "<option default>Sugar Level</option>"; while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){ echo "<option value = '{$row['SUGARLEVEL']}'>{$row['SUGARLEVEL']}</option>";}?>";
		var gettoppings = "<?php $qtopping = "SELECT TOPPINGNAME FROM DRINKTOPPINGS"; $result=mysqli_query($dbc,$qtopping); echo "<option default>Topping</option>"; while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){  echo "<option value = '{$row['TOPPINGNAME']}'>{$row['TOPPINGNAME']}</option>";}?>";
			
			
			$("#tr1").append('<tr>');
			$("#drink").append('<select name = "drinkname[]" class="form-control col-md-7 col-xs-12"  placeholder="Drinks" > '  + getdrinkname + ' </select>' );
			$("#size").append(' <select name = "size[]" class="form-control col-md-7 col-xs-12"  placeholder="Size"> ' + getsize + '</select>');
			$("#quan").append('<input type = "number" name= "quantity[]" size = "1" maxlength = "30" placeholder="Quantity" class="form-control col-md-7 col-xs-12"/>');
			$("#topping").append('<select name = "topping[]" class="form-control col-md-7 col-xs-12" placeholder="Topping"> ' + gettoppings + '</select>');
			$("#sugarlevel").append('<select name = "sugar[]" class="form-control col-md-7 col-xs-12" placeholder="Sugar Level"> ' + getsugarlevel + ' </select>' );
			$("#tr2").append('</tr>');

		}
		);
		
		$("#af").click(function(){
		var getfoodname = "<?php $qfoodname = "SELECT PRODUCTNAME FROM PRODUCTS WHERE TYPE = 2"; $result=mysqli_query($dbc,$qfoodname); echo "<option default>Food</option>"; while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){ echo "<option value = '{$row['PRODUCTNAME']}'>{$row['PRODUCTNAME']}</option>";}?>";
			
			
								
			$("#tr1").append('<tr>');
			$("#food").append( '<select name = "foodname[]" class="form-control col-md-7 col-xs-12"  placeholder="Food"> ' + getfoodname + ' </select>' );
			
			$("#quantity").append('<input type = "number" name = "foodquantity[]" class="form-control col-md-7 col-xs-12"  placeholder="Quantity">');
		
			$("#tr2").append('</tr>');
		}
		);
	}
	); 
</script>

	
  </body>
</html>
