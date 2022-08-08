<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = Array(
	"PARAMETERS" => Array(
		"PATH_TO_ELEMENT" => array(
			'PARENT' => 'STORE_SETTINGS',
			'NAME' => GetMessage('STORE_PATH'),
			"TYPE"		=> "STRING",
			"DEFAULT"	=> "store/#store_id#",
		),
		"SHOPS_IBLOCK_ID" => Array(
			"NAME" => GetMessage("T_SHOPS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"SELF_DELIVERY_PLACES_IBLOCK_ID" => Array(
			"NAME" => GetMessage("T_SELF_DELIVERY_PLACES_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"SET_TITLE" => Array(),
		"CACHE_TIME" => Array("DEFAULT"=>36000000),
	)
);
?>