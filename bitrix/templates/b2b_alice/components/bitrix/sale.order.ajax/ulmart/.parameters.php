<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;
if(!CModule::IncludeModule("sale"))
	return;
	
$arTypesEx = CIBlockParameters::GetIBlockTypes(Array("-"=>" "));
$arIBlocks=Array();
$db_iblock = CIBlock::GetList(Array("SORT"=>"ASC"), Array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];


$arPers2Prop = Array();
$dbProp = CSaleOrderProps::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), Array("PERSON_TYPE_ID" => 1));
while($arProp = $dbProp -> Fetch())
	$arPers2Prop[$arProp["ID"]] = $arProp["NAME"];
	
$arTemplateParameters = array(
	"DISPLAY_IMG_WIDTH" => Array(
		"NAME" => GetMessage("T_IMG_WIDTH"),
		"TYPE" => "TEXT",
		"DEFAULT" => "90",
	),
	"DISPLAY_IMG_HEIGHT" => Array(
		"NAME" => GetMessage("T_IMG_HEIGHT"),
		"TYPE" => "TEXT",
		"DEFAULT" => "90",
	),
	"IBLOCK_TYPE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
		"TYPE" => "LIST",
		"VALUES" => $arTypesEx,
		"DEFAULT" => "news",
		"REFRESH" => "Y",
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
	"PAY_SYSTEM_ID" => Array(
		"NAME" => GetMessage("T_PAY_SYSTEM_ID"),
		"TYPE" => "TEXT",
		"DEFAULT" => "1",
	),
	"SELF_DELIVERY_ORDER_PROP" => Array(
		"NAME" => GetMessage("T_SELF_DELIVERY_ORDER_PROP"),
		"TYPE"=>"LIST",
		"VALUES" => $arPers2Prop,
		"DEFAULT" => "",
		"COLS"=>25,
	),
	"UF_SHOP_CITY_ORDER_PROP" => Array(
		"NAME" => GetMessage("T_UF_SHOP_CITY_ORDER_PROP"),
		"TYPE"=>"LIST",
		"VALUES" => $arPers2Prop,
		"DEFAULT" => "",
		"COLS"=>25,
	),
	"DELIVERY_ORDER_PROP_DELIVERY_DATE" => Array(
		"NAME" => GetMessage("T_DELIVERY_ORDER_PROP_DELIVERY_DATE"),
		"TYPE"=>"LIST",
		"VALUES" => $arPers2Prop,
		"DEFAULT" => "",
		"COLS"=>25,
	),
	"ORDER_PROP_LOCATION" => Array(
		"NAME" => GetMessage("T_LOCATION_ORDER_PROP"),
		"TYPE"=>"LIST",
		"VALUES" => $arPers2Prop,
		"DEFAULT" => "",
		"COLS"=>25,
	),
	"SELF_DELIVERY_ORDER_PROPS_REQ" => Array(
		"NAME" => GetMessage("T_SELF_DELIVERY_ORDER_PROPS_REQ"),
		"TYPE"=>"LIST", "MULTIPLE"=>"Y",
		"VALUES" => $arPers2Prop,
		"DEFAULT" => "",
		"COLS"=>25,
		"ADDITIONAL_VALUES"=>"N",		
	),
	"DELIVERY_ORDER_PROPS_STEP3_REQ" => Array(
		"NAME" => GetMessage("T_DELIVERY_ORDER_PROPS_STEP3_REQ"),
		"TYPE"=>"LIST", "MULTIPLE"=>"Y",
		"VALUES" => $arPers2Prop,
		"DEFAULT" => "",
		"COLS"=>25,
		"ADDITIONAL_VALUES"=>"N",		
	),
	"DELIVERY_ORDER_PROPS_STEP1_REQ" => Array(
		"NAME" => GetMessage("T_DELIVERY_ORDER_PROPS_STEP1_REQ"),
		"TYPE"=>"LIST", "MULTIPLE"=>"Y",
		"VALUES" => $arPers2Prop,
		"DEFAULT" => "",
		"COLS"=>25,
		"ADDITIONAL_VALUES"=>"N",		
	),
);
?>
