<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

if(!CModule::IncludeModule("iblock")){
	ShowError("CATALOG_MODULE_NOT_INSTALLED");
	return;
}

global $APPLICATION;
if (!empty($_GET["cityid"])){
	$UF_SHOP_CITY_NAME = $_GET["cityid"];
	$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>$UF_SHOP_CITY_NAME);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "CODE", "NAME"));
	if($ob = $res->GetNextElement()){
		$_SESSION["UF_SHOP_CITY_NAME"] = trim($UF_SHOP_CITY_NAME);
		$APPLICATION->set_cookie("UF_SHOP_CITY_NAME", $_SESSION["UF_SHOP_CITY_NAME"], time() + 60 * 60 * 24);
	}
}

if ($this->StartResultCache($_SESSION["UF_SHOP_CITY_NAME"]))
{
//select all active warehouses
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "ACTIVE" => "Y");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, array("ID","CODE", "NAME"));
$arShops = Array();
while($ob = $res->GetNextElement())
{
	$arShops[] = $ob->GetFields();
}	
$arResult["ITEMS"]=$arShops;
//select current warehouses
if (!empty($_SESSION["UF_SHOP_CITY_NAME"])){
	$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>$_SESSION["UF_SHOP_CITY_NAME"]);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "CODE", "NAME", "PROPERTY_SCHEDULE", "PROPERTY_PHONE", "PROPERTY_PHONE_GLOBAL", "PROPERTY_PHONE1","PROPERTY_WIDGET_ID", "PROPERTY_YANDEX_METRIKA", "PROPERTY_JIVO_SITE", "PROPERTY_GEO_META_TAG","PREVIEW_PICTURE"));
	if($ob = $res->GetNextElement())
	{
		$arResult["UF_SHOP_CITY"] = $ob->GetFields();
		$arResult["UF_SHOP_CITY"]["PREVIEW_PICTURE"] = CFile::GetFileArray($arResult["UF_SHOP_CITY"]["PREVIEW_PICTURE"]);		
	}	
}
if (empty($arParams["DIV_ROW_QUANTITY"])||!is_numeric($arParams["DIV_ROW_QUANTITY"])||$arParams["DIV_ROW_QUANTITY"]<=0) 
	$arResult["DIV_ROW_QUANTITY"] = count($arShops);
else
	$arResult["DIV_ROW_QUANTITY"] = (int)$arParams["DIV_ROW_QUANTITY"];

	$this->IncludeComponentTemplate();

}
?>