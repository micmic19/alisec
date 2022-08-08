<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


$arComponentParameters = Array(
	"PARAMETERS" => Array(
		"STORE" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME" => GetMessage("STORE_ID"),
			"TYPE" => "STRING",
			"DEFAULT" => "1"
		),
		"SELF_DELIVERY_PLACES_IBLOCK_ID" => Array(
			"NAME" => GetMessage("T_SELF_DELIVERY_PLACES_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME" => Array("DEFAULT"=>"3600"),
		"SET_TITLE" => Array(),
	)
);
?>