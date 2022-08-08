<?
//if ($USER->IsAdmin())
//AddMessage2Log(print_r($arDiscounts,true), "sale");
// ReCaptcha v2 ()
@require_once 'include/autoload.php';
define("RE_SITE_KEY","6LeJEWAUAAAAADyGAL5Yi7Kgtzv6U_MvYrNv50f7");
define("RE_SEC_KEY","6LeJEWAUAAAAAIb626wmSOaLafOavCTiDSlOztyV");
// End ReCaptcha v2

if(!defined('LOG_FILENAME')) {
         define('LOG_FILENAME', $_SERVER['DOCUMENT_ROOT'].'/bitrix/log.txt');
}

function testAgent()
{
		//AddMessage2Log("testAgent()", "main");
        mail('rur@alice.ru', 'Агент тест', 'Агент тест');
        return "testAgent();";
}

function CheckRecaptchaGlobal() {
	$recaptcha = new \ReCaptcha\ReCaptcha(RE_SEC_KEY);
	$resp = $recaptcha->verify($_REQUEST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

	if (!$resp->isSuccess()){
		return false;
	}
	else
	{
		return true;
	}
	
}

//for smart.filter offers properties: length, width
function testofferprop($offerLen, $offerWidth, $arLen, $arWidth){
	if (is_array($arLen) && is_array($arWidth)){
		foreach ($arLen as $valLen){
			foreach ($arWidth as $valWidth){
				if ($offerLen == $valLen && $offerWidth == $valWidth)
					return true;
			}	
		}
		return false;	
	}
	if (is_array($arLen)){
		foreach ($arLen as $valLen){
			if ($offerLen == $valLen)
				return true;
		}		
		return false;	
	}	
	if (is_array($arWidth)){
		foreach ($arWidth as $valWidth){
			if ($offerWidth == $valWidth)
				return true;
		}
		return false;	
	}
	return true;	
}		

//get user fields in section
Function GetSectionUserFields($iblock_id, $element_id){
	$db_res = CIBlockElement::GetElementGroups($element_id, false);
	if ($ar_res = $db_res->Fetch())
		if (!empty($ar_res["IBLOCK_SECTION_ID"]))
			$section_id = $ar_res["IBLOCK_SECTION_ID"];
		else 
			$section_id = $ar_res["ID"];

	$ppres = CIBlockSection::GetList(array(), array("IBLOCK_ID"=>$iblock_id,"ID" => $section_id), false, array("ID","UF_*"));
	if($ar_res = $ppres->GetNext())
		return $ar_res;
	return false;
}

function OnBeforePrologHandler(){
	if (empty($_SESSION["UF_SHOP_CITY_NAME"])){
		global $APPLICATION;
		$UF_SHOP_CITY_NAME = $APPLICATION->get_cookie('UF_SHOP_CITY_NAME');
		if (!empty($UF_SHOP_CITY_NAME)){
			$_SESSION["UF_SHOP_CITY_NAME"] = $UF_SHOP_CITY_NAME;
		}
		else{$_SESSION["UF_SHOP_CITY_NAME"] = "shop.alice.ru";/*
            require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/rossvs.ipgeobase/ipgeobase.php");
            $gb = new IPGeoBase($_SERVER["DOCUMENT_ROOT"].'/upload/cidr_optim.txt',$_SERVER["DOCUMENT_ROOT"].'/upload/cities.txt');
            $data = $gb->getRecord($_SERVER["REMOTE_ADDR"]);
			if (empty($data["region"])){
				$_SESSION["UF_SHOP_CITY_NAME"] = "shop.alice.ru";
			}
			else{
				if ($data["region"]==iconv('UTF-8', 'windows-1251', "Свердловская область") || $data["region"]==iconv('UTF-8', 'windows-1251', "Челябинская область"))
					$_SESSION["UF_SHOP_CITY_NAME"] = "ekb.alice.ru";
				else if ($data["region"]==iconv('UTF-8', 'windows-1251', "Новосибирская область"))	
					$_SESSION["UF_SHOP_CITY_NAME"] = "sib.alice.ru";		
				else if ($data["region"]==iconv('UTF-8', 'windows-1251', "Самарская область"))
					$_SESSION["UF_SHOP_CITY_NAME"] = "sam.alice.ru";		
				else if ($data["region"]==iconv('UTF-8', 'windows-1251', "Пензенская область"))
					$_SESSION["UF_SHOP_CITY_NAME"] = "penza.alice.ru";		
				else if ($data["region"]==iconv('UTF-8', 'windows-1251', "Московская область") || $data["region"]==iconv('UTF-8', 'windows-1251', "Москва"))
					$_SESSION["UF_SHOP_CITY_NAME"] = "msk.alice.ru";		
				else	
					$_SESSION["UF_SHOP_CITY_NAME"] = "shop.alice.ru";
			}*/
		}
	}
}

function OnBeforeCatalogImport1CHandler(){

	CModule::IncludeModule("catalog");
	$CATALOG_IBLOCK_ID = 2;
	$SKU_IBLOCK_ID = 3;
	$rsCatalog = CIBlockElement::GetList(array(),array('IBLOCK_ID' => $CATALOG_IBLOCK_ID),false,false,Array("ID","ACTIVE"));
	while ($arCatalog = $rsCatalog->GetNextElement()) {
		$arCatalogFields = $arCatalog->GetFields();	
		$rsOffers = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $SKU_IBLOCK_ID, 'PROPERTY_CML2_LINK' => $arCatalogFields["ID"]), false, false, Array("ID","ACTIVE"));
		$hasSKU = false;
		$PRODUCT_ID = $arCatalogFields["ID"];
		while($ob = $rsOffers->GetNextElement()){
			$hasSKU = true;
			$arOfferFields = $ob->GetFields();
			$PRODUCT_ID = $arOfferFields["ID"];
			$catsp_list = CCatalogStoreProduct::GetList(array(), array("PRODUCT_ID"=>$PRODUCT_ID));
			while ($arStore = $catsp_list->Fetch())
				CCatalogStoreProduct::Update($arStore["ID"], array("PRODUCT_ID"=>$PRODUCT_ID, "AMOUNT"=>0));
		}
		if ($hasSKU == false){
			$catsp_list = CCatalogStoreProduct::GetList(array(), array("PRODUCT_ID"=>$PRODUCT_ID));
			while ($arStore = $catsp_list->Fetch())
				CCatalogStoreProduct::Update($arStore["ID"], array("PRODUCT_ID"=>$PRODUCT_ID, "AMOUNT"=>0));
		}
	}	
}

