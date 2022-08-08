<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("webservice") || !CModule::IncludeModule("catalog"))
   return;
   
// наш новый класс наследуется от базового IWebService
class CProductApiWS extends IWebService
{
	// метод GetWebServiceDesc возвращает описание сервиса и его методов
	function GetWebServiceDesc() 
	{
		$wsdesc = new CWebServiceDesc();
		$wsdesc->wsname = "product.api"; // название сервиса
		$wsdesc->wsclassname = "CProductApiWS"; // название класса
		$wsdesc->wsdlauto = true;
		$wsdesc->wsendpoint = CWebService::GetDefaultEndpoint();
		$wsdesc->wstargetns = CWebService::GetDefaultTargetNS();

		$wsdesc->classTypes = array();

		$wsdesc->structTypes["Stock"] = Array(
			"WarehouseID"  => array("varType" => "integer"),
			"Quantity"  => array("varType" => "number"),			
		);
		$wsdesc->structTypes["StockProduct"] = Array(
			"Product"  => array("varType" => "string"),
			"Stocks" => array("varType" => "ArrayOfStock", "arrType"=>"Stock", "strict"=>"no")
		);//strict=no - признак необязательности, при отсутствии - обязательно заполнение
		$wsdesc->structTypes["StockProducts"] = Array(
			"StockProducts" => array("varType" => "ArrayOfStockProduct", "arrType"=>"StockProduct")
		);
		$wsdesc->structTypes["ProductUpdate"] = Array(
			"Product"  => array("varType" => "string"),
			"Updated" => array("varType" => "boolean"),
			"Error" => array("varType" => "string"),
		);
		$wsdesc->structTypes["ProductUpdates"] = Array(
			"ProductUpdates" => array("varType" => "ArrayOfProductUpdate", "arrType"=>"ProductUpdate"),
		);

		$wsdesc->classes = array(
		   "CProductApiWS"=> array(
			  "UpdateStocks" => array(
				 "type"      => "public",
				 "input"      => array(
					"Site" => array("varType" => "string"),					
					"Stocks" => array("varType" => "StockProducts"),
					),
				 "output"   => array(
					"Result" => array("varType" => "int"),
				 ),
				 "httpauth" => "N"
			  ),
		   )
		);	  

	    return $wsdesc;
	}
	function UpdateStocks($Site, $Stocks)
	{
		$Quantity = 0;
		$arStores = array();//Массив Ключ - Код клада в 1С, Значение ID - Bitrix
		$res_CS = CCatalogStore::GetList(array(), array(), false, false, array("ID","XML_ID"));
		while ($ar_CS = $res_CS->Fetch())
			$arStores[$ar_CS[XML_ID]] = $ar_CS["ID"];
	
		$arSelect = Array("ID", "NAME", "CODE", "XML_ID");
		foreach ($Stocks["StockProducts"] as $Stock){
			$arFilter = Array("XML_ID"=>$Stock["Product"]);
			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
			if ($ob = $res->GetNextElement()){
				$arFields = $ob->GetFields();
				$res_CSP = CCatalogStoreProduct::GetList(array(), array(">AMOUNT" =>0, "PRODUCT_ID"=>$arFields["ID"]), false, false, Array("ID", "STORE_ID", "PRODUCT_ID", "AMOUNT"));
				while ($ar_CSP = $res_CSP->Fetch())
					CCatalogStoreProduct::Update($ar_CSP["ID"], array("PRODUCT_ID"=>$arFields["ID"], "AMOUNT"=>0));
				foreach ($Stock["Stocks"] as $StockItem){
					$Quantity = $Quantity + $StockItem["Quantity"];
					$res_CSP = CCatalogStoreProduct::GetList(array(), array("PRODUCT_ID"=>$arFields["ID"],"STORE_ID"=>$arStores[$StockItem["WarehouseID"]]), false, false, Array("ID", "STORE_ID", "PRODUCT_ID", "AMOUNT"));
					if ($ar_CSP = $res_CSP->Fetch())
					   CCatalogStoreProduct::Update($ar_CSP["ID"], array("PRODUCT_ID"=>$arFields["ID"], "AMOUNT"=>$StockItem["Quantity"]));
				    else
					   CCatalogStoreProduct::Add(array("PRODUCT_ID"=>$arFields["ID"], "STORE_ID"=>$arStores[$StockItem["WarehouseID"]], "AMOUNT"=>$StockItem["Quantity"]));				   
				}
				CCatalogProduct::Update($arFields["ID"], array("QUANTITY"=>$Quantity));
			}
		}
		/*return new CSOAPFault( 'Server Error1', print_r($Stocks));*/
	    return 1;

	}   
}

$arParams["WEBSERVICE_NAME"] = "product.api";
$arParams["WEBSERVICE_CLASS"] = "CProductApiWS";
$arParams["WEBSERVICE_MODULE"] = "";

// передаем в компонент описание веб-сервиса
$APPLICATION->IncludeComponent(
   "bitrix:webservice.server",
   "",
   $arParams
   );

die();
?>