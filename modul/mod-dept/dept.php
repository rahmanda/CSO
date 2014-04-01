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
$direct = "modul/mod-pegawai/act-pegawai.php";
if(empty($_GET['act'])) {
	$iddept = $_GET['iddept'];
	$query = pg_query("SELECT idpeg, namadep||' '||namabel as nama, tgllahir, alamat, JK, notlp, status, idshift from pegawai WHERE iddept='$iddept'");
	echo '
	<div class="info-content">
		<ul class="button add"><li><a href="?module=pegawai&act=tambah">Tambahkan Pegawai</a></li></ul>
	</div>
	<section id="box-border">
		<div class="block-header">
			<h1>TABEL PEGAWAI</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<table id="datatables" class="display">
				<thead>
					<tr>
					<th>idPeg</th>
					<th>Nama</th>
					<th>Tanggal Lahir</th>
					<th>Alamat</th>
					<th>JK</th>
					<th>Telepon</th>
					<th>Status</th>
					<th>Shift</th>
					<th>Aksi</th>
					</tr>
				</thead>
				<tbody>';
				while ($r = pg_fetch_array($query)) {
					echo "<tr>
						<td width=40>$r[idpeg]</td>
						<td>$r[nama]</td>
						<td>$r[tgllahir]</td>
						<td>$r[alamat]</td>
						<td>$r[jk]</td>
						<td>$r[notlp]</td>
						<td>$r[status]</td>
						<td>$r[idshift]</td>
						<td><a href=\"?module=pegawai&act=edit&idpeg=$r[idpeg]\"><img src=\"edit.png\" class=\"edit\" alt=\"edit\"></a>
						&nbsp;&nbsp;<a href='$direct?module=pegawai&act=hapus&id=$r[idpeg]'><img src=\"hapus.png\" alt=\"hapus\"></a></td>
						</tr>";
				}                    
				echo '
				</tbody>
			</table>
			</div>
	</section> ';	
} else if ($_GET['act']=="tambah") {
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>TAMBAH PEGAWAI</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="pegawai form" method="post" action="modul/mod-pegawai/act-pegawai.php?module=pegawai&act=tambah" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="namadep">Nama Depan</label>
				<input type="text" name="namadep" class="text" size="60"/>
				</div>
				<div class="inline-small-label">
				<label for="namabel">Nama Belakang</label>
				<input type="text" name="namabel" class="text" size="60"/>
				</div>
				<div class="inline-small-label">
				<label for="jk">Jenis Kelamin</label>
				<div class="jk">
				<input type=radio name="jk" value="M" checked>Laki-Laki  
				<input type=radio name="jk" value="F">Perempuan
				</div>
				</div>
				<div class="inline-small-label">
				<label for="departemen">Departemen</label>
				<div class="departemen">
				<select name="departemen" class="departemen">';
	$query = pg_query("SELECT iddept, namadept FROM departemen");
	while($r = pg_fetch_array($query)){
		echo "<option value=\"$r[iddept]\">$r[namadept]</option>";
	}
		echo	'</select>
				</div>
				</div>
				<div class="inline-small-label">
				<label for="shift">Shift</label>
				<div class="shift">
				<select name="shift" class="shift">';
	$query = pg_query("SELECT idshift, periode FROM shift");
	while($r = pg_fetch_array($query)){
		echo "<option value=\"$r[idshift]\">$r[periode]</option>";
	}
		echo	'</select>
				</div>
				</div>
				<div class="inline-small-label">
				<label for="tgllahir">Tanggal Lahir</label>
				<input type="date" name="tgllahir" class="date" />
				</div>
				<div class="inline-small-label">
				<label for="alamat">Alamat</label>
				<input type="text" name="alamat" class="alamat" />
				</div>
				<div class="inline-small-label">
				<label for="notelp">Telepon</label>
				<input type="tel" name="notelp" class="notelp" />
				</div>
				<div class="inline-small-label">
				<label for="status">Status</label>
				<div class="status">
				<input type=radio name="status" value="Aktif" checked>Aktif  
				<input type=radio name="status" value="Cuti">Cuti
				</div>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=pegawai">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="TAMBAH" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
}	else if ($_GET['act']=="edit") {
	$id = $_GET['idpeg'];
	$query = pg_query("SELECT * FROM pegawai WHERE idpeg='$id'");
	$fetch = pg_fetch_array($query);
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>EDIT PEGAWAI</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="pegawai form" method="post" action="modul/mod-pegawai/act-pegawai.php?module=pegawai&act=edit&id='.$id.'" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="namadep">Nama Depan</label>
				<input type="text" name="namadep" class="text" size="60" value="'.$fetch['namadep'].'"/>
				</div>
				<div class="inline-small-label">
				<label for="namabel">Nama Belakang</label>
				<input type="text" name="namabel" class="text" size="60" value="'.$fetch['namabel'].'"/>
				</div>
				<div class="inline-small-label">
				<label for="jk">Jenis Kelamin</label>
				<div class="jk">';
				if($fetch['jk'] == "M") {
				echo '
				<input type=radio name="jk" value="M" checked>Laki-Laki  
				<input type=radio name="jk" value="F">Perempuan';
				} else echo '<input type=radio name="jk" value="M">Laki-Laki  
				<input type=radio name="jk" value="F" checked>Perempuan';
				echo '
				</div>
				</div>
				<div class="inline-small-label">
				<label for="departemen">Departemen</label>
				<div class="departemen">
				<select name="departemen" class="departemen">';
	$query = pg_query("SELECT iddept, namadept FROM departemen");
	while($r = pg_fetch_array($query)){
		echo "<option value=\"$r[iddept]\">$r[namadept]</option>";
	}
		echo	'</select>
				</div>
				</div>
				<div class="inline-small-label">
				<label for="shift">Shift</label>
				<div class="shift">
				<select name="shift" class="shift">';
	$query = pg_query("SELECT idshift, periode FROM shift");
	while($r = pg_fetch_array($query)){
		echo "<option value=\"$r[idshift]\">$r[periode]</option>";
	}
		echo	'</select>
				</div>
				</div>
				<div class="inline-small-label">
				<label for="tgllahir">Tanggal Lahir</label>
				<input type="date" name="tgllahir" class="date" value="'.$fetch['tgllahir'].'"/>
				</div>
				<div class="inline-small-label">
				<label for="alamat">Alamat</label>
				<input type="text" name="alamat" class="alamat" value="'.$fetch['alamat'].'"/>
				</div>
				<div class="inline-small-label">
				<label for="notelp">Telepon</label>
				<input type="tel" name="notelp" class="notelp" value="'.$fetch['notlp'].'"/>
				</div>
				<div class="inline-small-label">
				<label for="status">Status</label>
				<div class="status">';
				if($fetch['status']=="Cuti") {
				echo '
				<input type=radio name="status" value="Aktif">Aktif  
				<input type=radio name="status" value="Cuti" checked>Cuti';}
				else { echo '<input type=radio name="status" value="Aktif" checked>Aktif  
				<input type=radio name="status" value="Cuti">Cuti';}
				echo '
				</div>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=pegawai">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="EDIT" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
} else if($_GET['act']=="mgrhandle") {
	$id = $_GET['idmgr'];
	$query = pg_query("SELECT * FROM departemen WHERE idmgr='$id'");
	$fetch = pg_fetch_array($query);
	echo '
	<div class="info-content">
		<p>Anda akan menghapus manager '.$fetch["idmgr"].', terlebih dahulu anda harus mengisi manager baru departemen '.$fetch["namadept"].'</p>
	</div>
	<section id="box-border">
		<div class="block-header">
			<h1>EDIT MANAGER</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
		<form class="mgrhandle form" method="post" action="'.$direct.'/?module=pegawai&act=mgrhandle&iddept='.$fetch["iddept"].'&target='.$fetch["idmgr"].'" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="idpeg">ID Pegawai</label>
				<select class="idpeg" name="idpeg">';
	$peg = pg_query("SELECT * FROM pegawai WHERE iddept='$fetch[iddept]'");
	while($r = pg_fetch_array($peg)) {
		echo "<option value=\"$r[idpeg]\">$r[idpeg]</option>";
	}	echo ' 	</select>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=pegawai">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="EDIT" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
}