
<html>
<body bgcolor = "D3D3F3">
<table id = "dataTable" style = "width: 100%">
<tr>
	<th>Product Name</th>
	<th>Size</th>
	<th>Unit Price</th>
	<th>Quantity</th>
	<th>Amount</th>
</tr>
<?php
	require_once('C:\xampp\htdocs\appdev_mysqlconnect.php');
	$query = "SELECT MAX(ORDERSLIPNO) FROM ORDERSLIPS";
	$result = mysqli_query($dbc,$query);
	$getlastos = mysqli_fetch_array($result, MYSQLI_ASSOC);
	$lastos = $getlastos['MAX(ORDERSLIPNO)'];
	$qgetproducts = "SELECT PRODUCTID FROM ORDERSLIPDETAILS OD WHERE OD.ORDERSLIPNO = '$lastos'";
	$runquery = mysqli_query($dbc, $qgetproducts);
	
	while($fetchproductsordered = mysqli_fetch_array($runquery, MYSQLI_ASSOC)){
		$prodid = $fetchproductsordered['PRODUCTID'];
		$qgetprodtype = "SELECT TYPE FROM PRODUCTS P WHERE P.PRODUCTID = '$prodid'";
		$rungettype = mysqli_query($dbc, $qgetprodtype);
		$fetchprodtype = mysqli_fetch_array($rungettype, MYSQLI_ASSOC);
		$prodtype = $fetchprodtype['TYPE'];
		$qgetprodname = "SELECT PRODUCTNAME FROM PRODUCTS P WHERE P.PRODUCTID = '$prodid'";
		$rungetprod = mysqli_query($dbc, $qgetprodname); 
		$fetchprodname = mysqli_fetch_array($rungetprod, MYSQLI_ASSOC);
		$prodname = $fetchprodname['PRODUCTNAME'];
		$qgetsize = "SELECT SIZE FROM PRODUCTS P WHERE P.PRODUCTID = '$prodid'";
		$rungetsize = mysqli_query($dbc, $qgetsize);
		$fetchsize = mysqli_fetch_array($rungetsize, MYSQLI_ASSOC);
		$size = $fetchsize['SIZE'];
		
		$qgetunitprice = "SELECT PRICE FROM PRODUCTS P WHERE P.PRODUCTID = '$prodid'";
		$rungetunitprice = mysqli_query($dbc, $qgetunitprice);
		$fetchunitprice = mysqli_fetch_array($rungetunitprice, MYSQLI_ASSOC);
		$unitprice = $fetchunitprice['PRICE'];
		
		$qgetprodqty = "SELECT QUANTITY FROM ORDERSLIPDETAILS OD WHERE OD.PRODUCTID = '$prodid' AND OD.ORDERSLIPNO = '$lastos'";
		$rungetqty = mysqli_query($dbc, $qgetprodqty); 
		$fetchprodqty = mysqli_fetch_array($rungetqty, MYSQLI_ASSOC);
		$qty = $fetchprodqty['QUANTITY'];
			 
		$qgetprice = "SELECT PRICE FROM PRODUCTS P WHERE P.PRODUCTID = '$prodid'";
		$rungetprice = mysqli_query($dbc, $qgetprice); 
		$fetchprice = mysqli_fetch_array($rungetprice, MYSQLI_ASSOC);
		$amount = $fetchprice['PRICE'] * $qty;
	
			 
		echo "<tr><td>".$prodname."</td>";
		echo "<td>".$size."</td>";
		echo "<td>".$unitprice."</td>";
		echo "<td>".$qty."</td>";
		echo "<td>".$amount."</td></tr>";
	}
	
	$qgettotal = "SELECT AMOUNT FROM ORDERSLIPS O WHERE O.ORDERSLIPNO = '$lastos'";
	$runqgettotal = mysqli_query($dbc, $qgettotal); 
	$fetchtotal = mysqli_fetch_array($runqgettotal, MYSQLI_ASSOC);
	$total = $fetchtotal['AMOUNT'];
	
	if(isset($_POST["nexttrans"])){
		$qgetdailysales = "SELECT TOTALSALES FROM DAILYSALES WHERE DATE = CURDATE();";
		$rundailysales = mysqli_query($dbc, $qgetdailysales);
		$fetchdailysales = mysqli_fetch_array($rundailysales, MYSQLI_ASSOC);
		$dailysales = $fetchdailysales['TOTALSALES'] + $total;
		$updatesales = "UPDATE `appdev`.`dailysales` SET `TOTALSALES`='$dailysales' WHERE `DATE`= CURDATE()";
		$runupdate = mysqli_query($dbc, $updatesales);
		$qgetproducts = "SELECT PRODUCTID FROM ORDERSLIPDETAILS OD WHERE OD.ORDERSLIPNO = '$lastos'";
		$runquery = mysqli_query($dbc, $qgetproducts);
		
		while($fetchproductsordered = mysqli_fetch_array($runquery, MYSQLI_ASSOC)){
			$prodid = $fetchproductsordered['PRODUCTID'];
			$qgetingre = "SELECT MATERIALCODE FROM MATERIALSUSED WHERE PRODUCTID = '$prodid'";
			$runingre = mysqli_query($dbc, $qgetingre);
			$qgetprodqty = "SELECT QUANTITY FROM ORDERSLIPDETAILS OD WHERE OD.PRODUCTID = '$prodid' AND OD.ORDERSLIPNO = '$lastos'";
			$rungetqty = mysqli_query($dbc, $qgetprodqty); 
			$fetchprodqty = mysqli_fetch_array($rungetqty, MYSQLI_ASSOC);
			$qty = $fetchprodqty['QUANTITY'];
			$qgetprodtype = "SELECT TYPE FROM PRODUCTS P WHERE P.PRODUCTID = '$prodid'";
			$rungettype = mysqli_query($dbc, $qgetprodtype);
			$fetchprodtype = mysqli_fetch_array($rungettype, MYSQLI_ASSOC);
			$prodtype = $fetchprodtype['TYPE'];
			
			if($prodtype == 1){
				//Subtract toppings from Inventory
				$qgettopcode = "SELECT TOPPINGCODE FROM ORDERSLIPDETAILS OD WHERE OD.PRODUCTID = '$prodid' AND OD.ORDERSLIPNO = '$lastos'";
				$rungettopcode = mysqli_query($dbc, $qgettopcode);
				$fetchgettopcode = mysqli_fetch_array($rungettopcode, MYSQLI_ASSOC);
				$topcode = $fetchgettopcode['TOPPINGCODE'];
				
				$qgettopvalue = "SELECT VALUE FROM DRINKTOPPINGS WHERE TOPPINGCODE = '$topcode'";
				$rungettopvalue = mysqli_query($dbc, $qgettopvalue);
				$fetchttopvalue = mysqli_fetch_array($rungettopvalue, MYSQLI_ASSOC);
				$topvalue = $fetchttopvalue['VALUE'];
				
				$qgettopmat = "SELECT MATERIALCODE FROM DRINKTOPPINGS WHERE TOPPINGCODE = '$topcode'";
				$rungettopmat = mysqli_query($dbc, $qgettopmat);
				$fetchttopmat = mysqli_fetch_array($rungettopmat, MYSQLI_ASSOC);
				$topmat = $fetchttopmat['MATERIALCODE'];
				$totalmat= $qty * $topvalue;
				
				$qgettopqty = "SELECT QUANTITYINSTOCK FROM INVENTORY WHERE MATERIALCODE = '$topmat'";
				$rungettopqty = mysqli_query($dbc, $qgettopqty);
				$fetchtopqty = mysqli_fetch_array($rungettopqty, MYSQLI_ASSOC);
				$topqty = $fetchtopqty['QUANTITYINSTOCK'];
				$topqty -= $totalmat;
				
				$updatetopqty = "UPDATE `appdev`.`inventory` SET `QUANTITYINSTOCK`='$topqty' WHERE `MATERIALCODE`='$topmat'";
				$runupdatetopqty = mysqli_query($dbc, $updatetopqty);
				//End subtract of toppings from Inventory
				
				//Subtract sugar from Inventory
				$qgetsugar = "SELECT SUGARLEVEL FROM ORDERSLIPDETAILS OD WHERE OD.PRODUCTID = '$prodid' AND OD.ORDERSLIPNO = '$lastos'";
				$rungetsugar = mysqli_query($dbc, $qgetsugar);
				$fetchgetsugar = mysqli_fetch_array($rungetsugar, MYSQLI_ASSOC);
				$sugar = $fetchgetsugar['SUGARLEVEL'];
				
				$qgetsugarvalue = "SELECT VALUE FROM REF_SUGARLEVELS WHERE SUGARLEVEL = '$sugar'";
				$rungetsugarvalue = mysqli_query($dbc, $qgetsugarvalue);
				$fetchsugarvalue = mysqli_fetch_array($rungetsugarvalue, MYSQLI_ASSOC);
				$sugarvalue = $fetchsugarvalue['VALUE'];
				
				$qgetsugarmat = "SELECT MATERIALCODE FROM REF_SUGARLEVELS WHERE SUGARLEVEL = '$sugar'";
				$rungetsugarmat = mysqli_query($dbc, $qgetsugarmat);
				$fetchsugarmat = mysqli_fetch_array($rungetsugarmat, MYSQLI_ASSOC);
				$sugarmat = $fetchsugarmat['MATERIALCODE'];
				$totalsugarmat = $qty * $sugarvalue;
				
				$qgetsugarqty = "SELECT QUANTITYINSTOCK FROM INVENTORY WHERE MATERIALCODE = '$sugarmat'";
				$rungetsugarqty = mysqli_query($dbc, $qgetsugarqty);
				$fetchsugarqty = mysqli_fetch_array($rungetsugarqty, MYSQLI_ASSOC);
				$sugarqty = $fetchsugarqty['QUANTITYINSTOCK'];
				$sugarqty -= $totalsugarmat;
				
				$updatesugarqty = "UPDATE `appdev`.`inventory` SET `QUANTITYINSTOCK`='$sugarqty' WHERE `MATERIALCODE`='$sugarmat'";
				$runupdatesugarqty = mysqli_query($dbc, $updatesugarqty);
				//End subtract of sugar from Inventory
			}
			
			while($fetchingre = mysqli_fetch_array($runingre, MYSQLI_ASSOC)){
				$matcode = $fetchingre['MATERIALCODE'];
				$qgetmatqty = "SELECT QUANTITY FROM MATERIALSUSED WHERE PRODUCTID = '$prodid'";
				$runmatqty = mysqli_query($dbc, $qgetmatqty);
				$fetchmatqty = mysqli_fetch_array($runmatqty, MYSQLI_ASSOC);
				$matqty = $fetchmatqty['QUANTITY'] * $qty;
				$qgetinvvalue = "SELECT QUANTITYINSTOCK FROM INVENTORY I WHERE MATERIALCODE = $matcode";
				$runinvvalue = mysqli_query($dbc, $qgetinvvalue);
				$fetchinvvalue = mysqli_fetch_array($runinvvalue, MYSQLI_ASSOC);
				$invvalue = $fetchinvvalue['QUANTITYINSTOCK'];
				$invvalue = $invvalue - $matqty;
				$updateqtyinstock = "UPDATE `appdev`.`inventory` SET `QUANTITYINSTOCK`='$invvalue' WHERE MATERIALCODE = '$matcode'";
				$runupdatestock = mysqli_query($dbc, $updateqtyinstock);
			}
		}
	}
?>
</table>

<div>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<p> Total Orders: <?php echo $total?>
<p> Cash Given: <input type = "text" name = "cashgiven" size="20" maxlength= "30"/>
<div id = "divid"> </div>
<div align="center"><input type="button" name="confirmpay" id = "confirm" value="Confirm!" /></div>
<div align="center"><input type="submit" name="nexttrans" value = "Next Transaction"/></div>
</form>

<script src = "jquery.js"></script>
</div>
<script>
$(document).ready(function(){
		$("#confirm").click(function() {
			var cuschange = "<?php echo $change?>";
			$("#divid").append('<p> Change: ' + cuschange');
		});
});
	
</script>
<style>
	table, th, td {
		border: 1px solid;
	}
</style>
</html>

