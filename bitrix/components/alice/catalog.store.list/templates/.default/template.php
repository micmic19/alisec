<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(strlen($arResult["ERROR_MESSAGE"])>0)
	ShowError($arResult["ERROR_MESSAGE"]);
?>

<div id="tab-self-delivery" class="selected">
	<div class="selected">
		<h4>Быстрее - центральный склад</h4>
		<div class="point-self-delivery">				
			<ul>
			<?foreach($arResult["SELF_DELIVERY_PLACES"] as $arItem):?>
				<?if ($arItem["PROPERTY_OUTPOST_VALUE"]=="0"):?>						
					<li>
						<span class="b-point-short">
							<a href="<?=$arItem["URL"]?>">						
								<i class="b-ico-letter">м</i>
								<span class="b-pseudolink"><?=$arItem["PROPERTY_METRO_STATION_VALUE"]?></span>
								<span><?=$arItem["PROPERTY_ADDRESS_VALUE"]?></span>
							</a>							
						</span>
						<span class="payment-method"><?if($arItem["PROPERTY_PAYMENT_METHOD_CASH_VALUE"]=="1"):?><i class="b-ico coin"></i>наличные<?endif;?><?if($arItem["PROPERTY_PAYMENT_METHOD_CARD_VALUE"]=="1"):?><i class="b-ico card"></i>карта<?endif;?></span>
					</li>
				<?endif?>						
			<?endforeach;?>						
			</ul>				
		</div>
		<h4>Удобнее — пункты выдачи «Элис Пост»</h4>
		<div class="point-self-delivery">
			<ul>
			<?foreach($arResult["SELF_DELIVERY_PLACES"] as $arItem):?>					
				<?if ($arItem["PROPERTY_OUTPOST_VALUE"]=="1"):?>						
					<li>
						<span class="b-point-short">
							<a href="<?=$arItem["URL"]?>">						
								<i class="b-ico-letter">м</i>
								<span class="b-pseudolink"><?=$arItem["PROPERTY_METRO_STATION_VALUE"]?></span>
								<span><?=$arItem["PROPERTY_ADDRESS_VALUE"]?></span>
							</a>																			
						</span>
						<span class="payment-method"><?if($arItem["PROPERTY_PAYMENT_METHOD_CASH_VALUE"]=="1"):?><i class="b-ico coin"></i>наличные<?endif;?><?if($arItem["PROPERTY_PAYMENT_METHOD_CARD_VALUE"]=="1"):?><i class="b-ico card"></i>карта<?endif;?></span>
					</li>
				<?endif?>						
			<?endforeach;?>												
			</ul>				
		</div>	
	</div>
</div>	