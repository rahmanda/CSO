<script>
function confirmdelete(delUrl) {
   if (confirm("Anda yakin ingin menghapus?")) {
      document.location = delUrl;
   }
}
</script>
<?php
include 'config\koneksi.php';
include 'config\idpro_handle.php';
//Query database
$query = pg_query("SELECT p.idpro, p.namapro, d.namadept FROM proyek p, departemen d WHERE p.iddept=d.iddept");
$aksi="modul/mod-proyek/act-proyek.php";
if(empty($_GET['act'])) {
	$iddept = $_GET['iddept'];
	$query = pg_query("SELECT p.idpro, p.namapro, p.iddept, d.namadept FROM proyek p, departemen d WHERE p.iddept=d.iddept and p.iddept='$iddept'");
	echo '
	<div class="info-content">
		<ul class="button add"><li><a href="?module=proyek&act=tambah&id='.$iddept.'">Tambah Proyek</a></li></ul>
	</div>
	<section id="box-border">
		<div class="block-header">
			<h1>PROYEK</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<table id="datatables" class="display">
				<thead>
					<tr>
					<th>ID</th>
					<th>Nama Proyek</th>
					<th>Departemen</th>
					<th width=70>Aksi</th>
					</tr>
				</thead>
				<tbody>';
				while ($r = pg_fetch_array($query)) {
					echo "<tr>
						<td width=40>$r[idpro]</td>
						<td>$r[namapro]</td>
						<td>$r[namadept]</td>
						<td><a href=\"?module=proyek&act=edit&id=$r[idpro]&iddept=$r[iddept]\"><img src=\"img/edit.png\" class=\"edit\"></a>
						&nbsp;&nbsp;<a href=javascript:confirmdelete('$aksi?module=proyek&act=hapus&id=$r[idpro]&iddept=$iddept')><img src=\"img/hapus.png\"></a></td>
						</tr>";
				}                    
				echo '
				</tbody>
			</table>
			</div>
	</section> ';	
} else if($_GET["act"]=="tambah") {
	$iddept = $_GET['id'];
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>TAMBAH PROYEK</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="proyek form" method="post" action="modul/mod-proyek/act-proyek.php?module=proyek&act=tambah&id='.$data.'&iddept='.$iddept.'" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="namapro">Nama Proyek</label>
				<input type="text" name="namapro" class="text" size="60"/>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=proyek&iddept='.$iddept.'">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="TAMBAH" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
} else if($_GET["act"]=="edit") {
	$query = pg_query("SELECT * FROM proyek WHERE idpro=$_GET[id]");
	$r = pg_fetch_array($query);
	$iddept = $_GET['iddept'];
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>EDIT PROYEK</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="proyek form" method="post" action="modul/mod-proyek/act-proyek.php?module=proyek&act=edit&id='.$_GET['id'].'&iddept='.$iddept.'" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="namapro">Nama Proyek</label>
				<input type="text" name="namapro" class="text" value="'.$r['namapro'].'" size="60"/>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=proyek&iddept='.$iddept.'">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="EDIT" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
}