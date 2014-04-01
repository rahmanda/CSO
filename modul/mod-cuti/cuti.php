<?php 
include 'config/koneksi.php';
//Query database
$query = pg_query("SELECT p.idpeg, p.namadep||' '||p.namabel as nama, c.mulaicuti, c.akhircuti, c.keterangan, c.status from pegawai p, cuti c where c.idpeg=p.idpeg");
if (empty($_GET['act'])) {
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>DAFTAR CUTI PEGAWAI</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
	<table id="datatables" class="display">
                <thead>
                    <tr>
                        <th>idPeg</th>
                        <th>Nama</th>
						<th>Mulai Cuti</th>
						<th>Akhir Cuti</th>
						<th>Keterangan</th>
						<th>Status</th>
						<th>Aksi</th>
                    </tr>
                </thead>
                <tbody>';
                    while ($r = pg_fetch_array($query)) {
                      echo "<tr>
                            <td width=40>$r[idpeg]</td>
                            <td>$r[nama]</td>
							<td>$r[mulaicuti]</td>
							<td>$r[akhircuti]</td>
							<td>$r[keterangan]</td>
							<td>$r[status]</td>
							<td><a href=\"?module=cuti&act=edit&id=$r[idpeg]\"><img src=\"img/edit.png\" class=\"edit\" alt=\"edit\"></a></td>
                            </tr>";
                    }                    
				echo '
                </tbody>
            </table>
		</div>
	</section>
	';
} else if($_GET['act'] == "ajukan") {
	$id = $_GET['id'];
	echo '
	<div class="info-content">
		<p>Form cuti ini akan otomatis mengirim laporan pengajuan cuti kepada manager Anda.<br />Pengajuan cuti Anda telah disetujui setelah Anda mendapatkan pesan konfirmasi.</p>
	</div>
	<section id="box-border">
		<div class="block-header">
			<h1>PENGAJUAN CUTI</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="cuti form" method="post" action="modul/mod-cuti/act-cuti.php?module=cuti&act=ajukan&id='.$id.'" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="mulaicuti">Mulai Cuti</label>
				<input type="date" name="mulaicuti" class="date" />
				</div>
				<div class="inline-small-label">
				<label for="akhircuti">Akhir Cuti</label>
				<input type="date" name="akhircuti" class="date" />
				</div>
				<div class="inline-small-label">
				<label for="ket">Keterangan</label>
				<input type="text" name="ket" class="text" />
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module='; if($_SESSION['leveluser'] == "admin" || $_SESSION['leveluser'] == "manager") echo "cuti"; else echo "home"; echo '">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="AJUKAN" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
} else if($_GET['act'] == "edit") {
	$id = $_GET['id'];
	$fetch = pg_fetch_array(pg_query("SELECT * FROM cuti WHERE idpeg='$id'"));
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>EDIT CUTI</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="cuti form" method="post" action="modul/mod-cuti/act-cuti.php?module=cuti&act=edit&id='.$id.'" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="mulaicuti">Mulai Cuti</label>
				<input type="date" name="mulaicuti" class="date" value="'.$fetch["mulaicuti"].'"/>
				</div>
				<div class="inline-small-label">
				<label for="akhircuti">Akhir Cuti</label>
				<input type="date" name="akhircuti" class="date" value="'.$fetch["akhircuti"].'"/>
				</div>
				<div class="inline-small-label">
				<label for="ket">Keterangan</label>
				<input type="text" name="ket" class="text" width=60 value="'.$fetch["keterangan"].'"/>
				</div>
				<div class="inline-small-label">
				<label for="Status">Status</label>
				<div class="status">
				'; 
				if($fetch["status"]=="A")
				{ echo '<input type=radio name="status" value="A" checked>Disetujui  
				<input type=radio name="status" value="P">Pending';
				} else if($fetch["status"]=="P")
				{ echo '<input type=radio name="status" value="A">Disetujui  
				<input type=radio name="status" value="P" checked>Pending';
				} else echo '<input type=radio name="status" value="A">Disetujui  
				<input type=radio name="status" value="P">Pending';
				echo '
				</div>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module='; if($_SESSION['leveluser'] == "admin" || $_SESSION['leveluser'] == "manager") echo "cuti"; else echo "home"; echo '">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="EDIT" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
}