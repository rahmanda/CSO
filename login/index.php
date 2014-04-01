<!DOCTYPE html>
<html>
<head>
	<title>.:: SISTEM INFORMASI KEPEGAWAIAN ::.</title>
	<meta content="author" name="Rahmanda_Wibowo" />
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/stylesheet.css" />
	<link rel="stylesheet" href="uniform/themes/default/css/uniform.default.css" />
	<script src="jquery-1.8.2.js" type="text/javascript"></script>
	<script src="uniform/jquery.uniform.js"></script>
	<script>
		$(document).ready(function(){
			$("#submit").click(function(){
				$("#box-login").fadeOut();
			});
		})
	</script>
	<script>
		$(function () {
				$("input").not(".button").uniform();
		});
	</script>
</head>
<body class="page-login">
	<div id="box-login">
	<div id="box-border">
		<div class="block-header"><h1>SISTEM INFORMASI KEPEGAWAIAN</h1></div>
		<form class="form-login form" action="cek_login.php" method="post">
			<div class="input username">
				<input type="text" name="username" />
				<label for="username" class="label">Username</label>
			</div>
			<div class="input password">
				<input type="password" name="password" />
				<label for="password" class="label">Password</label>
			</div>
			<div class="actions">
				<ul class="action-left">
					<li><a class="button reset" href="javascript:void(0);" >BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input id="submit" type="submit" class="button" value="LOGIN" /></li>
				</ul>
			</div>
		</form>
	</div>
	</div>
</body>
</html>