function OnSuccessCatalogImport1CHandler(){
	/*
	1. delete old measure ratio
	2. add measure and measure ratio into catalog from SKU infoblock and Catalog infoblock (without sku) properties(CATALOG_MEASURE_RATIO, CML2_BASE_UNIT)
	3. for deactivated elements set Quantity = 0 and Quantity by store = 0, ACTIVE_ALICE = empty
	4. deactivated elements set active="Y"(for search and reference purposes)
	5. update property MINIMUM_PRICE form BASE pricelist SKU(for sort by price)
	*/
	CModule::IncludeModule("catalog");

	$start_time = getdate()[0];

	$res = CCatalogMeasureRatio::getList (array(), array()); 
	while ($arr = $res->GetNext()){
		CCatalogMeasureRatio::delete ($arr["ID"]);
	}
	$CATALOG_IBLOCK_ID = 2;
	$SKU_IBLOCK_ID = 3;
	$rsCatalog = CIBlockElement::GetList(array(),array('IBLOCK_ID' => $CATALOG_IBLOCK_ID),false,false,Array("ID","ACTIVE","PROPERTY_CATALOG_MEASURE_RATIO","PROPERTY_CML2_BASE_UNIT"));
	while ($arCatalog = $rsCatalog->GetNextElement()){
		$arCatalogFields = $arCatalog->GetFields();	
		$rsOffers = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $SKU_IBLOCK_ID, 'PROPERTY_CML2_LINK' => $arCatalogFields["ID"]), false, false, Array("ID","ACTIVE","PROPERTY_CATALOG_MEASURE_RATIO","PROPERTY_CML2_BASE_UNIT"));
		$min_price = 10000000;
		$hasSKU = false;
		$active_count = 0;
		while($ob = $rsOffers->GetNextElement()){
			$hasSKU = true;
			$arOfferFields = $ob->GetFields();
			if (!empty($arOfferFields["PROPERTY_CATALOG_MEASURE_RATIO_VALUE"])){
				$ar_Ratio = array("PRODUCT_ID"=>$arOfferFields["ID"], "RATIO"=>$arOfferFields["PROPERTY_CATALOG_MEASURE_RATIO_VALUE"]);
				CCatalogMeasureRatio::add($ar_Ratio);
			}
			if (!empty($arOfferFields["PROPERTY_CML2_BASE_UNIT_VALUE"])){
				$m_list = CCatalogMeasure::getList(array(), array("CODE"=>$arOfferFields["PROPERTY_CML2_BASE_UNIT_VALUE"]));
				if($ar_measure = $m_list->GetNext()){
					CCatalogProduct::Update($arOfferFields["ID"], array("MEASURE"=>$ar_measure["ID"]));
				}
			}
			if ($arOfferFields["ACTIVE"] == "Y")
				$active_count = $active_count + 1;
			if ($arOfferFields["ACTIVE"] == "N"){
				CCatalogProduct::Update($arOfferFields["ID"], array("QUANTITY"=>0));
				$catsp_list = CCatalogStoreProduct::GetList(array(), array("PRODUCT_ID"=>$arOfferFields["ID"]));
				while ($arStore = $catsp_list->Fetch())
					CCatalogStoreProduct::Update($arStore["ID"], array("PRODUCT_ID"=>$arOfferFields["ID"],"AMOUNT"=>0));
				//$obEl = new CIBlockElement();
				//$obEl->Update($arOfferFields["ID"], array('ACTIVE' => 'Y'));
			}
			$arProduct = CCatalogProduct::GetByID($arOfferFields["ID"]);
			if (!$arProduct["QUANTITY"]==0){
				$ar_price = GetCatalogProductPrice($arOfferFields["ID"], 1);
				if ($ar_price["PRICE"] < $min_price)
					$min_price = $ar_price["PRICE"];
			}
		}
		if ($hasSKU === false){
			if (!empty($arCatalogFields["PROPERTY_CATALOG_MEASURE_RATIO_VALUE"])){
				$ar_Ratio = array("PRODUCT_ID"=>$arCatalogFields["ID"], "RATIO"=>$arCatalogFields["PROPERTY_CATALOG_MEASURE_RATIO_VALUE"]);
				CCatalogMeasureRatio::add($ar_Ratio);
			}
			if (!empty($arCatalogFields["PROPERTY_CML2_BASE_UNIT_VALUE"])){
				$m_list = CCatalogMeasure::getList(array(), array("CODE"=>$arCatalogFields["PROPERTY_CML2_BASE_UNIT_VALUE"]));
				if($ar_measure = $m_list->GetNext()){
					CCatalogProduct::Update($arCatalogFields["ID"], array("MEASURE"=>$ar_measure["ID"]));
				}
			}
			if ($arCatalogFields["ACTIVE"] == "Y")
				$active_count = $active_count + 1;
			if ($arCatalogFields["ACTIVE"] == "N"){
				CCatalogProduct::Update($arCatalogFields["ID"], array("QUANTITY"=>0));
				$catsp_list = CCatalogStoreProduct::GetList(array(), array("PRODUCT_ID"=>$arCatalogFields["ID"]));
				while ($arStore = $catsp_list->Fetch())
					CCatalogStoreProduct::Update($arStore["ID"], array("PRODUCT_ID"=>$arCatalogFields["ID"],"AMOUNT"=>0));
				//$obEl = new CIBlockElement();
				//$obEl->Update($arCatalogFields["ID"], array('ACTIVE' => 'Y'));
			}
			$arProduct = CCatalogProduct::GetByID($arCatalogFields["ID"]);
			if (!$arProduct["QUANTITY"]==0){
				$ar_price = GetCatalogProductPrice($arCatalogFields["ID"], 1);
				if ($ar_price["PRICE"] < $min_price)
					$min_price = $ar_price["PRICE"];
			}
			else
				$active_count = 0;
		}
		if ($active_count == 0)
			CIBlockElement::SetPropertyValuesEx($arCatalogFields["ID"], $CATALOG_IBLOCK_ID, Array("ACTIVE_ALICE"=>false, "SALELEADER_ALICE"=>false));		
		if (!$min_price==10000000)
			CIBlockElement::SetPropertyValuesEx($arCatalogFields["ID"], $CATALOG_IBLOCK_ID, Array("MINIMUM_PRICE"=>$min_price));
	}
   $finish_time = getdate()[0];
   mail('rur@alice.ru', 'OnSuccessCatalogImport1CHandler', ($finish_time - $start_time));
   echo($finish_time - $start_time);
   return "OnSuccessCatalogImport1CHandler();"; 
}

