<?php 
include 'pgsql.class.php';
$pgsqldb = new pgsql("localhost","company","postgres","MurihPusparum");
$pgsqldb->connect();