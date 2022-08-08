<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!CModule::IncludeModule("iblock"))
{
	ShowError(GetMessage("CATALOG_MODULE_NOT_INSTALL"));
	return;
}

if(isset($arParams['STORE']))
{
	$arResult['STORE'] = intval($arParams['STORE']);
	if(!isset($arParams["CACHE_TIME"]))
		$arParams["CACHE_TIME"] = 3600;
	if($this->StartResultCache()){
		$arFilter = Array("IBLOCK_ID"=>$arParams["SELF_DELIVERY_PLACES_IBLOCK_ID"], "ACTIVE" => "Y", "ID" => $arParams["STORE"]);
		$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false,array("ID", "IBLOCK_ID", "CODE", "NAME"));
		if($ob = $res->GetNextElement()){
			$arItem = $ob->GetFields();
			$arProperties = $ob->GetProperties();
			foreach($arProperties["MORE_PHOTO"]["VALUE"] as $key => $PHOTO_ID){
				$arProperties["MORE_PHOTO"]["VALUE"][$key] = CFile::GetFileArray($PHOTO_ID);
				$arProperties["MORE_PHOTO"]["VALUE"][$key]["DESCRIPTION"] = $arProperties["MORE_PHOTO"]["DESCRIPTION"][$key];
			}
			$arResult = $arProperties;
			$arResult["ID"] = $arItem["ID"];
			$arResult["NAME"] = $arItem["NAME"];

			$this->IncludeComponentTemplate();			
		}
		else
			ShowError(GetMessage("STORE_NOT_EXIST"));
	}
	$ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues($arParams["SELF_DELIVERY_PLACES_IBLOCK_ID"], $arParams["STORE"]);
	$arResult["IPROPERTY_VALUES"] = $ipropValues->getValues();
	if($arParams["SET_TITLE"] == "Y"){
		$APPLICATION->SetTitle($arResult["NAME"]);
		$APPLICATION->SetPageProperty("title", $arResult["IPROPERTY_VALUES"]["ELEMENT_META_TITLE"]);
		$APPLICATION->SetPageProperty("keywords", $arResult["IPROPERTY_VALUES"]["ELEMENT_META_KEYWORDS"]);
		$APPLICATION->SetPageProperty("description", $arResult["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"]);
	}
}
else
	ShowError(GetMessage("STORE_NOT_EXIST"));

?>