function OnGetOptimalPriceHandler($intProductID, $quantity, $arUserGroups, $renewal, $arPrices, $siteID, $arDiscountCoupon){
	CModule::IncludeModule("catalog");
	if (empty($_SESSION["UF_SHOP_CITY_NAME"]))
		$price_code = "BASE";//for subsribe purposes only
	else
		$price_code = $_SESSION["UF_SHOP_CITY_NAME"];
		
	$dbProductPrice = CCatalogGroup::GetList(array(),array("NAME"=>$price_code));
	if (!$ar_PriceList = $dbProductPrice->Fetch()){
		return false;
	}
	$dbPriceList = CPrice::GetListEx(
		array(),
		array(
				"PRODUCT_ID" => $intProductID,
				"GROUP_GROUP_ID" => $arUserGroups,
				"CATALOG_GROUP_ID" => $ar_PriceList["ID"],
				"GROUP_BUY" => "Y",
				"+<=QUANTITY_FROM" => $quantity,
				"+>=QUANTITY_TO" => $quantity
			),
		false,
		false,
		array("ID", "CATALOG_GROUP_ID", "PRICE", "CURRENCY")
	);
	while ($arPriceList = $dbPriceList->Fetch())
	{
		$arPrices = $arPriceList;
	}
	$intIBlockID = (int)CIBlockElement::GetIBlockByID($intProductID);
	$arDiscounts = array();
	$arDiscounts = CCatalogDiscount::GetDiscount($intProductID, $intIBlockID, $arPrices["CATALOG_GROUP_ID"], $arUserGroups, $renewal, $siteID, $arDiscountCoupon);
	return array("PRICE" => $arPrices,
				 "DISCOUNT_LIST" => $arDiscounts);
}

