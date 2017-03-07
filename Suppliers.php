<!DOCTYPE html>
<?php
session_start();
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
                  
				   <li><a href="Dashboard.php"><i class="fa fa-home"></i> Dashboard</a><li>
				  
				
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
				   
				                    
				   <li><a href="ConfirmReplenish.php"><i class="fa fa-list-alt"></i> Confirm Delivery</a><li>
				   <li><a href="NewPullOut.php"><i class="fa fa-share"></i> Pull Out</a><li>
				   <li><a href="NewReturnStock.php"><i class="fa fa-check"></i> Return Stock</a><li>
					
					
                  <li><a><i class="fa fa-table"></i> Generate Reports <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					  <li><a href="GenerateSalesReport.php">Sales Report</a></li>
					  <li><a href="GenerateSuppliers.php">Suppliers Report</a></li>
					  <li><a href="GenerateSalesDiscrepancy.php">Sales Discrepancy Report</a></li>
					    <li><a href="GenerateDiscrepancy.php">Inventory Discrepancy Report</a></li>
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
                    <img src="images/img.jpg" alt=""><?php echo $_SESSION['employeename'];?>
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
                <h3>BUBBALAB FOOD SERVICES <br><small>C & B Mall Liwasang Kalayaan, Marikina Heights, Marikina City <br>
					Telephone number: </small></h3>
				
              </div>

             
            </div>

            <div class="clearfix"></div>

            
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h3>Suppliers <small> as of October 2016</small></h3>
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
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table.
                    </p>
                    
					<?php
						
						require_once('C:\xampp\htdocs\APPDEV\production\appdev_mysqlconnect.php');
						$query="select supplierID,dateAdded,supplierName,ownerName,curAddress,telnumber,celnumber,emailAddress,supDescription
								from suppliers 
								where date(dateAdded) >= ".$_SESSION["startDate"]." 
								  or date(dateAdded) <= ".$_SESSION["endDate"]." ";
						$result=mysqli_query($dbc,$query);

						
						echo '<table id="datatable-responsive" class="table table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
						 <thead>
						<tr>
						<th width="15%"><div align="center"><b>Supplier ID
						</div></b></th>
						<th width="15%"><div align="center"><b>Date Added
						</div></b></th>
						<th width="15%"><div align="center"><b>Supplier Name
						</div></b></th>
						<th width="15%"><div align="center"><b>Owner Name
						</div></b></th>
						<th width="20%"><div align="center"><b>Current Address
						</div></b></th>
						<th width="10%"><div align="center"><b>Telephone Number
						</div></b></th>
						<th width="10%"><div align="center"><b>Cellphone Number
						</div></b></th>
						<th width="10%"><div align="center"><b>Email Address
						</div></b></th>
						<th width="10%"><div align="center"><b>Description
						</div></b></th>
						</tr>
						</thead>';


						while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){

						echo "<tr>
						<td width=\"15%\"><div align=\"center\">{$row['supplierID']}
						</div></td>
						<td width=\"15%\"><div align=\"center\">{$row['dateAdded']}
						</div></td>
						<td width=\"15%\"><div align=\"center\">{$row['supplierName']}
						</div></td>
						<td width=\"15%\"><div align=\"center\">{$row['ownerName']}
						</div></td>
						<td width=\"20%\"><div align=\"center\">{$row['curAddress']}
						</div></td>
						<td width=\"10%\"><div align=\"center\">{$row['telnumber']}
						</div></td>
						<td width=\"10%\"><div align=\"center\">{$row['celnumber']}
						</div></td>
						<td width=\"10%\"><div align=\"center\">{$row['emailAddress']}
						</div></td>
						<td width=\"10%\"><div align=\"center\">{$row['supDescription']}
						</div></td>
						</tr>";

						}
						echo '</table>';

					

					?>

                  </div>
                </div>
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
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
	
	<script>
		jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("SupplierHistory.php");
    });
	});
	
	</script>

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->
  </body>
</html>