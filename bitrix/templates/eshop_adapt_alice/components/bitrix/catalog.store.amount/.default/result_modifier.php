<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
//obtain shop_id
$arFilter = Array("IBLOCK_ID"=>$arParams["SHOPS_IBLOCK_ID"], "CODE" => $arParams["SELF_DELIVERY_PLACES_SHOP_CODE"]);
$res = CIBlockElement::GetList(array(), $arFilter, false, false,array("ID", "NAME"));
if($ob = $res->GetNextElement()){
	$arItem = $ob->GetFields();
	$ShopID = $arItem["ID"];
}

$prodID = $arParams["ELEMENT_ID"];
$arFilter = Array("IBLOCK_ID"=>$arParams["SELF_DELIVERY_PLACES_IBLOCK_ID"], "ACTIVE" => "Y", "PROPERTY_SHOP_CITY"=>$ShopID);

function ElementMeasure($ID, $IBLOCK_ID){
	$measure = "";
	$arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ID" => $ID);
	$res = CIBlockElement::GetList(array(), $arFilter, false, false,array("ID", "NAME", "PROPERTY_CML2_BASE_UNIT"));
	if($ob = $res->GetNextElement()){
		$arItem = $ob->GetFields();
		$rsMeasures = CCatalogMeasure::getList(
		array(),
		array('CODE' => $arItem["PROPERTY_CML2_BASE_UNIT_VALUE"]),
		false,
		false,
		array('ID', 'SYMBOL_RUS'));
		if ($arMeasure = $rsMeasures->GetNext())
			$measure = $arMeasure['SYMBOL_RUS'];
	}
	if ($measure == "")
		return "шт";
	else
		return $measure;
}

$arResult['JS']['MEASURE'] = ElementMeasure($prodID, 2);

$arStores = array();
$jsSKU = array();
$jsSKUMeasures = array();
$jsStores = array();

$res = CIBlockElement::GetList(array(), $arFilter, false, false,array("ID", "NAME", "PROPERTY_STORE_ID", "PROPERTY_ADDRESS", "PROPERTY_PHONE","PROPERTY_WORK_HOURS", "PROPERTY_PAYMENT_METHOD_CASH", "PROPERTY_PAYMENT_METHOD_CARD"));
while($ob = $res->GetNextElement()){
	$arItem = $ob->GetFields();
	$stores = $arItem["PROPERTY_STORE_ID_VALUE"];
	$arItem["REAL_AMOUNT"] = 0;
	foreach ($arResult["STORES"] as $store){
		if (in_array($store['ID'] , $stores)){
			$arItem["REAL_AMOUNT"] += $store['REAL_AMOUNT'];
		}
	}
	foreach ($arResult["JS"]["SKU"] as $sku_key =>$sku_values){
		foreach ($sku_values as $store_key =>$store_amount){
			if (in_array($store_key , $stores)){
				$jsSKU[$sku_key][$arItem["ID"]] += $store_amount;
			}
			$arFilterSKU = Array("IBLOCK_ID"=>3, "ID" => $sku_key);
			$resSKU = CIBlockElement::GetList(array(), $arFilterSKU, false, false,array("ID", "NAME", "PROPERTY_CML2_BASE_UNIT"));
			$jsSKUMeasures[$sku_key] = "";
			if($obresSKU = $resSKU->GetNextElement()){
				$arItemSKU = $obresSKU->GetFields();
				$rsMeasures = CCatalogMeasure::getList(
				array(),
				array('CODE' => $arItemSKU["PROPERTY_CML2_BASE_UNIT_VALUE"]),
				false,
				false,
				array('ID', 'SYMBOL_RUS'));
				if ($arMeasure = $rsMeasures->GetNext())
					$jsSKUMeasures[$sku_key] = $arMeasure['SYMBOL_RUS'];
			}
		}
	}
	$storeURL = CComponentEngine::MakePathFromTemplate($arParams["STORE_PATH"], array("store_id" => $arItem["ID"]));
	$arStores[] = array('ID' => $arItem["ID"],
					'URL' => $storeURL,
					'TITLE' => $arItem["NAME"],
					'PHONE' => $arItem["PROPERTY_PHONE_VALUE"],
					'SCHEDULE' => $arItem["PROPERTY_WORK_HOURS_VALUE"],
					'AMOUNT' => $arItem["REAL_AMOUNT"],
					'REAL_AMOUNT' => $arItem["REAL_AMOUNT"],
				);

}

$arResult["STORES"] = $arStores;
$arResult["JS"]["SKU"] = $jsSKU;
$arResult["JS"]["MEASURES"] = $jsSKUMeasures;
$arResult["JS"]["STORES"] = array();
foreach ($arResult["STORES"] as $store_key =>$store)
	$arResult["JS"]["STORES"][$store_key] = $store["ID"];

?>