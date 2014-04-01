<?php
include "koneksi.php";
$query = pg_query("SELECT * FROM proyek ORDER BY idpro DESC");
$data = pg_fetch_array($query);
$id = $data["idpro"];
$data = strval($id);
$data++;