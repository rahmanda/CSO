<script>
function confirmdelete(delUrl) {
   if (confirm("Anda yakin ingin menghapus?")) {
      document.location = delUrl;
   }
}
</script>
<?php
include 'config\koneksi.php';
//Query database
$query = pg_query("SELECT * FROM gaji");
$aksi="modul/mod-gaji/gaji.php";
if (empty($_GET['act'])) {
	$gaji = pg_query("SELECT * FROM gaji WHERE idpeg='$_GET[id]'");
	$fetch = pg_fetch_array($gaji);
	$total = $fetch['gajipokok']+$fetch['makan']+$fetch['tanggungan'];
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>GAJI</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
	<table class="gaji">
		<tbody>
			<tr>
				<td>Gaji Pokok<td>
				<td>:&nbsp;&nbsp;&nbsp;Rp'.$fetch['gajipokok'].',-
			</tr>
			<tr>
				<td>Uang Makan<td>
				<td>:&nbsp;&nbsp;&nbsp;Rp'.$fetch['makan'].',-
			</tr>
			<tr>
				<td>Tanggungan<td>
				<td>:&nbsp;&nbsp;&nbsp;Rp'.$fetch['tanggungan'].',-
			</tr>
			<tr>
				<td>Total Gaji<td>
				<td>:&nbsp;&nbsp;&nbsp;Rp'.$total.',-
			</tr>
		</tbody>
	</table>
	</div>
	</section>
	';
}
else if($_GET['act']=="tabel") {
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>TABEL GAJI PEGAWAI</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<table id="datatables" class="display">
				<thead>
					<tr>
					<th>ID Pegawai</th>
					<th>Gaji Pokok</th>
					<th>Uang Makan</th>
					<th>Tanggungan</th>
					<th>Total Gaji</th>
					<th width=70>Aksi</th>
					</tr>
				</thead>
				<tbody>';
				$zero="0";
				while ($r = pg_fetch_array($query)) {
					$total = $r['gajipokok']+$r['makan']+$r['tanggungan'];
					echo "<tr>
						<td width=40>$r[idpeg]</td>
						<td>Rp"; if ($r["gajipokok"]>0) echo $r["gajipokok"]; else echo $zero; echo ",-</td>
						<td>Rp"; if ($r["makan"]>0) echo $r["makan"]; else echo $zero; echo ",-</td>
						<td>Rp"; if ($r["tanggungan"]>0) echo $r["tanggungan"]; else echo $zero; echo ",-</td>
						<td>"; echo "Rp$total,-"; echo "</td>
						<td width=50><a href=\"?module=gaji&act=edit&id=$r[idpeg]\"><img src=\"img/edit.png\" class=\"edit\"></a>
						</td>
						</tr>";
				}                    
				echo '
				</tbody>
			</table>
			</div>
	</section> ';	
} else if($_GET["act"]=="edit") {
	$query = pg_query("SELECT * FROM gaji WHERE idpeg='$_GET[id]'");
	$r = pg_fetch_array($query);
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>EDIT GAJI '.$r['idpeg'].'</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="shift form" method="post" action="modul/mod-gaji/act-gaji.php?module=gaji&act=edit&id='.$_GET['id'].'" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="gajipokok">Gaji Pokok</label>
				<input type="number" name="gajipokok" class="number" value="'.$r['gajipokok'].'" min="1000000" max="10000000" step="10000"/>
				</div>
				<div class="inline-small-label">
				<label for="makan">Uang Makan</label>
				<input type="number" name="makan" class="number" value="'.$r['makan'].'" min="50000" max="500000" step="1000"/>
				</div>
				<div class="inline-small-label">
				<label for="tanggungan">Tanggungan</label>
				<input type="number" name="tanggungan" class="number" value="'.$r['tanggungan'].'" min="50000" max="500000" step="1000"/>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=gaji">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="EDIT" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
}