<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$ShopCode = $_SESSION["UF_SHOP_CITY_NAME"];
$arFilter = Array("IBLOCK_ID"=>IntVal(5), "CODE"=>$ShopCode);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false);
if($ob = $res->GetNextElement()){
	$arFields = $ob->GetFields();
	$arProps = $ob->GetProperties();
}
$arFilter = Array("IBLOCK_ID"=>IntVal(6), "PROPERTY_SHOP_CITY"=>$arFields["ID"], "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, array("ID","NAME","PROPERTY_METRO_STATION", "PROPERTY_ADDRESS", "PROPERTY_STORE_ID", "PROPERTY_PHONE","PROPERTY_WORK_HOURS","PROPERTY_YANDEX_PLACE_MAP_INTERACT","PROPERTY_YANDEX_PLACE_MAP","PROPERTY_MORE_PHOTO"));
?>
<span><?=$arProps["PHONE"]["VALUE"]?><br><?=$arProps["PHONE_GLOBAL"]["VALUE"]?></span>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>