class CSendUserInfo {

	private static $newUserPass = false;
	private static $newUserCoupon = false;	

	public static function OnBeforeUserAddHandler($arFields) {
		self::$newUserPass = $arFields['PASSWORD'];
	}

	public static function OnSendUserInfoHandler(&$arFields) {
		if (!self::$newUserPass === false) {
			$arFields['FIELDS']['PASSWORD'] = self::$newUserPass;
		}
		if (self::$newUserCoupon === false) 
			$arFields['FIELDS']['COUPON'] = "";
		else	
			$arFields['FIELDS']['COUPON'] = self::$newUserCoupon;
	}
	public static function OnAfterUserRegisterHandler(&$args){
		Global $USER;
		global $APPLICATION;
		if ($args["RESULT_MESSAGE"]["TYPE"] == "ERROR")
			return false;
		CModule::IncludeModule("catalog");
		$COUPON = CatalogGenerateCoupon();

		$arCouponFields = array(
			"DISCOUNT_ID" => "26",
			"ACTIVE" => "Y",
			"ONE_TIME" => "O",
			"COUPON" => $COUPON,
			"DATE_APPLY" => false
		);

		$CID = CCatalogDiscountCoupon::Add($arCouponFields);
		$CID = IntVal($CID);
		if ($CID <= 0)
		{
		   $ex = $APPLICATION->GetException();
		   $GLOBALS['APPLICATION']->ThrowException($ex->GetString()); 
		   return false;  		
		}	
		self::$newUserCoupon = "\n Вам предоставлен цифровой купон на разовую скидку в 5%. \n Ваш купон на скидку: ".$COUPON."\n Для перерасчёта стоимости Вашего заказа цифровой купон нужно ввести в поле <<купон>> в Вашей корзине и кликнуть по кнопке <<пересчитать>> \n";
		CUser::SendUserInfo($USER->GetID(), SITE_ID, GetMessage("INFO_REQ"), false);
	}
}

function OnBeforeUserRegisterHandler(&$args){
	$NEW_LOGIN = $args["EMAIL"];
	$pos = strpos($NEW_LOGIN, "@");
	if ($pos !== false)
		$NEW_LOGIN = substr($NEW_LOGIN, 0, $pos);
	if (strlen($NEW_LOGIN) > 47)
		$NEW_LOGIN = substr($NEW_LOGIN, 0, 47);
	if (strlen($NEW_LOGIN) < 3)
		$NEW_LOGIN .= "_";
	if (strlen($NEW_LOGIN) < 3)
		$NEW_LOGIN .= "_";
	
	$chkr = CheckRecaptchaGlobal();
	if (!$chkr)
	{
		$GLOBALS['APPLICATION']->ThrowException("CAPTCHA wrong"); 
		return false; 
	} 
	$password_chars = array(
						"abcdefghijklnmopqrstuvwxyz",
						"ABCDEFGHIJKLNMOPQRSTUVWXYZ",
						"0123456789",
					);
	$NEW_PASSWORD = randString(8, $password_chars);
	$args["LOGIN"] = $NEW_LOGIN;
	$args["PASSWORD"] = $NEW_PASSWORD;
	$args["CONFIRM_PASSWORD"] = $NEW_PASSWORD;
	
}

