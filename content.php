<?php
	$module = $_GET['module'];
	if($module == "home") {
		echo "
		<div class='info-content'>
		<p>Silakan klik menu pilihan yang ada disebelah kiri untuk mengelola akun anda<br/>atau pilih ikon-ikon pada Control Panel dibawah ini:<p>
		</div>
		<section id='box-border'>
		<div class='block-header'>
			<h1>CONTROL PANEL</h1>
		<span class='icon-collapse-alt'></span>
		</div>
		<div class='block-content'>
			<ul class='shortcut-list'>
				<li class='shortcut'><a href='media.php?module=profil'><img src='img/icon/user.png'>Profil</a></li>
				<li class='shortcut'><a href='media.php?module=profil&act=tanggungan'><img src='img/icon/userinfo.png'>Tanggungan</a></li>";
				if ($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { echo "
				<li class='shortcut'><a href='media.php?module=pegawai'><img src='img/icon/businessman.png'>Pegawai</a></li>"; }
				if ($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { echo "
				<li class='shortcut'><a href='media.php?module=proyek&iddept=1'><img src='img/icon/diagram.png'>HRD</a></li>"; }
				if ($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { echo "
				<li class='shortcut'><a href='media.php?module=proyek&iddept=3'><img src='img/icon/dollars.png'>Finansial</a></li>"; }
				if ($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { echo "
				<li class='shortcut'><a href='media.php?module=proyek&iddept=2'><img src='img/icon/globe.png'>Humas</a></li>"; }
				if ($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { echo "
				<li class='shortcut'><a href='media.php?module=proyek&iddept=4'><img src='img/icon/industry.png'>Produksi</a></li>"; }
				echo "
				<li class='shortcut'><a href='media.php?module=gaji&id=".$_SESSION['id']."'><img src='img/icon/wallet.png'>Gaji</a></li>
				<li class='shortcut'><a href='media.php?module=cuti&act=ajukan&id=".$_SESSION['id']."'><img src='img/icon/chair.png'>Ajukan Cuti</a></li>
				<li class='shortcut'><a href='media.php?module=cuti'><img src='img/icon/table.png'>List Cuti</a></li>";
				if ($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { echo "
				<li class='shortcut'><a href='media.php?module=shift'><img src='img/icon/clock.png'>Shift</a></li>"; }
				echo "
				<li class='shortcut'><a href='media.php?module=pesan'><img src='img/icon/letter.png'>Pesan Masuk</a></li>
			</ul>
		</div>
		</section>";
	} else if($module == "pegawai") {
		include "modul/mod-pegawai/pegawai.php";
	} else if($module == "cuti") {
		include "modul/mod-cuti/cuti.php";
	} else if($module == "pesan") {
		include "modul/mod-pesan/pesan.php";
	} else if($module == "proyek") {
		include "modul/mod-proyek/proyek.php";
	} else if($module == "shift") {
		include "modul/mod-shift/shift.php";
	} else if($module == "gaji") {
		include "modul/mod-gaji/gaji.php";
	} else if($module == "profil") {
		include "modul/mod-profil/profil.php";
	} else if($module == "dept") {
		include "modul/mod-dept/dept.php";
	}