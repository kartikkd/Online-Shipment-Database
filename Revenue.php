<?php
	  session_start();
    header("X-XSS-Protection: 1; mode=block");
    require('config.php');
    include('header.php');
    //total orders
    $query = "select count(*) from orders where 1";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($result);
    $r = implode("",$row);

    //orders_delieverd
    $query1 = "select count(*) from agents where order_status = 'Delivered'";
    $result1 = mysqli_query($conn,$query1);
    $row1 = mysqli_fetch_assoc($result1);
    $r1 = implode("",$row1);
    //echo $r1;

    //orders remaining
    $query2 = "select count(*) from agents where order_status != 'Delivered'";
    $result2 = mysqli_query($conn,$query2);
    $row2 = mysqli_fetch_assoc($result2);
    //echo $row2['agent_id'];
    $r2 = implode("",$row2);
    //echo $r2;

    //total amount recieved
    $query3 = "select sum(prod_price) from orders ord ,product prd where ord.prod_id=prd.prod_id and ord.mop = 'Cash On Delivery'";
    $result3 = mysqli_query($conn,$query3);
    $row3 = mysqli_fetch_assoc($result3);
    $r3 = implode("",$row3);
    //echo $r3;

    //total amount remaining
    $query4 = "select sum(prod_price) from orders ord ,product prd where ord.prod_id=prd.prod_id and ord.mop != 'Cash On Delivery'";
    $result4 = mysqli_query($conn,$query4);
    $row4 = mysqli_fetch_assoc($result4);
    $r4 = implode("",$row4);
    //echo $r4;

    //$query4 = "insert into revenue(total_orders,order_delv,order_pend,amount_recv,amount_pend) values('$r','$r1','$r2','$r3','$r4')";
    //$result4 = mysqli_query($conn,$query4);
    
    $query5 = "CALL `dispRevenue`();";
    $result5 = mysqli_query($conn,$query5);
    $row5 = mysqli_fetch_assoc($result5);
  ?>
  <!DOCTYPE html>
  <html>
  <head>
  	<title>Products</title>
  	<style>
		body{
		  /*box-sizing: border-box;*/
		  background-image: url("showcase.jpg");
		  background-repeat: no-repeat;
		}
		.container {
			border: 100px;
		}

		#Input {
		  background-image: url('/css/searchicon.png');
		  background-position: 10px 10px;
		  background-repeat: no-repeat;
		  width: 100%;
		  font-size: 16px;
		  padding: 12px 20px 12px 40px;
		  border: 1px solid #ddd;
		  margin-bottom: 12px;
		}

		#Prod {
		  border-collapse: collapse;
		  width: 100%;
		  border: 1px solid #ddd;
		  font-size: 18px;
		  background-color: white;
		}

		#Prod th, #Prod td {
		  text-align: center;
		  padding: 12px;
		  /*background-color: #f8f9fa;*/

		}

		#Prod tr {
		  border-bottom: 1px solid #ddd;

		}

		#Prod tr.header, #Prod tr:hover {
		  background-color: #f8f9fa;
		  box-sizing: border-box;

		  }
	</style>
  </head>
  <body>
  	<div class="container" align="center">
  		
	  	<table class="Product-table" id="Prod">
	  		<tr class="header">
	  			<th>Total Orders Recieved</th>
	  			<th>Orders Delievered</th>
	  			<th>Orders Remaining</th>
	  			<th>Orders Through Cash</th>
	  			<th>Orders Through Online</th>
	  			
	  		</tr>
	  		<tbody id="Prod1">
	  			<input type="text" id="myInput" name="search" class="form-control" placeholder="Search for products" onkeyup="myFunction()">
    	  		<tr>
    			  	<td><?php echo $r; ?></td> 
    			  	<td><?php echo $r1; ?></td>
    			  	<td><?php echo $r2; ?></td>
    			  	<td><?php echo $r3; ?></td>
    			  	<td><?php echo $r4; ?></td>
    			  		
    	  		</tr>
	  	    </tbody>
	  	</table>
	</div>
	<script>
          $(document).ready(function(){
          $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#Prod1 tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        });	
	</script>
</body>
</html>