//fill list shopcity and selfdelivery
function OnSaleComponentOrderOneStepOrderPropsHandler(&$arResult, &$arUserResult, &$arParams){
	//1. Check params UF_SHOP_CITY_ORDER_PROP
	if (empty($arParams["UF_SHOP_CITY_ORDER_PROP"])){
		ShowError("necessary set parameters UF_SHOP_CITY_ORDER_PROP");
		return;
	}
	//2. Check params SELF_DELIVERY_ORDER_PROP
	if (empty($arParams["SELF_DELIVERY_ORDER_PROP"])){
		ShowError("necessary set parameters SELF_DELIVERY_ORDER_PROP");
		return;
	}

	//3. add shop city
	$arFilter = Array("IBLOCK_ID"=>$arParams["SHOPS_IBLOCK_ID"], "CODE"=>$_SESSION["UF_SHOP_CITY_NAME"]);
	$dbResultList = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "CODE", "NAME", "PROPERTY_LOCATION"));
	if ($ob = $dbResultList->GetNextElement()){
		$arr = $ob->GetFields();
	} else return;
	if (empty($arUserResult["ORDER_PROP"][$arParams["ORDER_PROP_LOCATION"]]))
		$arUserResult["ORDER_PROP"][$arParams["ORDER_PROP_LOCATION"]] = $arr["PROPERTY_LOCATION_VALUE"];
	$arUserResult["ORDER_PROP"][$arParams["UF_SHOP_CITY_ORDER_PROP"]] = $arr["ID"];
	$db_vars = CSaleOrderPropsVariant::GetByValue($arParams["UF_SHOP_CITY_ORDER_PROP"], $arr["ID"]);
	if (empty($db_vars)) {
		CSaleOrderPropsVariant::Add(array("ORDER_PROPS_ID" 	=> $arParams["UF_SHOP_CITY_ORDER_PROP"],
										  "VALUE" 			=> $arr["ID"],
										  "NAME"			=> $arr["NAME"],
										  "DESCRIPTION"		=> $arr["NAME"]));
	}
	
	//4. add self delivery place
	$arFilter = Array("IBLOCK_ID"=>$arParams["SELF_DELIVERY_PLACES_IBLOCK_ID"], "ID"=>$arUserResult["ORDER_PROP"][$arParams["SELF_DELIVERY_ORDER_PROP"]]);
	$dbResultList = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "NAME"));
	if ($ob = $dbResultList->GetNextElement()){
		$arr = $ob->GetFields();
	} else return;
	
	$db_vars = CSaleOrderPropsVariant::GetByValue($arParams["SELF_DELIVERY_ORDER_PROP"], $arr["ID"]);
	if (empty($db_vars)) {
		CSaleOrderPropsVariant::Add(array("ORDER_PROPS_ID" 	=> $arParams["SELF_DELIVERY_ORDER_PROP"],
										  "VALUE" 			=> $arr["ID"],
										  "NAME"			=> $arr["NAME"],
										  "DESCRIPTION"		=> $arr["NAME"]));
	}
}

function OnSaleComponentOrderOneStepDeliveryHandler(&$arResult, &$arUserResult, &$arParams){
	if (empty($arUserResult["ORDER_PROP"][7]))
		$arUserResult["DELIVERY_ID"] = 2;
	if (!isset($_POST["delivery"]))
		return;
	if (count($arResult["DELIVERY"]) == 1 && $_POST["delivery"] == "Y"){
		$arUserResult["DELIVERY_ID"] = $arResult["DELIVERY"][0]["ID"];
		$arDeliv = CSaleDelivery::GetByID($arUserResult["DELIVERY_ID"]);
		$arDeliv["NAME"] = htmlspecialcharsEx($arDeliv["NAME"]);
		$arResult["DELIVERY_SUM"] = $arDeliv;
		$arResult["DELIVERY_PRICE"] = roundEx(CCurrencyRates::ConvertCurrency($arDeliv["PRICE"], $arDeliv["CURRENCY"], $arResult["BASE_LANG_CURRENCY"]), SALE_VALUE_PRECISION);
	}
}


