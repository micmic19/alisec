<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Магазины и пункты выдачи");
//if ($_SESSION["UF_SHOP_CITY_NAME"] == "shop.alice.ru" && SITE_ID == "s1")
//	$ShopCode = "shop77.alice.ru";
//else
$ShopCode = $_SESSION["UF_SHOP_CITY_NAME"];

$arFilter = Array("IBLOCK_ID"=>IntVal(5), "CODE"=>$ShopCode);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false);
if($ob = $res->GetNextElement()){
	$arFields = $ob->GetFields();
	$arProps = $ob->GetProperties();
}
$arFilter = Array("IBLOCK_ID"=>IntVal(6), "PROPERTY_SHOP_CITY"=>$arFields["ID"], "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, array("ID","NAME","PROPERTY_METRO_STATION", "PROPERTY_ADDRESS", "PROPERTY_STORE_ID", "PROPERTY_PHONE","PROPERTY_WORK_HOURS","PROPERTY_YANDEX_PLACE_MAP_INTERACT","PROPERTY_YANDEX_PLACE_MAP","PROPERTY_MORE_PHOTO","PROPERTY_E_MAIL"));
?>
<?
while($ob = $res->GetNextElement())
{
$arFields = $ob->GetFields();
?>
<div class="row">
	<div class="col-xs-12 col-md-4">
		<p style="font-size: large;"><a href="/store/<?=$arFields["ID"]?>"><?=$arFields["NAME"]?></a></br>
		<b class="hidden-xs">Телефон:</b><a href="tel:<?=$arFields["PROPERTY_PHONE_VALUE"]?>"><?=$arFields["PROPERTY_PHONE_VALUE"]?></a></br>
		<?if($arFields["PROPERTY_E_MAIL_VALUE"]){?>
		<b>email:</b><a href="mailto:<?=$arFields["PROPERTY_E_MAIL_VALUE"]?>"><?=$arFields["PROPERTY_E_MAIL_VALUE"]?></a></br>
		<?}?>
		<b>Ближайшая станция:</b><?=$arFields["PROPERTY_METRO_STATION_VALUE"]?></br>
		<b>Адрес:</b><?=$arFields["PROPERTY_ADDRESS_VALUE"]?></br>
		<b>Часы работы:</b><?=$arFields["PROPERTY_WORK_HOURS_VALUE"]?></br>
		<b>Ассортимент товаров:</b></br>
		
<?
		$arSections = SectionsByStore($arFields["PROPERTY_STORE_ID_VALUE"]);
		$str = "";
		foreach($arSections as $arSection){
			$str = $str.$arSection["NAME"].", ";
		}
		$str = substr($str,0,strlen($str) - 2);
?>
		<?=$str?>
		</p>		
	</div>
	<div class="col-xs-12 col-md-8">	
		<div class="row">	
<?		foreach($arFields["PROPERTY_MORE_PHOTO_VALUE"] as $pict){
			$arPict = CFile::GetFileArray($pict);?>
		<div class="col-xs-6 col-md-3">
			<a title="<?=$arPict["DESCRIPTION"]?>" href="<?=$arPict["SRC"]?>" target="_blank"><img style="padding:5px 0;" src="<?=$arPict["SRC"]?>" alt="<?=$arPict["DESCRIPTION"]?>"></a>
		</div>		
<?		}?>	
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="hidden-xs"><?=$arFields["~PROPERTY_YANDEX_PLACE_MAP_INTERACT_VALUE"]?></div>
				<div class="hidden-sm hidden-md hidden-lg"><?=$arFields["~PROPERTY_YANDEX_PLACE_MAP_VALUE"]?></div>
				</br>
			</div>
		</div>
	</div>	
</div>
<?
}	

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>