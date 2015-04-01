<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Dashboard Orders</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	// $(document).ready(function(){
	// 	$("#myModal").modal('show');
	// });
	</script>
	<style>
		body{
			width:970px;
		}
		#entire-body{
			margin-left: 20px;
		}
/*		CSS FOR SEARCH BAR

*/		#search{
			width:970px;
			display: inline-block;
		}
		.search-box{
				width: 400px;
				border-radius:10px;
				display: inline-block;
		}
		.search-form{
			display:inline-block;
		}
		#add-form{
			display:inline-block;
			margin-left: 400px;
		}
		#add-new-product{
			background-color:blue;
			color:white;
			box-shadow: 5px 5px 5px black;
			border: solid 1px black;
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
		.add-product{
			margin-left: 80%;
		}
/*		CSS FOR TABLE

*/		table{
			border: 1px solid black;
			border-collapse: collapse;
			width:950px;
			margin-top: 10px;
		}
		th{
			background-color: #989898;
			border: 1px solid black;
			border-collapse: collapse;
		}
		td{
			border: 1px solid black;
			border-collapse: collapse;
			padding-left: 50px;
			
		}
		.gray{
			background-color: #C8C8C8;
		}
		.show{
			margin-left: 450px;
			vertical-align: top;
			display: inline;
		}
		img{
			height: 30px;
			width: 50px;
		}
		.delete{
			padding-left: 20px;
		}

/*		CSS FOR UL

*/		ul{
		display: inline-block;
		}
		.numbers li{
			border-right: 1px solid black;
			padding-left: 10px;
			padding-right: 10px;
		}
		li:last-child{
			border-right: none;
		}
		.numbers{
			margin-left: 150px;
		}
/*		CSS for Modal
*/
/*			h1 {
		margin-left: 100px;
	}*/
	label {
		display:block;
	}
	#main {
		text-align:center;
	}
	.field {
		margin-left: 5px;
		margin-top:8px;
	}
	.image {
		display:block;
	}
	#cancel, #preview, #update{
		display: inline-block;
		margin-right: 20px;
	}
	#buttons{
		text-align:center;
		margin-top: 30px;
	}
	.cancel, .preview, .update{
		border-radius: 0px;
		font-size: 20px;
	}
	.cancel {
		background-color:#CDC5BF;
		color:black;
	}
	.preview {
		background-color:#83B51E;
		color:black;
	}
	.update {
		background-color:#3366FF;
		color:white;
	}
		
	</style>
</head>
<body>
	<div id='entire-body'>
	<div class='header'>
			<h1>Dashboard</h1>
				<ul>
					<li><a class='orders-products' href='/Admins/orders'>Orders</a></li>
					<li><a class='orders-products' href='#'>Products</a></li>
				</ul>
			<p id='log-off'><a class='orders-products' href='/Admins/logout'>log off</a></p>
	</div>

	<div id="search">
		<form class='search-form' action='/Admins/search_product' method='post'>
				<input class='search-box' type='text' name='search' placeholder='search'>
		</form>
	</div>
	<div class='add-product'>
      <a href="#" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#largeModal">Add Product</a>
 	 </div>
	<!-- ADD PRODUCT MODAL -->
	<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h1 class="modal-title" id="myModalLabel">Add Product</h1>
	      </div>
	      <div class="modal-body">
	       <div id='main'>
		<form action='/Admins/insert_product' method='post'>
			<label>Name: <input class='field' type='text' name='product_name' placeholder='Name of product...'></label>
			<label>Description: <textarea class='field' name='product_description' placeholder='Description of product...'></textarea></label>
			<label>Categories: <select class='field' name='product_category' placeholder='Pick a category'>
				<option value='bridge'>Bridge</option>
				<option value='monument'>Mounument</option>
				<option value='statue'>Statue</option>
			</select></label>
			<label>or add a new category: <input class='field' type='text' name='new_category'></label>
			<label>Price: <input class='field' type='text' name='product_price' placeholder='Price'></label>
			<label>Inventory Count: <input class='field' type='text' name='inventory_count' placeholder='inventory count'></label>
			<!-- <label>Images: <input class='field' type='tex' name='image' accept='image/*'></label> -->
			<label>Image name: <input class='field' type='text' name='img_name' placeholder='image name'></label>
			<label>Add Image URL here: <input type='text' name='img_url' placeholder='Image URL here'></label>

			<!-- needs jquery draggable content
			<!- <ul>
				<li><div class='image'><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
					<img src=''>img.png <input type='radio' name='main' value='main'>Main
				</div>
				</li>
				<li><div class='image'><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
					<img src=''>img.png <input type='radio' name='main' value='main'>Main
				</div>
				</li>
				<li><div class='image'><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
					<img src=''>img.png <input type='radio' name='main' value='main'>Main
				</div>
				</li>
			</ul> -->
	</div>
	      </div>
	      <div class="modal-footer">
	        <div id='buttons'>
			<input class='cancel' type='submit' name='cancel' value='Cancel'>
			<input class='preview' type='submit' name='preview' value='Preview'>
			<input class='update' type='submit' name='update' value='Update'>
		</form>
		</div>
	      </div>
	    </div>
	  </div>
	</div>

	<table>
		<thead>
			<th>Picture</th>
			<th>ID</th>
			<th>Name</th>
			<th>Inventory Count</th>
			<th>Quantity Sold</th>
			<th>Action</th>
		</thead>
		<tbody>
			<?php
				foreach($products as $key => $value){
						?>
			<tr class="gray">
				<td><img class='table-pics' src='<?=$value["pic_desc"]?>' alt='golden gate bridge'/></td>
				<td><?=$value['id']?></td>
				<td><?=$value['name']?></td>
				<td><?=$value['inventory_count']?></td>
				<td><?=$value['quantity_sold']?></td>
				<td>
					<!--EDIT MODAL-->
					<a href="#" data-toggle="modal" data-target="#myModal" data-whatever="edit">edit</a>
					<!-- button activated modal-->
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <h1 class="modal-title" id="myModalLabel">Edit Product</h1>
					      </div>
					      <div class="modal-body">
					        <div id='main'>
							<form action='/Admins/edit_product/<?=$value['id']?>' method='post'>
							<label>Name: <input class='field' type='text' name='product_name' placeholder='Name of product...'></label>
							<label>Description: <textarea class='field' name='product_description' placeholder='Description of product...'></textarea></label>
							<label>Categories: <select class='field' name='product_category' placeholder='Pick a category'>
								<option value='bridge'>Bridge</option>
								<option value='monument'>Monument</option>
								<option value='statue'>Statue</option>
							</select></label>
							<label>or add a new category: <input class='field' type='text' name='new_category'></label>
							<!-- <label>Images: <input class='field' type='file' name='image' accept='image/*'></label> -->
							<label>Add Image URL here: <input type='text' name='img_src' placeholder='Image URL here'></label>
							<!-- needs jquery draggable content -->
							<!-- image upload in beta testing <ul>
								<li><div class='image'><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
									<img src=''>img.png <input type='radio' name='main' value='main'>Main
								</div>
								</li>
								<li><div class='image'><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
									<img src=''>img.png <input type='radio' name='main' value='main'>Main
								</div>
								</li>
								<li><div class='image'><span class="glyphicon glyphicon-align-justify" aria-hidden="true"></span>
									<img src=''>img.png <input type='radio' name='main' value='main'>Main
								</div>
								</li>
							</ul> -->
						</div>
					      </div>
					      <div class="modal-footer">
					      	<div id='buttons'>
					      		<input class='cancel' type='submit' name='cancel' value='Cancel'>
					      		<input class='preview' type='submit' name='preview' value='Preview'>
					      		<input class='update' type='submit' name='update' value='Update'>
					      	</form>
							</div>
					      </div>
					    </div>
					  </div>
					</div>
					<!-- end of edit module -->
					<a class="delete" href="/Admins/product_delete/<?= $value['id']?>">delete</a>
				</td>
				<?php
			}?>
			</tr>