function OnOrderNewSendEmailHandler($orderID, &$eventName, &$arFields){
	$arFilter = Array("IBLOCK_ID"=>IntVal(5), "CODE"=>$_SESSION["UF_SHOP_CITY_NAME"]);	
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false);
	if($ob = $res->GetNextElement()){
		$ar = $ob->GetProperties();
		$arFields["SALE_EMAIL"] = $ar["E_MAIL"]["VALUE"];
		//$arFields["BCC"] = $ar["E_MAIL"]["VALUE"];
	}
	$dbBasketItems = CSaleBasket::GetList(
		array("NAME" => "ASC"),
		array("ORDER_ID" => $orderID),
		false,
		false,
		array("ID", "PRODUCT_ID", "NAME", "QUANTITY", "PRICE", "CURRENCY")
		);
	//Contracts info
	$order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
	$phone="";
	$index = ""; 
	$country_name = "";
	$city_name = "";  
	$address = "";
	while ($arProps = $order_props->Fetch()){
		if ($arProps["CODE"] == "PHONE"){
			$phone = htmlspecialchars($arProps["VALUE"]);
		}
		if ($arProps["CODE"] == "LOCATION"){
        $arLocs = CSaleLocation::GetByID($arProps["VALUE"]);
        $country_name =  $arLocs["COUNTRY_NAME_ORIG"];
        $city_name = $arLocs["CITY_NAME_ORIG"];
		}
		if ($arProps["CODE"] == "INDEX"){
			$index = $arProps["VALUE"];   
		}
		if ($arProps["CODE"] == "ADDRESS"){
			$address = $arProps["VALUE"];
		}
		if ($arProps["CODE"] == "SELF_DELIVERY_PLACES"){
			$self_delivery_id = $arProps["VALUE"];
		}
		if ($arProps["CODE"] == "DELIVERY_DATE"){
			$delivery_date = $arProps["VALUE"];
		}
		
	}


	if (empty($self_delivery_id)){
		$arFields["ADDRESS"] = $country_name.", ".$city_name.", ".$address.", ".$delivery_date;
	}	
	else{
		$res = CIBlockElement::GetByID($self_delivery_id);
		if($ob = $res->GetNextElement()){
			$arProps = $ob->GetProperties();
			$arFields["ADDRESS"] = "Вы забираете товар самостоятельно по адресу:".$arProps["ADDRESS"]["VALUE"].", часы работы: ".$arProps["WORK_HOURS"]["VALUE"].", контактный тел. ".$arProps["PHONE"]["VALUE"].", ".$delivery_date;
		}
	}
	$arFields["PHONE"] = $phone;
	
	//Order list
	$strOrderList = "";
	while ($arBasketItems = $dbBasketItems->Fetch()){
		$ar_res = CCatalogProduct::GetByIDEx($arBasketItems["PRODUCT_ID"]);
		$strOrderList .= $ar_res["PROPERTIES"]["ARTNUMBER"]["VALUE"].", ".$arBasketItems["NAME"]." - ".$arBasketItems["QUANTITY"]." ".$ar_res["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"].": ".SaleFormatCurrency($arBasketItems["PRICE"], $arBasketItems["CURRENCY"]);		
		$strOrderList .= "\n";
	}
	$arFields["ORDER_LIST"] = $strOrderList;
}

function OnOrderCancelSendEmailHandler($orderID, &$eventName, &$arFields){
	$arFilter = Array("IBLOCK_ID"=>IntVal(5), "CODE"=>$_SESSION["UF_SHOP_CITY_NAME"]);	
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false);
	if($ob = $res->GetNextElement()){
		$ar = $ob->GetProperties();
		$arFields["SALE_EMAIL"] = $ar["E_MAIL"]["VALUE"];
		//$arFields["BCC"] = $ar["E_MAIL"]["VALUE"];
	}
}

function OnProductUpdateHandler($ID, $arFields){
	unset($_SESSION["UF_SHOP_CITY_NAME"]);
}

function OnStartIBlockElementAddHandler(&$arFields){
	CModule::IncludeModule("catalog");
	$res = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>$arFields["IBLOCK_ID"], "CODE"=>$arFields["CODE"]), false, false, Array("ID"));
	if ($ob = $res->GetNextElement()) {
		$ar_res = $ob->GetFields();
		CIBlockElement::Delete($ar_res["ID"]);//Потенциально возможна потеря данных
	}
}

class COrderUserAuthorizeByEmail {

   public static function OrderOneStepProcess(&$arResult, &$arUserResult, &$arParams) {
		global $USER;   
		global $APPLICATION;
		
		if($USER->IsAuthorized() || $arUserResult["CONFIRM_ORDER"]==false) return;
		$sort_by = "ID";
		$sort_ord = "ASC";
		if(empty($arUserResult["USER_EMAIL"])) return;
		$arFilter = array(
			"EMAIL" => $arUserResult["USER_EMAIL"],
			"ACTIVE" => 'Y');
		$dbUsers = $USER->GetList($sort_by, $sort_ord, $arFilter);
		if ($arUser = $dbUsers->Fetch()){
			if (COrderUserAuthorizeByEmail::IsAdmin($arUser["ID"]))
				die();
			$USER->Authorize(intval($arUser["ID"]));
			$_SESSION['AUTHORIZE_EMAIL'] = true;
		}
   }

   public static function OrderOneStepFinal($ORDER_ID, &$arOrder, &$arParams) {
      global $USER;
      if ($_SESSION['AUTHORIZE_EMAIL'] === true) {
		$USER->Logout();
		$arParams['AUTHORIZE_EMAIL'] = true;
		$arOrder["USER_ID"] = IntVal($USER->GetID());
		unset($_SESSION['AUTHORIZE_EMAIL']);
      }
   }
   private function IsAdmin($id) {
		$arGroups = CUser::GetUserGroup($id);
		foreach($arGroups as $value){
			if($value=="1") return true;
		}
		return false;
	   }
}

function OnBeforeBasketUpdateAfterCheckHandler($ID, &$arFields){
	$arFields["PRICE"] = round($arFields["PRICE"]);
	$prop = array();
	if(!is_array($arFields["PROPS"])){
		$arFields["PROPS"] = array();
	}
	foreach($arFields["DISCOUNT_LIST"] as $k => $arItem){
		if (!empty($arItem["COUPON"])){
			$prop["CODE"] = $arItem["ID"];
			$prop["NAME"] = $arItem["NAME"];
			$prop["VALUE"] = $arItem["COUPON"];
			$arFields["PROPS"][]= $prop;
		}
	}
}

