<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	$iCounter=0;
	$arrCounter=0;
?>

<?$this->SetViewTarget("city_meta");?>
<?if (empty($arResult["UF_SHOP_CITY"])):?>
	<a></a>	
<?else:?>	
	<?echo $arResult["UF_SHOP_CITY"]["~PROPERTY_GEO_META_TAG_VALUE"];?>
<?endif?>	
<?$this->EndViewTarget("city_meta");?>


<?$this->SetViewTarget("city_brandzone");?>
<div class="col-lg-6 col-md-6 hidden-sm hidden-xs">
	<?if (is_array($arResult["UF_SHOP_CITY"]["PREVIEW_PICTURE"])):?>
		<a href="/store/87972">
		<img ID="sitelogoimg" src="<?=$arResult["UF_SHOP_CITY"]["PREVIEW_PICTURE"]["SRC"]?>">
		</a>
	<?endif?>	
</div>
<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
	<?if (empty($arResult["UF_SHOP_CITY"])):?>
		<a class="callme"><b><?=iconv("windows-1251", "utf-8", "");?></b></a>	
	<?else:?>	
		<a href="/about/contacts/">
			<span class="callme" itemprop="telephone"><?=$arResult["UF_SHOP_CITY"]["PROPERTY_PHONE_VALUE"];?></span></br>
			<span class="callme" itemprop="telephone"><?=$arResult["UF_SHOP_CITY"]["PROPERTY_PHONE_GLOBAL_VALUE"];?></span>			
		</a>
		<span class="workhours"><?=$arResult["UF_SHOP_CITY"]["~PROPERTY_SCHEDULE_VALUE"]["TEXT"];?></span>
	<?endif?>
</div>
<?$this->EndViewTarget("city_brandzone");?>

<?$this->SetViewTarget("city_brandzone_mobile");?>
	<?if (!empty($arResult["UF_SHOP_CITY"])):?>
		<a class="callme" href="tel:<?=$arResult["UF_SHOP_CITY"]["PROPERTY_PHONE_VALUE"];?>"><?//=$arResult["UF_SHOP_CITY"]["NAME"];?></a>
	<?endif?>
<?$this->EndViewTarget("city_brandzone_mobile");?>

<?$this->SetViewTarget("city_selector");?>
<div class="header_city_selector">
	<?if (empty($arResult["UF_SHOP_CITY"])):?>
		<a class="selected"><b>Пожалуйста выберите город</b></a>	
	<?else:?>	
		<a class="selected"><?=$arResult["UF_SHOP_CITY"]["NAME"];?></a>	
	<?endif?>
</div>
  <div class="default_popup choose_city_popup" style="display: none;">
    <a href="#" class="close"></a>
    <div class="hd">Какой «Элис» вас интересует?</div>
		<h4 style="padding-bottom:10px;color:gray;">Ассортимент и наличие товара меняется в зависимости от выбранного города.</br>Цены во всех городах одинаковые.</h4>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?if ($iCounter==0):?>
		<div class="top_cities">
		<ul>
			<?endif?>
			<?if ($arItem["ID"]==$arResult["UF_SHOP_CITY"]["ID"]):?>
			<li><b><?=$arItem["NAME"];?></b></li>
			<?else:?>
			<li><a class="region_link" rel=<?=$arItem["CODE"];?> compath=<?=$componentPath?> href="#"><?=$arItem["NAME"];?></a></li>
			<?endif?>
			<?$iCounter++;$arrCounter++?>
			<?if ($iCounter==$arResult["DIV_ROW_QUANTITY"] || count($arResult["ITEMS"])==$arrCounter):?>
		</ul>
		</div>
				<?$iCounter=0;?>
			<?endif?>
		<?endforeach;?>
  </div>
<?$this->EndViewTarget("city_selector");?>
