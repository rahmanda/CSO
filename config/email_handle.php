<?php
	$email = "johndoe_P001@gmail.com";
	$array = explode('@', $email);
	$name = explode('_', $array[0]);
	echo $name[1];
	echo $array[0];