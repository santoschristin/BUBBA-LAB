<html>
<table id = "dataTable" style = "width: 100%">
<body bgcolor = "D3D3F3">
<tr>
	<th>Product Name</th>
	<th>Size</th>
	<th>Quantity</th>
</tr>
<?php
	require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
	$products = array();
	$productqty = array();
	$productsize = array();
	
	$dateclicked = '2016-11-16';
	$qprodid = "SELECT PRODUCTID FROM ORDERSLIPDETAILS OD JOIN ORDERSLIPS O ON OD.ORDERSLIPNO = O.ORDERSLIPNO  WHERE O.DATE = CURDATE()";
	$runprodid = mysqli_query($dbc, $qprodid);
	
	while($fetchprodid = mysqli_fetch_array($runprodid, MYSQLI_ASSOC)){
		$prodid =$fetchprodid['PRODUCTID'];
		$qgetprodname = "SELECT PRODUCTNAME FROM PRODUCTS WHERE PRODUCTID = '$prodid'";
		$runprodname = mysqli_query($dbc, $qgetprodname);
		$fetchprodname = mysqli_fetch_array($runprodname, MYSQLI_ASSOC);
		$prodname = $fetchprodname['PRODUCTNAME'];
		$qgetqty = "SELECT OD.QUANTITY FROM ORDERSLIPDETAILS OD JOIN ORDERSLIPS O ON OD.ORDERSLIPNO = O.ORDERSLIPNO WHERE O.DATE = CURDATE() AND PRODUCTID = '$prodid'";
		$runqty = mysqli_query($dbc, $qgetqty);
		$fetchqty = mysqli_fetch_array($runqty, MYSQLI_ASSOC);
		$qty = $fetchqty['QUANTITY'];
		$qgetsize = "SELECT SIZE FROM PRODUCTS WHERE PRODUCTID = '$prodid'";
		$runsize = mysqli_query($dbc, $qgetsize);
		$fetchsize = mysqli_fetch_array($runsize, MYSQLI_ASSOC);  
		$size = $fetchsize['SIZE'];
		
		$checker = false;
		for($count = 0; $count < sizeof($products); $count++){
			if($products[$count] == $prodname && $productsize[$count] == $size){
				$productqty[$count] += $qty;	
				$checker = true;
			}
		}
		if($checker == false){
			array_push($products, $prodname);
			array_push($productqty, $qty);
			array_push($productsize, $size);
		}
	}
	
	for($index = 0; $index < sizeof($products); $index++){
		echo "<tr><td>".$products[$index]."</td>";
		echo "<td>".$productsize[$index]."</td>";
		echo "<td>".$productqty[$index]."</td></tr>";
	}
	
?>

<style>
	table, th, td {
		border: 1px solid;
	}
</style>
</html>