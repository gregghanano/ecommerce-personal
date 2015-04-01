<!DOCTYPE html>
<html>
<head>
	<title>ecommerce products</title>
	<style>
	body {
		width:970px;
	}
	.header {
		 background-color: #CC0000;
		 height: 60px;
		 color: white;
	}
	h1 {
		font-size:20px;
		display:inline;
		margin-left:20px;
		margin-top:30px;
	}
	ul{
		display:inline-block;
	}
	li {
		display:inline;
		margin-right: 20px;
	}
	#log-off{
		display:inline-block;
		float:right;
		margin-right: 50px;
	}
	.orders-products:link {
		color:white;
		text-decoration:none;
	}
	.orders-products:visited {
		color:white;
		text-decoration:none;
	}
	.orders-products:hover{
		text-decoration:underline;
	}
	.orders-products:active{
		text-decoration:underline;
	}
	#customer-info{
		height: 325px;
		width: 250px;
		border:1px solid black;
		margin-top: 10px;
		margin-left: 20px;
		display:inline-block;
	}
	.shipping-billing-info p{
		display: block;
		margin: 0px;
	}
	.shipping-billing-info{
		margin-top:20px;
		margin-left: 5px;
	}
	#customer-info h4 {
		margin: 0px;
		margin-top: 10px;
		margin-left: 5px;
	}
	table {
		display: inline-block;
		margin: 0px;
		vertical-align:top;
		position:absolute;
		left: 350px;
		top: 100px;
	}
	table, tr, td, th {
		border: 1px solid black;
		border-collapse: collapse;
	}
	td, th {
		padding: 5px;
		margin-left: 20px;
		padding-right: 50px;
	}
	th {
		background-color:#CDC5BF;
	}
	.gray {
		background-color: #eeecec;
	}
	.order-shipped, .order-process, .order-cancelled {
		width: 200px;
		border: 1px solid black;
		background-color: #D5F45D;
		display: inline-block;
		vertical-align:top;
		position:absolute;
		left:350px;
		top:250px;
	}
	.order-shipped p, .order-process p, .order-cancelled p {
		margin:0px;
		margin: 5px;
	}
	.order-process {
		background-color: #FFDB00;
	}
	.order-process p {
		margin:0px;
		margin: 5px;
	}
	.order-cancelled {
		background-color: #ff2f2f;
	}
	.order-cancelled p {
		margin:0px;
		margin: 5px;
	}
	#total {
		border: 1px solid black;
		display: inline-block;
		position:absolute;
		right: 200px;
		top:250px;
		padding: 5px;
	}
	#total p {
		margin: 0px;
		margin-bottom: 5px;
		margin-right: 5px;
	}
	</style>
</head>
<body>
	<div class='header'>
		<h1>Dashboard</h1>
			<ul>
				<li><a class='orders-products' href='/Admins/orders'>Orders</a></li>
				<li><a class='orders-products' href='/Admins/product_inventory'>Products</a></li>
			</ul>
		<p id='log-off'><a class='orders-products' href='/Admins/logout'>log off</a></p>
	</div>
	<div id='customer-info'>
		<h4>Order ID: <?=$customer['id']?></h4>
		<div class = 'shipping-billing-info'>
			<p>Customer Shipping Info:</p>
			<p>name: <?=$shipping['first_name']?> <?=$shipping['last_name']?></p>
			<p>address: <?=$shipping['address']?> <?=$shipping['address_2']?></p>
			<p>city: <?=$shipping['city']?></p>
			<p>state: <?=$shipping['state']?></p>
			<p>zip: <?=$shipping['zipcode']?></p>
		</div>
		<div class = 'shipping-billing-info'>
			<p>Customer Billing info:</p>
			<p>name: <?=$customer['first_name']?> <?=$customer['last_name']?></p>
			<p>address: <?= $customer['address']?> <?=$customer['address_2']?></p>
			<p>city: <?= $customer['city']?></p>
			<p>state: <?= $customer['state']?></p>
			<p>zip: <?= $customer['zipcode']?></p>
		</div>
	</div>
	<table>
		<tr>
			<th>ID</th>
			<th>Item</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total</th>
		</tr>
		<?php 
		foreach($products as $product)
		{  
			if($product%2) {?>

				<tr class='gray'>
					<td><?=$product['id']?></td>
					<td><?=$product['name']?></td>
					<td>$<?=$product['price']?></td>
					<td><?=$product['products_quantity']?></td>
					<td><?= $product['products_quantity'] * $product['price']?></td>
				</tr>		
		<?php }
		} ?>

		<!-- <tr class='gray'>
			<td>35</td>
			<td>cup</td>
			<td>$9.99</td>
			<td>1</td>
			<td>$9.99</td>
		</tr>
		<tr>
			<td>215</td>
			<td>shirt</td>
			<td>$19.99</td>
			<td>2</td>
			<td>$39.98</td>
		</tr> -->
	</table>
	<div class='order-shipped'>
		<p>Status: shipped</p>
	</div>
	<?php 
		if($product['order_status'] == 'Shipped')
			{ ?>
			<div class='order-shipped'>
				<p>Status: shipped</p>
			</div>
<?php } elseif($product['order_status'] == 'Order in Process')
{ ?>
				<div class='order-process'>
					<p>Status: Order in Process</p>
				</div>
<?php } elseif ($product['order_status'] == 'Cancelled') { ?>
				<div class='order-cancelled'>
					<p>Status: Cancelled</p>
				</div>
			<?php }?>
	<div id='total'>
		<p>Sub total: $<?php
			$total = 0;
			foreach($products as $product)
				{
					$temp = $product['products_quantity'] * $product['price'];
					$total= $total + $temp;
				}
				echo $total;
				?></p>
		<p>Shipping: $<?= $shipping['price']?></p>
		<p>Total Price: $<?= $total + $shipping['price']?></p>
	</div>
</body>
</html>