<?php
include "/config/koneksi.php";

$user = $_POST['username'];
$pass = $_POST['password'];

$query = pg_query("SELECT * FROM pegawai where namadep='$user' and idpeg='$pass'");
$found = pg_num_rows($query);
$data = pg_fetch_array($query);
$manager = pg_query("SELECT * FROM departemen where idmgr='$data[idpeg]'");
$count = pg_num_rows($manager);

if($found > 0) {
	session_start();
	
	$_SESSION['username'] = $data['namadep'];
	$_SESSION['password'] = $data['idpeg'];
	$_SESSION['dept'] = $data['iddept'];
	$_SESSION['id'] = $data['idpeg'];
	
	if($pass == 'P001' && $user == 'Bambang') {
		$_SESSION['leveluser'] = "admin";
	} else if($count > 0) {
		$_SESSION['leveluser'] = "manager";
	} else 
		$_SESSION['leveluser'] = "pegawai";
	
	header('location:../media.php?module=home');
} else {
	echo '
	<link rel="stylesheet" href="css/stylesheet.css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans" type="text/css" />
	<script src="js/libs/modernizr-2.0.6.min.js"></script>';

	echo "
	</head>
	<body class='page-login'>
	<div id='container'>
		<section id='error-number'>
		<img src='img/lock.png'>
		<h1>LOGIN GAGAL</h1>
		<p><span class style=\"font-size:14px; color:#ccc;\">Username atau Password anda tidak sesuai.<br>
		Atau akun anda sedang diblokir.</p></span><br/>
		</section>
		
		<section id='error-text'>
		<p><a class='button' href='index.php'>&nbsp;&nbsp; <b>ULANGI LAGI</b> &nbsp;&nbsp;</a></p>
		</section>
	</div>";
}
?>
	