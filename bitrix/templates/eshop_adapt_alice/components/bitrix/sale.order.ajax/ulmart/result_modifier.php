	<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	$arFilter = Array("IBLOCK_ID"=>$arParams["SHOPS_IBLOCK_ID"], "CODE"=>$arParams["SELF_DELIVERY_PLACES_SHOP_CODE"]);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "PROPERTY_PHONE", "PROPERTY_LOCATION"));
	$arResult["DELIVERY_DATE"] = getdate();
	if($ob = $res->GetNextElement())
	{
		$ar_res = $ob->GetFields();
		$ShopID = $ar_res["ID"];
		$main_phone = $ar_res["PROPERTY_PHONE_VALUE"];
		$default_location = $ar_res["PROPERTY_LOCATION_VALUE"];		
	}
	$arFilter = Array("IBLOCK_ID"=>$arParams["SELF_DELIVERY_PLACES_IBLOCK_ID"], "ACTIVE" => "Y", "PROPERTY_SHOP_CITY" => $ShopID);
	$shipping_enable = true;
	$arResult["MOVE_ALLOW"] = false;
	$arBalances = array();
	$max_delay = 0;
	//OZON CHANGES
	$packages = array();
	//OZON CHANGES

	foreach($arResult["BASKET_ITEMS"] as $k => &$arBasketItem){
		$arP = CCatalogProduct::GetByIDEx($arBasketItem["PRODUCT_ID"]);
		//OZON CHANGES
		//AddMessage2Log(print_r($arP,true), "sale");			
		$package = package($arBasketItem);
		//OZON CHANGES
		
		$arBasketItem["CML2_BASE_UNIT"] = $arP["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"];
		$res = CIBlockElement::GetList(array(), $arFilter, false, false,array("ID", "PROPERTY_STORE_ID", "PROPERTY_REMOTE_STORE_ID", "PROPERTY_OUTPOST", "PROPERTY_DELAY_STORE"));
		while($ob = $res->GetNextElement()){
			$arItem = $ob->GetFields();
			$amount = getbalance($arBasketItem["PRODUCT_ID"], $arItem["PROPERTY_STORE_ID_VALUE"]);			
			$ramount = getbalance($arBasketItem["PRODUCT_ID"], $arItem["PROPERTY_REMOTE_STORE_ID_VALUE"]);
			if (($amount < $arBasketItem["QUANTITY"]) && ($ramount >= $arBasketItem["QUANTITY"])){
				$max_delay = intval($arItem["PROPERTY_DELAY_STORE_VALUE"]);
			}	
			$arBalances[$arItem["ID"]] = $amount + $ramount;
			if($arItem["PROPERTY_OUTPOST_VALUE"] == "0") $arResult["MOVE_ALLOW"] = true;
		}
		$packages[] = $package;
	}
	
	//OZON CHANGES
	//AddMessage2Log(print_r($packages,true), "sale");			
	$arResult["PACKAGES"] = $packages;
	//echo(json_encode($arResult["PACKAGES"]));
	//OZON CHANGES
	
	$arResult["DELIVERY_DATE"] = getdate($arResult["DELIVERY_DATE"][0] + $max_delay*24*60*60);
	if ($shipping_enable == false) $arResult["MOVE_ALLOW"] = false;
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false,array("ID", "CODE", "NAME", "PROPERTY_METRO_STATION", "PROPERTY_ADDRESS", "PROPERTY_OUTPOST","PROPERTY_PHONE","PROPERTY_WORK_HOURS", "PROPERTY_LOCATION", "PROPERTY_PAYMENT_METHOD_CASH", "PROPERTY_PAYMENT_METHOD_CARD", "PROPERTY_DELIVERY_CALCULATE","PROPERTY_YANDEX_PLACE_MAP", "PROPERTY_STORE_ID"));
	$arPlaces = Array();
	while($ob = $res->GetNextElement()){
		$arItem = $ob->GetFields();
		$arItem["MAIN_PHONE"] = $main_phone;
		//calculate delivery date
		$arDate = $arResult["DELIVERY_DATE"];
		if ($arBalances[$arItem["ID"]]){//self-delivery warehouse
			if ($max_delay == 0){
				$arItem["DELIVERY_DATE_PRINT"] = "Можно забрать";
				$arItem["DELIVERY_TYPE"] = "NOW";
			} else {
				$arItem["DELIVERY_DATE_PRINT"] = FormatDate("l j F", $arDate[0]);
				$arItem["DELIVERY_TYPE"] = "DELAY";
			}
		}
		elseif ($arItem["PROPERTY_DELIVERY_CALCULATE_VALUE"]=="2" && $arResult["MOVE_ALLOW"]==true){//self-delivery office
				if ($arDate["wday"] == 5) {
					$deldate = $arDate[0]+4*24*60*60;
				} elseif ($arDate["wday"] == 6) {
					$deldate = $arDate[0]+3*24*60*60;				
				} elseif ($arDate["wday"] == 0) {
					$deldate = $arDate[0]+2*24*60*60;							
				} elseif ($arDate["wday"] == 4) {
					if ($arDate["hours"] < 14){
						$deldate = $arDate[0]+4*24*60*60;
					}else{
						$deldate = $arDate[0]+5*24*60*60;
					}
				} elseif ($arDate["wday"] == 3) {
					if ($arDate["hours"] < 14){
						$deldate = $arDate[0]+2*24*60*60;
					}else{
						$deldate = $arDate[0]+5*24*60*60;
					}
				} elseif ($arDate["wday"] == 2) {
					if ($arDate["hours"] < 14){
						$deldate = $arDate[0]+2*24*60*60;
					}else{
						$deldate = $arDate[0]+3*24*60*60;
					}
				} elseif ($arDate["wday"] == 1) {						
					if ($arDate["hours"] < 14){
						$deldate = $arDate[0]+2*24*60*60;
					}else{
						$deldate = $arDate[0]+3*24*60*60;
					}
				}
				$arItem["DELIVERY_DATE_PRINT"] = FormatDate("l j F", $deldate);
				$arItem["DELIVERY_TYPE"] = "DELAY";
		}
		elseif ($arItem["PROPERTY_DELIVERY_CALCULATE_VALUE"]=="3" && $arResult["MOVE_ALLOW"]==true){//self-delivery shops
			if (($arDate["wday"]==1 || $arDate["wday"]==3) && $arDate["hours"] < 14){
				$arItem["DELIVERY_DATE_PRINT"] = FormatDate("l j F", $arDate[0]+2*24*60*60);
			}
			else{
				if ($arDate["wday"] == 0) {
					$deldate = $arDate[0]+3*24*60*60;
				} elseif ($arDate["wday"] == 1) {
					$deldate = $arDate[0]+4*24*60*60;				
				} elseif ($arDate["wday"] == 2) {
					$deldate = $arDate[0]+2*24*60*60;							
				} elseif ($arDate["wday"] == 3) {
					$deldate = $arDate[0]+7*24*60*60;							
				} elseif ($arDate["wday"] == 4) {
					$deldate = $arDate[0]+6*24*60*60;							
				} elseif ($arDate["wday"] == 5) {			
					$deldate = $arDate[0]+5*24*60*60;				
				} elseif ($arDate["wday"] == 6) {						
					$deldate = $arDate[0]+4*24*60*60;							
				}
				$arItem["DELIVERY_DATE_PRINT"] = FormatDate("l j F", $deldate);
			}
			$arItem["DELIVERY_TYPE"] = "DELAY";
		}
		$arPlaces[] = $arItem;
	}	
	$arResult["SELF_DELIVERY_PLACES"] = $arPlaces;
	$arResult["ORDER_PROP"]["USER_PROPS"] = array();
	foreach($arResult["ORDER_PROP"]["USER_PROPS_Y"] as $k => $arItem){
		$arResult["ORDER_PROP"]["USER_PROPS"][$k] = $arItem;
	}	
	foreach($arResult["ORDER_PROP"]["USER_PROPS_N"] as $k => $arItem){
		$arResult["ORDER_PROP"]["USER_PROPS"][$k] = $arItem;
	}	

	foreach($arResult["ORDER_PROP"]["USER_PROPS"] as $k => $arItem){
		if ($arItem["TYPE"] == "LOCATION"){
			if (empty($arItem["VALUE"])){
				$arItem["VALUE"] = $default_location; 
				//set default location value
				foreach ($arItem["VARIANTS"] as $v => $arVariant){
					if ($arVariant["ID"] == $default_location){
						$arResult["ORDER_PROP"]["USER_PROPS"][$k]["VARIANTS"][$v]["SELECTED"] = "Y";
						break;
					}
				}
			}

			$arResult["FIELD_LOCATION"] = $arItem["FIELD_NAME"];
			$db_vars = CSaleLocation::GetList(
			array(
					"SORT" => "ASC",
					"COUNTRY_NAME_LANG" => "ASC",
					"CITY_NAME_LANG" => "ASC"
				),
			array("ID" => $arItem["VALUE"],"LID" => LANGUAGE_ID),
			false,
			false,
			array());
			if ($vars = $db_vars->Fetch()){
				$REGION_NAME = ($vars["REGION_NAME"])?", ":"";
				$arResult["ORDER_PROP"]["USER_PROPS"][$k]["VALUE_FORMATED"] = $vars["CITY_NAME"].$REGION_NAME.", ".$vars["COUNTRY_NAME"];
			}
		}
	}
	$arDeliveryDates = array();
	$arDate = $arResult["DELIVERY_DATE"];
	if ($arDate["hours"] >= 14){
		$deldate = $arDate[0]+24*60*60;
		$arDate = getdate($deldate);
	}
	for ($i = 1; $i <= 5; $i++) {
		if ($arDate["wday"] == 5) {
			$deldate = $arDate[0]+24*60*60;
		} elseif ($arDate["wday"] == 6) {
			$deldate = $arDate[0]+2*24*60*60;				
		} elseif ($arDate["wday"] == 0) {
			$deldate = $arDate[0]+24*60*60;							
		} elseif ($arDate["wday"] == 1) {
			$deldate = $arDate[0]+24*60*60;							
		} elseif ($arDate["wday"] == 2) {
			$deldate = $arDate[0]+24*60*60;							
		} elseif ($arDate["wday"] == 3) {			
			$deldate = $arDate[0]+24*60*60;				
		} elseif ($arDate["wday"] == 4) {						
			$deldate = $arDate[0]+24*60*60;							
		}
		$arDeliveryDates[] = FormatDate("j F, D", $deldate);
		$arDate = getdate($deldate);
	}	
	foreach($arResult["DELIVERY"] as $k => &$arDeliveryItem){
		$arDeliveryItem["DELIVERY_DATES"] = $arDeliveryDates;
		if(count($arResult["DELIVERY"])==1)
			$arResult["DELIVERY_ID"] = $arDeliveryItem["ID"];
	}
	if(count($arResult["DELIVERY"])==1){
		$arResult["DELIVERY"][0]["CHECKED"] = "Y";
		$firstelement = reset($arResult["DELIVERY"]);
		$arResult["DELIVERY_ID"] = $firstelement["ID"];
	}

	$arResult["DELIVERY_DATES"] = $arDeliveryDates;
	
	
	unset($arResult["DELIVERY_STEP"]);
	if($_REQUEST["is_ajax_post"] == "Y" && $_REQUEST["del_step_1"]=="Y")
		$arResult["DELIVERY_STEP"] = 1;	
	if($_REQUEST["is_ajax_post"] == "Y" && $_REQUEST["del_step_2"]=="Y"){
		if (count($arResult["USER_VALS"]["DELIVERY"])==1)
			$arResult["DELIVERY_STEP"] = 3;
		else
			$arResult["DELIVERY_STEP"] = 2;		
		}
	if($_REQUEST["is_ajax_post"] == "Y" && $_REQUEST["del_step_3"]=="Y")
		$arResult["DELIVERY_STEP"] = 3;	


	function getbalance($productid, $arStores){
		if (count($arStores) == 0)
			return 0;
		$rsProps = CCatalogStoreProduct::GetList(array(), array("STORE_ID"=>$arStores, "PRODUCT_ID"=>$productid), false, false, array("AMOUNT"));
		$AMOUNT = 0;
		while ($arProp = $rsProps->GetNext()){
			$AMOUNT += $arProp["AMOUNT"];
		}
		return $AMOUNT;
	}
	function Thickness($productid){
		//1. элемент каталога
		$mxResult = CCatalogSku::GetProductInfo($productid);
		if (is_array($mxResult)) {
			$PRODUCT_ID = $mxResult['ID']; // ID товара родителя
		} else {
			$PRODUCT_ID = $ElementID; // если не нашло, запишет ID торгового предложения
		}
		//2. Свойство THICKNESS
		$rsIBlockElement = CIBlockElement::GetList(array(),array('ID' => $PRODUCT_ID),false,false,Array("ID","ACTIVE","PROPERTY_THICKNESS"));
		while ($arIBlockElement = $rsIBlockElement->GetNextElement()){
			$arIBlockFields = $arIBlockElement->GetFields();	
			return (double)$arIBlockFields["PROPERTY_THICKNESS_VALUE"];
		}	
	}
	
	function package($arBasketItem){
		$package = array();
		$arProduct = CCatalogProduct::GetByIDEx($arBasketItem["PRODUCT_ID"]);
		
		$quantity = (double)$arBasketItem["QUANTITY"];
		$weight = (int)$arBasketItem["WEIGHT"];
		
		$length = (double)$arProduct["PROPERTIES"]["LENGTH"]["VALUE"];
		$width = (double)$arProduct["PROPERTIES"]["WIDTH"]["VALUE"];		
		$thickness = Thickness($arBasketItem["PRODUCT_ID"]);
		if ($arProduct["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"] == "055")
			$length = $quantity/$width;
		//Длина упаковки равна ширине ковра или куска – то есть наименьшая сторона 
		if ($length > $width){
			$package_length = $width;
			$package_width = $length;
		} else {
			$package_length = $length;
			$package_width = $width;
		}
		//SQRT(Длина (наибольшая сторона ковра или куска в мм) *Толщина (в мм) *1,1/3,14)*2		
		$package_height = ceil(sqrt($package_width*1000*$thickness*1.1/3.14)*2); 
		$package_width = $package_height;
		$package[] = $weight*$quantity;//вес
		$package[] = (int)$package_width;//ширина
		$package[] = (int)$package_height;//высота
		$package[] = $package_length*1000;//длина
		return $package;
	}
	function volume_weight($package){
		//Объемный вес в кг
		return max($package[1]*$package[2]*$package[3]/1000/1000/5, $package[0]/1000);
	}
	function delivery_price($package, $price=118){
		$volume_weight = volume_weight($package);
		if ($volume_weight >= 5)
			return 1.2*($price-ceil($price*20/120)+(ceil($volume_weight-5))*15);
		else return $price;	
	}
?>