<?php 

function formatDate($date)
{

	return date('d/m/Y', strtotime($date));

}

function getServerName()
{

	return $_SERVER['SERVER_NAME'];

}