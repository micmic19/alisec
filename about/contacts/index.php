<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
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
<div class="hidden-lg hidden-md">
	<div class="opt-enter">
		<a href="http://www.alice.ru/opt/contacts.aspx" target="_blank">ДЛЯ ОПТОВЫХ ПОКУПАТЕЛЕЙ</a>
	</div>
	</br>
</div>
<b>Телефон:</b>
<a href="tel:<?=$arProps["PHONE"]["VALUE"]?>"><?=$arProps["PHONE"]["VALUE"]?></a>,
<a href="tel:<?=$arProps["PHONE_GLOBAL"]["VALUE"]?>"><?=$arProps["PHONE_GLOBAL"]["VALUE"]?></a>
</br>
<b>email:</b>
<a href="mailto:processing@alice.ru">processing@alice.ru</a>
<h3>Наши реквизиты</h3>
<div class="row">
	<div class="col-xs-12">
		<p><?=$arProps["LEGAL_ADDRESS"]["VALUE"]?></p>
	</div>
</div>
<h3>Магазины и пункты выдачи</h3>
<?
while($ob = $res->GetNextElement())
{
$arFields = $ob->GetFields();
?>
<div class="row">
	<div class="col-xs-12 col-md-4">
		<p><a href="/store/<?=$arFields["ID"]?>"><?=$arFields["NAME"]?></a></br>
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
	
<?		foreach($arFields["PROPERTY_MORE_PHOTO_VALUE"] as $pict){
			$arPict = CFile::GetFileArray($pict);
?>
		<div class="col-xs-6 col-md-2">
			<a class="popimg" title="<?=$arPict["DESCRIPTION"]?>" href="<?=$arPict["SRC"]?>" target="_blank"><img style="padding:5px 0;" src="<?=$arPict["SRC"]?>" alt="<?=$arPict["DESCRIPTION"]?>"></a>
		</div>		
<?
		}
?>	

</div>
<div class="row">
	<div class="col-xs-12">
		<div class="hidden-xs"><?=$arFields["~PROPERTY_YANDEX_PLACE_MAP_INTERACT_VALUE"]?></div>
		<div class="hidden-sm hidden-md hidden-lg"><?=$arFields["~PROPERTY_YANDEX_PLACE_MAP_VALUE"]?></div>
		</br>
	</div>
</div>
<?
}	

?>

<script>
$(document).ready(function() {
	$(".popimg").fancybox({
	  openEffect	: 'elastic',
	  closeEffect	: 'elastic',
	  helpers : {
	  title : {
	  type : 'inside'
		   }
		}
   });
   });
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>