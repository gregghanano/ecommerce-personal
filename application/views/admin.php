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
		<h1>Admin Login Page</h1>
		<form action="/Welcome/search" method="post">
			<p>Email: <input type="text" name="email" /></p>
			<p>Password: <input type="password" name="password" /></p>
			<input class="blue" type="submit" value="Login" />
		</form>
	</div>
</body>
</html>