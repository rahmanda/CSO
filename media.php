<?php
include 'config/koneksi.php';
session_start();
function countmessage() {
	$query = pg_query("SELECT * FROM perpesanan WHERE penerima='$_SESSION[id]' and dibaca='N'");
	$count = pg_num_rows($query);
	echo $count;
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/stylezheet.css" media="(max-width:1304px)"/>
	<link rel="stylesheet" href="lib/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" href="lib/uniform/themes/default/css/uniform.default.css" />
	<style type="text/css" title="currentStyle">
		@import "media/css/demo_table_jui.css";
		@import "media/themes/smoothness/jquery-ui-1.8.4.custom.css";
	</style>
	<script src="js/jquery-1.8.2.js" type="text/javascript"></script>
	<script src="lib/uniform/jquery.uniform.js"></script>
	<!-- jQuery -->
	<script>
	$(document).ready(function(){
	$("#accordian h3").click(function(){
		//slide up all the link lists
		$("#accordian ul ul").slideUp();
		//slide down the link list below the h3 clicked - only if its closed
		if(!$(this).next().is(":visible"))
		{
			$(this).next().slideDown();
		}
	})
	$(".block-header span").click(function() {
		if($(".block-content").is(":visible"))
		{
			$(".block-content").slideUp();
			$(this).removeClass("icon-collapse-alt").addClass("icon-expand-alt");
		} else {
			$(".block-content").slideToggle();
			$(this).addClass("icon-collapse-alt")
		}
	})
	})
	</script>
	<script type="text/javascript" charset="utf-8" src="media/js/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function(){
            $('#datatables').dataTable({
					     "oLanguage": {
						      "sLengthMenu": "Tampilkan _MENU_ data per halaman",
						      "sSearch": "Pencarian: ", 
						      "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
						      "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
						      "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
						      "sInfoFiltered": "(di filter dari _MAX_ total data)",
						      "oPaginate": {
						          "sFirst": "first",
						          "sLast": "last", 
						          "sPrevious": "previous", 
						          "sNext": "next"
					       }
				      },
              "sPaginationType":"full_numbers",
              "bJQueryUI":true
            });
          })
	</script>
	<script src="lib/tinymce/tinymce.min.js"></script>
	<script>
	tinymce.init({
    selector: "textarea",
    theme: "modern",
    height: 150,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
	],
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons", 
	style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
	}); 
	</script>
	<script>
		$(function () {
				$("input, textarea, select").not(".button").uniform();
		});
	</script>
</head>
<body>
<header>
	<img src="img/header-banner.png" />
	<ul class="button red">
		<li><i class="icon-signout"></i><a href="signout.php">Signout</a></li>
	</ul>
</header>
<aside>
<section id="user-profile">
	<div class="user-img">
	<img src="img/foto_user/<?php echo "small_".$_SESSION['username'].".jpg";?>" class="user-img" />
	</div>
	<div class="greeting">
		<p>
		<script type="text/javascript">
			var d = new Date();
			var h = d.getHours();
			if (h < 10) { document.write('Selamat pagi,'); }
			else if (h < 15) { document.write('Selamat siang,'); }
			else if (h < 19) { document.write('Selamat sore,'); }
			else if (h <= 23) { document.write('Selamat malam,'); }
		</script>
		</p>
		<h3><?php echo $_SESSION['username'];?></h3>
		<p id="message-info"><span class="icon-envelope-alt"></span><a href="?module=pesan">&nbsp;&nbsp;<a style="color:orange;font-weight:bold"><?php countmessage();?></a> belum dibaca</a></p>
	</div>
</section>
<nav id="accordian">
	<ul>
		<li>
			<h3><span class="icon-user"></span>Profil</h3>
			<ul>
				<li><a href="?module=profil">Pribadi</a></li>
				<li><a href="?module=profil&act=tanggungan">Tanggungan</a></li>
			</ul>
		</li>
		<!-- open by default -->
		<?php if($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { ?> 
		<li>
			<a href="?module=pegawai"><h3><span class="icon-list-alt"></span>Pegawai</h3></a>
		</li>
		<?php } ?>
		<li>
			<h3><span class="icon-th-large"></span>Proyek</h3>
			<ul><?php if($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { ?>
				<li><a href="?module=proyek&iddept=1">HRD</a></li>
				<?php } ?>
				<?php if($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { ?>
				<li><a href="?module=proyek&iddept=2">Humas</a></li>
				<?php } ?>
				<?php if($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { ?>
				<li><a href="?module=proyek&iddept=3">Finansial</a></li>
				<?php } ?>
				<?php if($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { ?>
				<li><a href="?module=proyek&iddept=4">Produksi</a></li>
				<?php } ?>
			</ul>
		</li>
		<li>
			<h3><span class="icon-money"></span>Gaji</h3>
			<ul>
				<li><a href="?module=gaji&id=<?php echo $_SESSION['id'];?>">Pribadi</a></li>
				<?php if($_SESSION['leveluser']=="admin" || $_SESSION['leveluser']=="manager") { ?>
				<li><a href="?module=gaji&act=tabel">Daftar Gaji Pegawai</a></li>
				<?php } ?>
			</ul>
		</li>
		<li>
			<h3><span class="icon-briefcase"></span>Cuti</h3>
			<ul>
				<li><a href="?module=cuti">Daftar Cuti Pegawai</a></li>
				<li><a href="?module=cuti&act=ajukan&id=<?php echo $_SESSION['id']; ?>">Pengajuan Cuti</a></li>
			</ul>
		</li>
		<?php if($_SESSION['leveluser']=="admin") { ?>
		<li>
			<a href="?module=shift"><h3><span class="icon-time"></span>Shift</h3></a>
		</li>
		<?php } ?>
	</ul>
</nav>
</aside>
<div class="main">
	<div class="breadcrumb">
		<ul>
			<li><a href="?module=home"><span class="icon-home"></span></a></li>
			<li>Selamat Datang di Sistem Informasi Kepegawaian</li>
		</ul>
	</div>
	<?php include "content.php" ?>
</div>
</body>
</html>