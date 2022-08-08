<?php
//<title>Обновление цен 133 прейскуранта</title>
$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__)."/../../../..");
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if (CModule::IncludeModule("catalog") ==false)
{
	die();
}
if (CModule::IncludeModule('webservice') ==false)
{
	die();
}

$PriceListDetails = array();
$PriceListDetail = array();
$PRICE_LIST_ID = 4;
$PRICE_LIST_ID_1C = 133;
$PacketSize = 700;
$i = 1;

$db_res = CCatalogProduct::GetList(array(),array());
while (($ar_res = $db_res->Fetch())){
	$rs_element = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $ar_res["ELEMENT_IBLOCK_ID"], 'ID'=>$ar_res["ID"]), array("ID", "ACTIVE", "CODE", "XML_ID", "IBLOCK_ID"));
	if ($ar_element = $rs_element->GetNext()){
		if($ar_element["ACTIVE"] == "N")
		   continue;
		/*if($ar_element["CODE"] != "0186283")
		   continue;*/
		if (strpos($ar_element["XML_ID"], "_") == true && $ar_element["IBLOCK_ID"] == 2)
			continue;
		$arPrices = CatalogGetPriceTableEx($ar_element["ID"], 0, array($PRICE_LIST_ID));
		if ($arPrices["MATRIX"][$PRICE_LIST_ID][0]["PRICE"] == 0)
		   continue;
		$arDiscounts = CCatalogDiscount::GetDiscount($ar_element["ID"], $ar_element["IBLOCK_ID"], array(), "N", array(),"s1");   
		$PRICE = $arPrices["MATRIX"][$PRICE_LIST_ID][0]["PRICE"];
		$PRICE = CCatalogProduct::CountPriceWithDiscount($PRICE, "RUB", $arDiscounts);
		$PriceListDetail = array("Code"=>$ar_element["CODE"], "Price"=> round($PRICE)); 
		$PriceListDetails[$i.":Items"] = $PriceListDetail;
		$i++;
		/*if ($i>500)
		  break;*/
	}
}
$client = new CSOAPClient("reports.alice.ru", "/AliceWebService/ws/AliceCIS.1cws");
$request = new CSOAPRequest("UploadPriceList", "trade.alice.ru");
$request->addParameter("PriceListID", $PRICE_LIST_ID_1C);
$request->addParameter("PacketSize", $PacketSize);
$request->addParameter("PriceList", $PriceListDetails);
$response = $client->send($request);
if (!$response->isFault()){
    print_r($response->Value);
}
?>