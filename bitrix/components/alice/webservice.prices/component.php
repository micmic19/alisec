<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("webservice") || !CModule::IncludeModule("catalog"))
   return;
   
// наш новый класс наследуется от базового IWebService
class CGetPriceListWS extends IWebService
{
	// метод GetWebServiceDesc возвращает описание сервиса и его методов
	function GetWebServiceDesc() 
	{
		$wsdesc = new CWebServiceDesc();
		$wsdesc->wsname = "alice.bitrix"; // название сервиса
		$wsdesc->wsclassname = "CGetPriceListWS"; // название класса
		$wsdesc->wsdlauto = true;
		$wsdesc->wsendpoint = "http://www.alice.ru/bitrix/services/ws_getprices.php";
		$wsdesc->wstargetns = "http://schemas.alice.ru/services/bitrix/";

		$wsdesc->classTypes = array();
		$wsdesc->structTypes["PriceListDetail"] = Array(
			"Article"  => array("varType" => "string"),
			"Price"  => array("varType" => "double"),
			"PriceDiscount"  => array("varType" => "double"),
			"Discounts" => array("varType" => "ArrayOfDiscountID", "arrType"=>"DiscountID")
		);
		$wsdesc->structTypes["Discount"] = Array(
			"Id"  => array("varType" => "integer"),
			"Name"  => array("varType" => "string"),
			"Value" => array("varType" => "integer"),
			"Priority" => array("varType" => "integer"),
			"Last" => array("varType" => "string")
		);
		$wsdesc->structTypes["DiscountID"] = Array(
			"Id"  => array("varType" => "integer"),
		);
		$wsdesc->structTypes["PriceList"] = Array(
			"PriceListDetails" => array("varType" => "ArrayOfPriceListDetail", "arrType"=>"PriceListDetail"),
			"Discounts" => array("varType" => "ArrayOfDiscount", "arrType"=>"Discount")					
		);
		
		$wsdesc->classes = array(
		   "CGetPriceListWS"=> array(
			  "GetPrices" => array(
				 "type"      => "public",
				 "input"      => array(
					"Code" => array("varType" => "integer"),
					"Site" => array("varType" => "string"),					
					),
				 "output"   => array(
					"PriceList" => array("varType" => "PriceList"),
				 ),
				 "httpauth" => "N"
			  ),
		   )
		);	  
	  //$wsdesc->classes = array();

	  return $wsdesc;
	}
	function GetPrices($Code, $Site)
	{
		$dbPriceType = CCatalogGroup::GetList(
			array(),
			array("XML_ID" => $Code)
		);
		while ($arPriceType = $dbPriceType->Fetch())
			$Id = $arPriceType["ID"];
		$i = 1;
		$PriceList = array("PriceListDetails"=>array(), "Discounts"=>array());
		$db_res = CCatalogProduct::GetList(array(),array());
		while (($ar_res = $db_res->Fetch())){
			$rs_element = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $ar_res["ELEMENT_IBLOCK_ID"], 'ID'=>$ar_res["ID"]), array("ID", "ACTIVE", "CODE", "XML_ID", "IBLOCK_ID"));
			if ($ar_element = $rs_element->GetNext()){
				if($ar_element["ACTIVE"] == "N")
				   continue;
				/*if($ar_element["CODE"] != "0105513")
				   continue;*/
				if (strpos($ar_element["XML_ID"], "_") == true && $ar_element["IBLOCK_ID"] == 2)
					continue;
				$arPrices = CatalogGetPriceTableEx($ar_element["ID"], 0, array($Id));
				if ($arPrices["MATRIX"][$Id][0]["PRICE"] == 0)
				   continue;
				$arDiscounts = CCatalogDiscount::GetDiscount($ar_element["ID"], $ar_element["IBLOCK_ID"], array(), "N", array(), $Site);   
				$PRICE = $arPrices["MATRIX"][$Id][0]["PRICE"];
				$PRICEDISCOUNT = CCatalogProduct::CountPriceWithDiscount($PRICE, "RUB", $arDiscounts);
				$arArticleDiscounts = array();
				foreach ($arDiscounts as $arDiscount){
					$arArticleDiscounts[] = array("Id"  => $arDiscount["ID"]);
					$arCatalogDiscount = array(
						"Id"  => $arDiscount["ID"],
						"Name"  => $arDiscount["NAME"],
						"Value" => $arDiscount["VALUE"],
						"Priority" => $arDiscount["PRIORITY"],
						"Last" => $arDiscount["LAST_DISCOUNT"]);
					$PriceList["Discounts"][$arDiscount["ID"].":Items"] = $arCatalogDiscount;	
				}	
				$PriceListDetail = array("Article"=>$ar_element["CODE"], "Price"=> round($PRICE), "PriceDiscount"=> round($PRICEDISCOUNT), "Discounts"=>$arArticleDiscounts); 
				$PriceList["PriceListDetails"][$i.":Items"] = $PriceListDetail;
				$i++;
				if ($i>10000)
				  break;
			}
		}
		$result = array("PriceList"=>$PriceList);
	    return $result;
		
	    return new CSOAPFault( 'Server Error', 'Some Error: ');
	}   
}

$arParams["WEBSERVICE_NAME"] = "alice.bitrix";
$arParams["WEBSERVICE_CLASS"] = "CGetPriceListWS";
$arParams["WEBSERVICE_MODULE"] = "";

// передаем в компонент описание веб-сервиса
$APPLICATION->IncludeComponent(
   "bitrix:webservice.server",
   "",
   $arParams
   );

die();
?>