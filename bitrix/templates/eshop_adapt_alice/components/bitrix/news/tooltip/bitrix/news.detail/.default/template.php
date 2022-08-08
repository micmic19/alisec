<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="context-help">
    <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
    <h2><?=$arResult["NAME"]?></h2>
    <?endif;?>
    <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
    <div class="date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div><br>
    <?endif;?>
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
	<?endif?>
 	<?if($arResult["DISPLAY_PREVIEW_TEXT"] == "Y"):?>
		<?
		$APPLICATION->RestartBuffer();
		echo $arResult["PREVIEW_TEXT"];
		die();
		?>
 	<?else:?>
		<?echo $arResult["DETAIL_TEXT"];?>
	<?endif?>
</div>