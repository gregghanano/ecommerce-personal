<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Login Page</title>
	<style>
		body{
			width: 970px;
		}
		.blue{
			color: white;
			background-color: blue;
			margin-left: 150px;
			box-shadow: 5px 5px 5px black;
			border: solid 1px black;
		}
	
	</style>

</head>

<body>
	<div id="main">
		<div id='errors'>
			<?php
				if($this->session->flashdata('errors'))
				{
					foreach($this->session->flashdata('errors') as $value)
					{ ?>
						<p><?= $value ?></p>
				<?php	}
				}
			?>
		</div>
		<h1>Admin Login Page</h1>
		<form action="/admins/login_user" method="post">
			<p>Email: <input type="text" name="email" /></p>
			<p>Password: <input type="password" name="password" /></p>
			<input class="blue" type="submit" value="Login" />
		</form>
	</div>
</body>
</html>