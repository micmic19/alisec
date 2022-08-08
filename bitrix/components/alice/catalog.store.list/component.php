<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!CModule::IncludeModule("iblock"))
{
	ShowError(GetMessage("CATALOG_MODULE_NOT_INSTALL"));
	return;
}
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 360;
$arResult["TITLE"] = GetMessage("SCS_DEFAULT_TITLE");
$arResult["MAP"] = $arParams["MAP_TYPE"];
if(!isset($arParams["PATH_TO_ELEMENT"]))
	$arParams["PATH_TO_ELEMENT"]="store/#store_id#";
if($this->StartResultCache()){
	$arFilter = Array("IBLOCK_ID"=>$arParams["SHOPS_IBLOCK_ID"], "CODE"=>$_SESSION["UF_SHOP_CITY_NAME"]);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "PROPERTY_PHONE", "PROPERTY_LOCATION"));
	if($ob = $res->GetNextElement()){
		$ar_res = $ob->GetFields();
		$ShopID = $ar_res["ID"];
	}
	$arFilter = Array("IBLOCK_ID"=>$arParams["SELF_DELIVERY_PLACES_IBLOCK_ID"], "ACTIVE" => "Y", "PROPERTY_SHOP_CITY" => $ShopID);
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false,array("ID", "CODE", "NAME", "PROPERTY_METRO_STATION", "PROPERTY_ADDRESS", "PROPERTY_OUTPOST","PROPERTY_PHONE","PROPERTY_WORK_HOURS", "PROPERTY_LOCATION", "PROPERTY_PAYMENT_METHOD_CASH", "PROPERTY_PAYMENT_METHOD_CARD", "PROPERTY_DELIVERY_CALCULATE","PROPERTY_YANDEX_PLACE_MAP", "PROPERTY_STORE_ID"));
	$arResult["SELF_DELIVERY_PLACES"] = Array();
	while($ob = $res->GetNextElement()){
		$arItem = $ob->GetFields();
		$arItem["URL"] = CComponentEngine::MakePathFromTemplate($arParams["PATH_TO_ELEMENT"], array("store_id" => $arItem["ID"]));
		$arResult["SELF_DELIVERY_PLACES"][] = $arItem;
	}
	$this->IncludeComponentTemplate();
}
if ($arParams["SET_TITLE"] == "Y")
	$APPLICATION->SetTitle($arParams["TITLE"]);
?>