class CRestrictIP {
    function OnBeforeUserLoginHandler(&$arFields)
    {
        function get_ip_ws() {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip=$_SERVER['HTTP_CLIENT_IP'];
            }
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else {
                $ip=$_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }
        $ip = get_ip_ws();
		$allowed_ip = array('172.16.1.50','172.16.1.54','172.16.7.43','172.16.0.93', '172.16.0.49');
        if ( strtolower($arFields["LOGIN"]) == "admin" && (array_search($ip, $allowed_ip) === false)) {
            global $APPLICATION;
            $APPLICATION->throwException("login admin restricted by ip address");
            return false;
        }
    }
}

function SectionsByStore($arStores){
	CModule::IncludeModule("catalog");
	$arProducts = array();
	$arSections = array();
	$arIblocks = array();
	$arTopSections = array();
	$dbResultProduct = CCatalogStoreProduct::GetList(array(), array(">AMOUNT"=>0, "STORE_ID"=>$arStores),false,false, array('PRODUCT_ID'));
	while($arResultProduct = $dbResultProduct->GetNext())
	{

		$arProducts[] = $arResultProduct["PRODUCT_ID"];
	}
	if(count($arProducts)==0)
		return false;	
	$dbResultElement = CIBlockElement::GetList(array(), array("ID"=>$arProducts), false, false,array("ID","IBLOCK_ID", "NAME", "PROPERTY_CML2_LINK"));
	while($arResultElement = $dbResultElement->GetNextElement())
	{
		$arFields = $arResultElement->GetFields();
		if (empty($arFields["PROPERTY_CML2_LINK_VALUE"]))
			$ID = $arFields["ID"];
		else
			$ID = $arFields["PROPERTY_CML2_LINK_VALUE"];
		$arIblocks[] = $arFields["IBLOCK_ID"];
		$dbResultGroups = CIBlockElement::GetElementGroups($ID, true);
		while($arResultGroups = $dbResultGroups->Fetch())
		{
			$arSections[] = $arResultGroups["ID"];
		}
	}
	$arSections = array_unique($arSections);
	$arIblocks = array_unique($arIblocks);
	$dbSections = CIBlockSection::GetList(array(), array("ID"=> $arSections,"IBLOCK_ID" => $arIblocks), false, array("ID", "IBLOCK_SECTION_ID", "NAME", "CODE", "DESCRIPTION"));
	while($arSection = $dbSections->GetNext())
	{
	if (empty($arSection["IBLOCK_SECTION_ID"]))
		$arTopSections[] = $arSection["ID"];
	else
		$arTopSections[] = $arSection["IBLOCK_SECTION_ID"];
	}
	$arTopSections = array_unique($arTopSections);
	$arSections = array();
	$dbSections = CIBlockSection::GetList(array(), array("ID"=> $arTopSections, "IBLOCK_ID" => $arIblocks), false, array("ID", "NAME"));
	while($arSection = $dbSections->GetNext())
	{
		$arSections[] = $arSection;
	}
	return $arSections;
}

function OnBeforeEventSendHandler(&$arFields, $arTemplate){
	
	if ($arTemplate["EVENT_NAME"] == "SALE_STATUS_CHANGED_P"){
		$arFields["ORDER_STATUS"] = "Формируется к отправке";	
		$arFields["ORDER_DESCRIPTION"] = "Заказ формируется к отправке клиенту";
	}
	
}

function OnSaleStatusOrderHandler($ID, $val){
	CModule::IncludeModule("sale");
	if ($val == "P") {
	$arOrder = CSaleOrder::GetByID($ID);
	$arEventFields = array(
	"ORDER_ID" => $ID,
	"ORDER_STATUS" => $val,
	"ORDER_DATE" => $arOrder["DATE_INSERT"],
	"EMAIL" => "rur@alice.ru",
	"ORDER_DESCRIPTION" => $arStatus_opis,
	"SALE_EMAIL" => "rur@alice.ru",
	"TEXT" => $text,
	);

	CEvent::Send("SALE_STATUS_CHANGED_P", s1, $arEventFields);
	
	}
}	

