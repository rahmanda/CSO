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
if(empty($_GET['act'])) {
	$query = pg_query("SELECT * FROM perpesanan WHERE penerima='$_SESSION[id]' ORDER BY tanggal DESC");
	echo '
	<div class="info-content">
		<ul class="button add"><li><a href="?module=pesan&act=input">Kirim Pesan</a></li></ul>
	</div>
	<section id="box-border">
		<div class="block-header">
			<h1>PESAN MASUK</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<table id="datatables" class="display">
				<thead>
					<tr>
					<th width=200>Pengirim</th>
					<th width=300>Subjek</th>
					<th>Waktu Kirim</th>
					<th>Dibaca</th>
					<th>Aksi</th>
					</tr>
				</thead>
				<tbody>';
				while ($r = pg_fetch_array($query)) {
					$idsender = $r['pengirim'];
					$sender = pg_fetch_array(pg_query("SELECT namadep||' '||namabel as nama FROM pegawai WHERE idpeg='$idsender'"));
					if ($r["dibaca"] == 'N') {
					echo "<tr class='dibaca'>
						<td width=40>$sender[nama]</td>
						<td>$r[subjek]</td>
						<td>$r[tanggal]</td>
						<td>$r[dibaca]</td>
						<td><a href=\"?module=pesan&act=balas&time=$r[tanggal]\"><img src=\"img/mail.png\" class=\"edit\"></a>
						&nbsp;&nbsp;<a href=\"javascript:confirmdelete('modul/mod-pesan/act-pesan.php?module=pesan&act=hapus&time=$r[tanggal]')\"><img src=\"img/hapus.png\" class='hapus'></a></td>
						</tr>";
					} else {
						echo "<tr>
						<td width=40>$sender[nama]</td>
						<td>$r[subjek]</td>
						<td>$r[tanggal]</td>
						<td>$r[dibaca]</td>
						<td><a href=\"?module=pesan&act=balas&time=$r[tanggal]\"><img src=\"img/mail.png\" class=\"edit\"></a>
						&nbsp;&nbsp;<a href=\"javascript:confirmdelete('modul/mod-pesan/act-pesan.php?module=pesan&act=hapus&time=$r[tanggal]')\"><img src=\"img/hapus.png\" class='hapus'></a></td>
						</tr>";
					}
				}                    
				echo '
				</tbody>
			</table>
			</div>
	</section> ';	
} else if($_GET["act"]=="input") {
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>PESAN</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="message form" method="post" action="modul/mod-pesan/act-pesan.php?module=pesan&act=input&sender='.$_SESSION['id'].'" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="penerima">Kepada</label>
				<input type="text" name="penerima" class="text" size="60"/>
				</div>
				<div class="inline-small-label">
				<label for="subjek">Subjek</label>
				<input type="text" name="subjek" class="text" size="60"/>
				</div>
				<div class="inline-small-label">
				<label for="content-message">Pesan</label>
				<div class="textarea">
				<textarea name="content-message" class="content-message"></textarea>
				</div>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=pesan">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="KIRIM" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
} else if($_GET["act"]=="balas") { 
	$time = $_GET['time'];
	$swap_read = pg_query("UPDATE perpesanan SET dibaca='Y' WHERE tanggal='$time'");
	$fetch = pg_fetch_array(pg_query("SELECT * FROM perpesanan WHERE tanggal='$time' and penerima='$_SESSION[id]'"));
	echo '
	<section id="box-border">
		<div class="block-header">
			<h1>PESAN</h1>
			<span class="icon-collapse-alt"></span>
		</div>
		<div class="block-content">
			<form class="message form" method="post" action="modul/mod-pesan/act-pesan.php?module=pesan&act=input&sender='.$_SESSION['id'].'" enctype="multipart/form-data">
				<div class="inline-small-label">
				<label for="penerima">Kepada</label>
				<input type="text" name="penerima" class="text" size="60" value="'.$fetch['pengirim'].'"/>
				</div>
				<div class="inline-small-label">
				<label for="subjek">Subjek</label>
				<input type="text" name="subjek" class="text" size="60" value="Re: '.$fetch["subjek"].'"/>
				</div>
				<div class="inline-small-label">
				<label for="content-message">Pesan</label>
				<div class="textarea">
				<textarea name="content-message" class="content-message">'; echo $fetch["isipesan"]; echo '</textarea>
				</div>
				</div>
				<div class="actions">
				<ul class="action-left">
					<li><a class="button red" href="?module=pesan">BATALKAN</a></li>
				</ul>
				<ul class="action-right">
					<li><input type="submit" class="button" value="KIRIM" /></li>
				</ul>
				</div>
			</form>
		</div>
	</section>';
}