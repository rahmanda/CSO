<script type="text/javascript">
tinymce.init({
    selector: "td.editable",
    inline: true,
    toolbar: "undo redo",
    menubar: false
});
</script>
<?php 
include 'config/koneksi.php';
$query = pg_query("SELECT idpeg, namadep, namabel, tgllahir, alamat, JK, notlp, status, idshift, iddept from pegawai WHERE idpeg='".$_SESSION['id']."'");
$fetch = pg_fetch_array($query);
$mgr = pg_fetch_array(pg_query("SELECT * FROM departemen WHERE iddept='$fetch[iddept]'"));
$shift = pg_fetch_array(pg_query("SELECT * FROM shift WHERE idshift='$fetch[idshift]'"));
$namemgr = pg_fetch_array(pg_query("SELECT namadep||' '||namabel as nama FROM pegawai WHERE idpeg='$mgr[idmgr]'"));
if(empty($_GET['act'])) {
	echo '
	<div class="info-content">
		<ul class="button add"><li><a href="?module=profil&act=edit&id='.$fetch['idpeg'].'">Edit Profil</a></li></ul>
	</div>
	<section id="box-border">
		<div class="block-header">
			<h1>PROFIL</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
	<table class="profile">
		<tbody>
			<tr>
				<td>ID Pegawai<td>
				<td>'.$fetch['idpeg'].'
			</tr>
			<tr>
				<td>Departemen<td>
				<td>'.$mgr['namadept'].'
			</tr>
			<tr>
				<td>Shift<td>
				<td>'.$shift['periode'].'
			</tr>
			<tr>
				<td>Nama Depan<td>
				<td class="editable">'.$fetch['namadep'].'
			</tr>
			<tr>
				<td>Nama Belakang<td>
				<td class="editable">'.$fetch['namabel'].'
			</tr>
			<tr>
				<td>Tanggal Lahir<td>
				<td class="editable">'.$fetch['tgllahir'].'
			</tr>
			<tr>
				<td>Alamat<td>
				<td class="editable">'.$fetch['alamat'].'
			</tr>
			<tr>
				<td>Telepon<td>
				<td class="editable">'.$fetch['notlp'].'
			</tr>
			<tr>
				<td>Manager<td>
				<td>'.$namemgr['nama'].'
			</tr>
		</tbody>
	</table>
	</div>
	</section>
	';
} else if($_GET['act'] == "edit") {
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>EDIT PROFIL</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="profil form" method="post" action="modul/mod-profil/act-profil.php?module=profil&act=edit&id='.$fetch['idpeg'].'" enctype="multipart/form-data">
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
				<label for="fupload" class="upload">Profil</label>
				<input type=file name="fupload" size=40 class="upload">
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=profil">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="EDIT" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
} else if($_GET['act'] == "tanggungan") {
	$query = pg_query("SELECT * FROM tanggungan WHERE idpeg='".$_SESSION['id']."'");
	echo '
	<div class="info-content">
	</div>
	<section id="box-border">
		<div class="block-header">
			<h1>PROFIL TANGGUNGAN</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
		<table id="datatables" class="display">
			<thead>
					<tr>
					<th width=20>No</th>
					<th>Nama Tanggungan</th>
					<th>Tanggal Lahir</th>
					<th>JK</th>
					<th>Hubungan</th>
					</tr>
				</thead>
			<tbody>';
			$no = 1;
			while($r = pg_fetch_array($query)) {
			echo "
				<tr>
				<td>"; if($no < 10) echo "0".$no; else echo $no; echo"</td>
				<td>$r[namatgn]</td>
				<td>$r[tgllahir]</td>
				<td>"; if($r['jk'] == 'M') echo "Laki-Laki"; else echo "Perempuan"; echo "</td>
				<td>$r[hubungan]</td>
				</tr> ";
				$no++;
			}
		echo '
			</tbody>
		</table>
		</div>
		</section>
	';
}