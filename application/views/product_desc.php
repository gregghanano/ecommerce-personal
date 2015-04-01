<html>
<head>
	<title>Product Description</title>	

<style type="text/css">
	
	body {
		width: 970px;
		background-color: #CEE3F6;
	}
	.header {
	background-color: #81BEF7;
	 border-radius: 20px;
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

	.products {
		margin: 10px;
		display: inline-block;

	}

	.images {
		width: 350px;
		height: 360px;
		margin-top: 10px;
		margin-right: 10px;
	}
	
	img{
		margin-top: 10px;
		margin-right: 5px;
		border-radius: 20px;
	}
	.description {
		width: 500px;
		height: 350px;
		margin: 10px;
	}

	.images, .description {
		display: inline-block;
		vertical-align: top;
	}
	#similar{
		margin-bottom: -15px;
		margin-top: 20px;
		margin-left: 400px;
	}

	#photoCredit{
		margin-left: 650px;
		font-size: 12px;
	}
	.selectOption{
		border-radius: 20px;
	}

</style>
</head>

<body>
 	<div class="header">
 		<h2 id="title">BuyAmericaDotCom</h2>
 		<h2 id="shoppingCart"><a id="shoppingCartColor" href="/Welcome/cart">Shopping Cart (<?= $this->session->userdata('cart')['total_items'] ?>)</a></h2>
 	</div>
	<div class="main_body">
		<p><a href='/Welcome'>Go Back<a></p>
		<h2><?=$product['name']?></h2>
		<div class='images'>
	<?php 	for($i=0;$i<count($prod_pictures);$i++)
			{
				if($prod_pictures[$i]['main']==1)
				{ ?>
				<img src="<?=$prod_pictures[$i]['description']?>" alt="Smiley face" height="300" width="300">
	<?php 		} 
			} ?>	
	<?php 	for($i=0;$i<count($prod_pictures);$i++)
			{
				if($prod_pictures[$i]['main']!=1)
				{ ?>
				<img src="<?=$prod_pictures[$i]['description']?>" alt="Smiley face" height="75" width="75">
<?php 		} 
			} ?>
		</div>
		<div class='description'>
			<p><?=$product['description']?></p>
			<form action="/Welcome/add_item_to_cart" method="post">
<?php 		if($product['inventory_count']>=3)
				{ ?>
				<select class="selectOption" name="quantity">
					<option  value='1'>1 ($<?= number_format($product['price']*1,2)?>)</option>
					<option  value='2'>2 ($<?= number_format($product['price']*2,2)?>)</option>
					<option  value='3'>3 ($<?= number_format($product['price']*3,2)?>)</option>
				</select>
<?php 			} 
					elseif ($product['inventory_count']=2) 
					{ ?>
				<select class="selectOption" name="quantity">
					<option  value='1'>1 ($<?= number_format($product['price']*1,2)?>)</option>
					<option  value='2'>2 ($<?= number_format($product['price']*2,2)?>)</option>
				</select>
<?php               }  
					elseif ($product['inventory_count']=1)
					{ ?>
				<select class="selectOption" name="quantity">
					<option  value='1'>1 ($<?= number_format($product['price']*1,2)?>)</option>					
				</select>
<?php				} ?>
				<input type='hidden' name='product_id' value='<?=$product['id']?>' />
				<input class="selectOption" type='submit' name='buy' value='Buy'>
			</form>
		</div>
	</div>
	<div id="similar">
		<h2 >Similar Items</h2>
<?php 	for($i=0;$i<count($categories);$i++)
		{
			if($categories[$i]['id'] != $product['id'])
			{	
				$products_id=$categories[$i]['id'];

					for($j=0;$j<count($all_pictures);$j++)
					if(((($all_pictures[$j]['products_id'])==$products_id))&($all_pictures[$j]['main'])==1)
						{ ?>
							<div class='products'>
								<div>
									<a href="/Welcome/product_desc/<?=$categories[$i]['id']?>"><img src="<?=$all_pictures[$j]['description']?>" alt="Smiley face" height="90" width="90"></a>
									<p>$<?= number_format($categories[$i]['price'],2)?></p>
									<p><?=$categories[$i]['name']?></p>
								</div>			
							</div>
<?php 					}				
			}				
		} ?>				 		
	</div>
	<div id="photoCredit">
		<p>Photo credit: http://www.pachd.com/index.html</p>
	</div>
</body>
</html>