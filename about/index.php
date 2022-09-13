<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О компании");

$arFilter = Array("IBLOCK_ID"=>IntVal(5), "CODE"=>$_SESSION["UF_SHOP_CITY_NAME"]);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "PROPERTY_E_MAIL"));
if($ob = $res->GetNextElement())
	$arShop = $ob->GetFields();
//disabled by email nizov 23.04.2018
$arFilter = Array("IBLOCK_ID"=>IntVal(6000000000), "PROPERTY_SHOP_CITY"=>$arShop["ID"], "PROPERTY_OUTPOST"=>1);
$res = CIBlockElement::GetList(Array("sort"=>"asc"), $arFilter, false, false, array("ID","NAME","PROPERTY_METRO_STATION", "PROPERTY_ADDRESS", "PROPERTY_PHONE","PROPERTY_WORK_HOURS","PROPERTY_HOW_REACH"));
function textquantity($value){
	switch ($value) {
		case 3:
			return "три";
		case 4:
			return "четыре";
		case 5:
			return "пять";
		case 6:
			return "шесть";
		}
}
?><div class="row">
	<div class="col-xs-12">
		<h4>О компании "Элис"</h4>
		<?if($res->SelectedRowsCount()>0):?><h5 class="hidden-xs">Сегодня в Петербурге для Вас работают <?=textquantity($res->SelectedRowsCount())?> магазинов оптовой компании Элис.</h5><?endif;?>
<?
while($ob = $res->GetNextElement())
{
$arFields = $ob->GetFields();
?>
<div class="row">
	<div class="col-xs-12">
		<p><a href="/store/<?=$arFields["ID"]?>"><?=$arFields["NAME"]?></a></br>
		<b>Телефон:</b><a href="tel:<?=$arFields["PROPERTY_PHONE_VALUE"]?>"><?=$arFields["PROPERTY_PHONE_VALUE"]?></a></br>
		<span class="hidden-xs"><b>Ближайшая станция:</b><?=$arFields["PROPERTY_METRO_STATION_VALUE"]?></span>
		<span class="hidden-xs"><?=$arFields["PROPERTY_HOW_REACH_VALUE"]?></span>
		<span class="hidden-xs"><b>Адрес:</b><?=$arFields["PROPERTY_ADDRESS_VALUE"]?></span></p>
	</div>
</div>
<?
}	

?>

		
		<p class="hidden-xs">Наша компания известна на рынке отделочных материалов с 1996 г. Начав свою деятельность с оптовых поставок ковровых покрытий, сейчас она является одним из ведущих оптовых поставщиков напольных покрытий и ковровых изделий в России. Головная организация находится в Санкт-Петербурге, а отделения в Москве, Самаре, Новосибирске и Пятигорске.</p>
		<p class="hidden-xs">У нас сложились крепкие партнерские отношения с ведущими производителями, позволяющие предлагать высококачественную продукцию по конкурентоспособным ценам. В широком выборе напольные покрытия как для дома, так и для офиса и производственных помещений.</p>
 
		<p class="hidden-xs">Мы можем гордиться тем, что у нас один из самых широких ассортиментов ковров и напольных покрытий в Санкт-Петербурге и области.</p>

		<h2>На нашем сайте для Вас:</h2>
		<div class="row">
			<div class="col-xs-12">
				<ul class="bxe-list bxe-lis-blue">
					<li><i class="fa fa-check"></i> <span style="font-size:13px;">актуальные и выгодные цены</span></li>
					<li><i class="fa fa-check"></i> <span style="font-size:13px;">широчайший ассортимент</span></li>
					<li><i class="fa fa-check"></i> <span style="font-size:13px;">описание и качественное изображение товаров</span></li>
					<li><i class="fa fa-check"></i> <span style="font-size:13px;">удобный поиск товаров по параметрам</span></li>
					<li><i class="fa fa-check"></i> <span style="font-size:13px;">система обратной связи</span></li>
					<li><i class="fa fa-check"></i> <span style="font-size:13px;">покупка товара, не выходя из дома или офиса</span></li>
					<li><i class="fa fa-check"></i> <span style="font-size:13px;">быстрое согласование товара для подтверждения заказа</span></li>
					<li><i class="fa fa-check"></i> <span style="font-size:13px;">обмен товаров ненадлежащего качества и многое другое.</span></li>
					</ul>
			</div>
		</div>
		<br/>
		<p>Мы всегда рады общению с нашими покупателями. Если у вас есть какие-либо пожелания, предложения, замечания, касающиеся работы нашего Интернет-магазина - пишите нам, и мы с благодарностью примем ваше мнение во внимание:</p>
		<p><b>Электронная почта</b>: <a href="mailto:<?=$arShop["PROPERTY_E_MAIL_VALUE"]?>" ><?=$arShop["PROPERTY_E_MAIL_VALUE"]?></a></p>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>