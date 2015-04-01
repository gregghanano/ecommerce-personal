<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>All Products</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function()
		{
			$(document).keypress("#search",function(e) 
			{
    			if(e.which == 13) 
    			{
    			}
    		});
    		
    		$("#sortBy").change(function() 
    		{ 
				$('#formSort').submit();
    		
    		});
		});
	</script>


<style type="text/css">
	
	body {
		width: 970px;
		background-color: #CEE3F6;

	}
	.header {
	 background-color: #81BEF7;
	 border-radius: 20px;
	 height: 60px;
	 color: white;
	}

	#title, #shoppingCart{
	 display: inline-block;
	}

	#title{
	 margin-left: 10px;
	}
	#shoppingCart{
	 margin-left: 500px;
	}

	.shoppingCartColor{
	color: white;
	}

	#shoppingCartColor{
		color: white;
	}

	.products_index{
		border: solid 1px #81BEF7;
		border-radius: 20px;
		width: 200px;
		margin-top: 10px;
		margin-right: 10px;
	}

	.products_view{
		
		border: solid 1px #81BEF7;
		border-radius: 20px;
		width: 750px;
		margin-top: 10px;

	}

	.products_title p{
		display: inline-block;
	}

	.products div{
		margin: 10px;
		display: inline-block;
	}

	.products_index, .products_view {
		display: inline-block;
		vertical-align: top;
	}

	.page_toggle p{
		display: inline-block;
	}

	.category {
/*		font-size: 32px;*/
		margin-right: 300px;
		padding-left: 10px;
	}
	img{
	border-radius: 20px;	
	}
	#page{
		display: inline-block;
		vertical-align: top;
		margin-left: 500px;
		margin-top: -50px;
	}

	#search{
		border-radius: 20px;
		margin-top: 10px;
		margin-left: 10px;
	}

	#sortBy{
		border-radius: 20px;
		margin-left: 10px;
		/*margin-top: -10px;*/
	}

	#formSort{
	margin-top: -10px;	
	}

	.outOfStock{
		color: white;
		font-weight: bold;
		background-color: red;
		border: solid 1px black;
		text-align: center;
		margin-top: 14px;
		}

	.pictures{
		display: inline-block;
	}

</style>
</head>

<body>
 	<div class="header">
 		<h2 id="title">BuyAmericaDotCom</h2>
 		<h2 id="shoppingCart"><a id="shoppingCartColor" href="/Welcome/cart">Shopping Cart (<?= $this->session->userdata('cart')['total_items'] ?>)</a></h2>
 	</div>
	<div class="main_body">

		<div class="products_index">
			<form action="/Welcome/search" method="post">
				<input type='search' id="search" name="productName" placeholder="product search">
			</form>
			<ul>
				<li>Categories</li>
					<ul>
<?php 
			foreach($categories as $key)
			{ ?>
				<li><a href="/Welcome/product_category/<?= $key['category']?>"><?= $key['category']." (".$key['count']?>)</a></li>
<?php		} ?>
					</ul>
				<li><a href="/Welcome/">Show All</a></li>
			</ul>
		</div>
		<div class='products_view'>
			<div class='products_title'>
				<h2 class='category'><?=$category?></h2>
				<div id="page">
					<p><a href="">first</a>| </p>
					<p><a href="">previous</a>| </p>
					<p>2| </p>
					<p><a href="">next</a></p>
				</div>
			</div>
			<div>
				<p class='category'>Sorted by: <?=$this->session->userdata('sortBy')?></p>
				<form class='category' id="formSort" action="/Welcome/sortBy" method="post">
					<select id="sortBy" name="sortBy">
						<option value='blank'>-Sort By-</option>
						<option value='price'>Price (low-high)</option>
						<option value='quantity_sold'>Most Popular</option>
					</select>
				</form>
			</div>
			<div class='products'>
<?php 		foreach($product as $key)
			{ ?>
			<div>	
				
<?php 		if($key['inventory_count']<1) 
			{ ?>				
				<img class="product_photo" src="<?=$key['description']?>" alt="Smiley face" height="200" width="200">
				<p class="outOfStock">"  Out of Stock  "</p>
<?php 		} else 
	 			{ ?>
					<a href="/Welcome/product_desc/<?=$key['id']?>"><img class="product_photo" src="<?=$key['description']?>" alt="Smiley face" height="200" width="200"></a>
					<p>$<?= number_format($key['price'],2)?></p>
<?php			}?>				
				<p><?=$key['name']?></p>
			</div>
<?php		} ?>
			</div>
			<div class='page_toggle'>
				<p><a href="">1</a>|</p>
				<p>2</a>|</p>
				<p><a href="">3</a>|</p>
				<p><a href="">4</a>|</p>
				<p><a href="">5</a>|</p>
				<p><a href="">6</a>|</p>
				<p><a href="">7</a>|</p>
				<p><a href="">8</a>|</p>
				<p><a href="">9</a>|</p>
				<p><a href="">10</a>|</p>
				<p><a href="">-></a></p>
			</div>
		</div>	
	</div>

</body>
</html>