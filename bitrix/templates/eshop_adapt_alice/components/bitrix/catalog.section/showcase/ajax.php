<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", ".default", array(
		"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
		"STORE_PATH" => "/store/#store_id#",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000",
		"MAIN_TITLE" => "",
		"USE_MIN_AMOUNT" =>  "N",
		"MIN_AMOUNT" => 10,
		"STORES" => array(),
		"SHOW_EMPTY_STORE" => "N",
		"SHOW_GENERAL_STORE_INFORMATION" => "Y",
		"USER_FIELDS" => array(),
		"FIELDS" => array(),
		"SELF_DELIVERY_PLACES_IBLOCK_ID" => 6,
		"AJAX_CALL" => "Y",
	),
	$component,
	array("HIDE_ICONS" => "Y"));
require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_after.php");
?>