function OnBeforeIBlockElementUpdateHandler(&$arFields)
{  // Решение проблемы выгрузки в Yandex market (меняется путь к картинке)
   // https://dev.1c-bitrix.ru/support/forum/forum26/topic57958/
   //Проверяем, нужно ли обновлять картинку.
   //Это необходимо, что бы при обмене с 1С картинки товаров, которые ранее уже были загружены, не загружались заново.
   //Иначе при повторной загрузке у картинок поменяется имя и старые картинки будут недоступны в поисковике.
   if (is_array($arFields) && isset($arFields['IBLOCK_ID']) && (int)$arFields['IBLOCK_ID']==2)
   {
	  $PRODUCT_ID = (int)$arFields['ID'];

      $res = CIBlockElement::GetByID($PRODUCT_ID);
      if($ar_res = $res->GetNext())
      {
          //Анонсная картинка
          if(isset($arFields['PREVIEW_PICTURE']) && is_array($arFields['PREVIEW_PICTURE']) && $arFields['PREVIEW_PICTURE']['name']!='' && isset($ar_res['PREVIEW_PICTURE']) && (int)$ar_res['PREVIEW_PICTURE']>0)
          {
            $rsFile = CFile::GetByID((int)$ar_res['PREVIEW_PICTURE']);
              if($arFile = $rsFile->Fetch())
              {
                 $new_file_name = $arFields['PREVIEW_PICTURE']['name'];
                 //Если имя старого файла совпадает с именем нового файла, тогда файл не обновляем
                 if($new_file_name==$arFile['ORIGINAL_NAME'])
                 {    
                       unset($arFields['PREVIEW_PICTURE']);
                 } else
					 AddMessage2Log("PREVIEW_PICTURE change".$arFields['ID'], "sale");
              }
           }

          //Детальная картинка
          if(isset($arFields['DETAIL_PICTURE']) && is_array($arFields['DETAIL_PICTURE']) && $arFields['DETAIL_PICTURE']['name']!='' && isset($ar_res['DETAIL_PICTURE']) && (int)$ar_res['DETAIL_PICTURE']>0)
          {
            $rsFile = CFile::GetByID((int)$ar_res['DETAIL_PICTURE']);
              if($arFile = $rsFile->Fetch())
              {
                 $new_file_name = $arFields['DETAIL_PICTURE']['name'];
                 //Если имя старого файла совпадает с именем нового файла, тогда файл не обновляем
                 if($new_file_name==$arFile['ORIGINAL_NAME'])
                 {					
                       unset($arFields['DETAIL_PICTURE']);
                 } else
					 AddMessage2Log("DETAIL_PICTURE change".$arFields['ID'], "sale");
              }
           }
      }
   }
}

AddEventHandler("main", "OnBeforeProlog", "OnBeforePrologHandler", 50);
AddEventHandler("catalog", "OnBeforeCatalogImport1C", "OnBeforeCatalogImport1CHandler");
//AddEventHandler("catalog", "OnSuccessCatalogImport1C", "OnSuccessCatalogImport1CHandler");

//AddEventHandler("catalog", "OnGetOptimalPrice", "OnGetOptimalPriceHandler");

AddEventHandler('main', 'OnBeforeUserAdd', array('CSendUserInfo', 'OnBeforeUserAddHandler'));
AddEventHandler("main", "OnSendUserInfo", array('CSendUserInfo', 'OnSendUserInfoHandler')); 
AddEventHandler("main", "OnAfterUserRegister", array('CSendUserInfo', 'OnAfterUserRegisterHandler'));
AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");

AddEventHandler("sale", "OnSaleComponentOrderOneStepOrderProps", "OnSaleComponentOrderOneStepOrderPropsHandler");
AddEventHandler("sale", "OnSaleComponentOrderOneStepDelivery", "OnSaleComponentOrderOneStepDeliveryHandler");
//AuthorizeByEmail if forgot password
AddEventHandler("sale", "OnSaleComponentOrderOneStepProcess", array('COrderUserAuthorizeByEmail', 'OrderOneStepProcess'));
AddEventHandler("sale", "OnSaleComponentOrderOneStepFinal", array('COrderUserAuthorizeByEmail', 'OrderOneStepFinal'));
AddEventHandler("sale", "OnBeforeBasketUpdateAfterCheck", "OnBeforeBasketUpdateAfterCheckHandler");

AddEventHandler("sale", "OnOrderNewSendEmail", "OnOrderNewSendEmailHandler");
AddEventHandler("sale", "OnOrderCancelSendEmail", "OnOrderCancelSendEmailHandler");
AddEventHandler("catalog", "OnProductUpdate", "OnProductUpdateHandler");
AddEventHandler("iblock", "OnStartIBlockElementAdd", "OnStartIBlockElementAddHandler");//check duplicate
AddEventHandler("main", "OnBeforeUserLogin", Array("CRestrictIP", "OnBeforeUserLoginHandler"));
//override order status email
AddEventHandler("main", "OnBeforeEventSend", "OnBeforeEventSendHandler");

//AddEventHandler("sale", "OnSaleStatusOrder", "OnSaleStatusOrderHandler");
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "OnBeforeIBlockElementUpdateHandler");
?>