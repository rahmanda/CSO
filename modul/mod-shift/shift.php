<script>
function confirmdelete(delUrl) {
   if (confirm("Anda yakin ingin menghapus?")) {
      document.location = delUrl;
   }
}
</script>
<?php
include 'config/koneksi.php';
//Query database
$query = pg_query("SELECT * FROM shift");
$aksi="modul/mod-shift/act-shift.php";
if(empty($_GET['act'])) {
	echo '
	<div class="info-content">
		<ul class="button add"><li><a href="?module=shift&act=tambah">Tambah shift</a></li></ul>
	</div>
	<section id="box-border">
		<div class="block-header">
			<h1>SHIFT</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<table id="datatables" class="display">
				<thead>
					<tr>
					<th>ID shift</th>
					<th>Periode</th>
					<th>Aksi</th>
					</tr>
				</thead>
				<tbody>';
				while ($r = pg_fetch_array($query)) {
					echo "<tr>
						<td width=40>$r[idshift]</td>
						<td>$r[periode]</td>
						<td width=60><a href=\"?module=shift&act=edit&id=$r[idshift]\"><img src=\"img/edit.png\" class=\"edit\"></a>
						&nbsp;&nbsp;<a href='$aksi?module=shift&act=hapus&id=$r[idshift]'><img src=\"img/hapus.png\"></a></td>
						</tr>";
				}                    
				echo '
				</tbody>
			</table>
			</div>
	</section> ';	
} else if($_GET["act"]=="tambah") {
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>TAMBAH SHIFT</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="shift form" method="post" action="modul/mod-shift/act-shift.php?module=shift&act=tambah" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="periode">Periode</label>
				<input type="text" name="periode" class="text" size="60"/>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=shift">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="TAMBAH" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
} else if($_GET["act"]=="edit") {
	$query = pg_query("SELECT * FROM shift WHERE idshift='$_GET[id]'");
	$r = pg_fetch_array($query);
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>EDIT SHIFT '.$r['idshift'].'</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="shift form" method="post" action="modul/mod-shift/act-shift.php?module=shift&act=edit&id='.$_GET['id'].'" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="periode">Periode</label>
				<input type="text" name="periode" class="text" value="'.$r['periode'].'" size="60"/>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=shift">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="EDIT" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
}  else if($_GET['act']=="shifthandle") {
	$id = $_GET['id'];
	echo '
	<div class="info-content">
		<p>Anda akan menghapus shift '.$id.', terlebih dahulu anda harus mengganti shift pegawai.</p>
	</div>
	<section id="box-border">
		<div class="block-header">
			<h1>GANTI SHIFT</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
		<form class="shifthandle form" method="post" action="'.$aksi.'/?module=shift&act=shifthandle&id='.$id.'" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="shift">Shift</label>
				<select class="shift" name="shift">';
	$query = pg_query("SELECT * FROM shift");
	while($r = pg_fetch_array($query)) {
		echo "<option value=\"$r[idshift]\">$r[periode]</option>";
	}	echo ' 	</select>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=shift">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="EDIT" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
}