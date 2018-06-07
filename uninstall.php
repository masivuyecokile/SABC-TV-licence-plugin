<?php
	
	/*
	*	Trigger on uninstall
	*/

if(!defined('WP_UNINSTALL_PLUGIN')){
	die("not allowed");
}

include ("connection.php");
	//delete all data
	$sql = "DROP table wp_tvlicence_entries";
	$stmt = conn::run($sql);