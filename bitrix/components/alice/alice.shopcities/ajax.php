<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if(!CModule::IncludeModule("iblock")){
	return;
}

global $APPLICATION;
if (!empty($_POST["cityid"])){
	$UF_SHOP_CITY_NAME = trim($_POST["cityid"]);
	$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>$UF_SHOP_CITY_NAME);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "CODE", "NAME"));
	if($ob = $res->GetNextElement()){
		$_SESSION["UF_SHOP_CITY_NAME"] = $UF_SHOP_CITY_NAME;
		$APPLICATION->set_cookie("UF_SHOP_CITY_NAME", $_SESSION["UF_SHOP_CITY_NAME"], time() + 60 * 60 * 24);
		$arResult = $ob->GetFields();
		echo "<b>".$arResult["NAME"]."</b>";
		unset($_SESSION["jivo_chat_widget_expand"]);		
	}
}
if (!empty($_POST["jivo_chat_widget_expand"])){
	$_SESSION["jivo_chat_widget_expand"] = $_POST["jivo_chat_widget_expand"];
}
require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_after.php");
?>