<!-- 			<tr>
				<td><a href="#"><img class='table-pics' src='http://i.imgur.com/UDhus28.jpg' alt='golden gate bridge'/></a></td>
				<td>2</td>
				<td>T-shirt</td>
				<td>23</td>
				<td>3</td>
				<td>
					<a href="#">edit</a>
					<a class="delete" href="#">delete</a>
				</td>
			</tr>
			<tr class="gray">
				<td><a href="#"><img class='table-pics' src='http://i.imgur.com/UDhus28.jpg' alt='golden gate bridge'/></a></td>
				<td>3</td>
				<td>T-shirt</td>
				<td>1</td>
				<td>2342</td>
				<td>
					<a href="#">edit</a>
					<a class="delete" href="#">delete</a>
				</td>
			</tr>
			<tr>
				<td><a href="#"><img class='table-pics' src='http://i.imgur.com/UDhus28.jpg' alt='golden gate bridge'/></a></td>
				<td>4</td>
				<td>T-shirt</td>
				<td>13</td>
				<td>234</td>
				<td>
					<a href="#">edit</a>
					<a class="delete" href="#">delete</a>
				</td>
			</tr>
			<tr class="gray">
				<td>...</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<a href="#">edit</a>
					<a class="delete" href="#">delete</a>
				</td>
			</tr>
			<tr>
				<td><a href="#"><img class='table-pics' src='http://i.imgur.com/UDhus28.jpg' alt='golden gate bridge'/></a></td>
				<td>50</td>
				<td>T-shirt</td>
				<td>12</td>
				<td>3</td>
				<td>
					<a href="#">edit</a>
					<a class="delete" href="#">delete</a>
				</td>
			</tr> -->
	</table>

	<div class="numbers">
		<ul>
			<li><a href="/Welcome/product_inventory">1</a></li>
			<li><a href="/Welcome/product_inventory">2</a></li>
			<li><a href="/Welcome/product_inventory">3</a></li>
			<li><a href="/Welcome/product_inventory">4</a></li>
			<li><a href="/Welcome/product_inventory">5</a></li>
			<li><a href="/Welcome/product_inventory">6</a></li>
			<li><a href="/Welcome/product_inventory">7</a></li>
			<li><a href="/Welcome/product_inventory">8</a></li>
			<li><a href="/Welcome/product_inventory">9</a></li>
			<li><a href="/Welcome/product_inventory">10</a></li>
			<li><a href="/Welcome/product_inventory"> -> </a></li>	
		</ul>
	</div>
</div>
</body>
</html>
	