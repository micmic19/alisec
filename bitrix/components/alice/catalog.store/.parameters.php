<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!CModule::IncludeModule("iblock"))
	return;
$arTypesEx = CIBlockParameters::GetIBlockTypes(Array("-"=>" "));
$arIBlocks=Array();
$db_iblock = CIBlock::GetList(Array("SORT"=>"ASC"), Array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];


$arComponentParameters = Array(
	"PARAMETERS" => Array(
		"SEF_MODE" => array(
			"liststores" => array(
				"NAME" => GetMessage("CATALOG_SEF_INDEX"),
				"DEFAULT" => "index.php",
				"VARIABLES" => array(),
			),
			"element" => array(
				"NAME" => GetMessage("CATALOG_SEF_DETAIL"),
				"DEFAULT" => "#store_id#",
				"VARIABLES" => array(),
			),
		),
		"SHOPS_IBLOCK_ID" => Array(
			"NAME" => GetMessage("T_SHOPS_IBLOCK_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => "SHOPS",
			"REFRESH" => "Y",
		),
		"SELF_DELIVERY_PLACES_IBLOCK_ID" => Array(
			"NAME" => GetMessage("T_SELF_DELIVERY_PLACES_IBLOCK_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,		
			"DEFAULT" => "SELF_DELIVERY_PLACES",
			"REFRESH" => "Y",
		),
		"SET_TITLE" => array(
			'PARENT' => 'ADDITIONAL_SETTINGS',
			'NAME' => GetMessage('USE_TITLE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
		),
		"TITLE" => array(
			"PARENT" => "ADDITIONAL_SETTINGS",
			"NAME"		=> GetMessage("TITLE"),
			"TYPE"		=> "STRING",
			"DEFAULT"	=> GetMessage('DEFAULT_TITLE'),
		),
		"CACHE_TIME" => Array("DEFAULT"=>"3600"),
	)
);
?>