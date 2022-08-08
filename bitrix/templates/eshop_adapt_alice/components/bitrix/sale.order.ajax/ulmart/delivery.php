<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div id="del-content-step2" class="section"> 
<input type="hidden" name="BUYER_STORE" id="BUYER_STORE" value="<?=$arResult["BUYER_STORE"]?>" />
<?
if(!empty($arResult["DELIVERY"]))
{
	?>
	<table class="sale_order_table delivery">
		<?
		foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery)
		{
			if ($arDelivery["CHECKED"]!="Y"){
			?>
			
			<tr>
				<td class="prop" colspan="2">
					<div>
						<input type="radio" onclick="selectdelivery();" id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>" name="<?=$arDelivery["FIELD_NAME"]?>" value="<?= $arDelivery["ID"] ?>"<?if ($arDelivery["CHECKED"]=="Y") echo " checked";?>>
						<label for="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>" <?=(count($arDelivery["STORE"]) > 0)? 'onClick="fShowStore(\''.$arDelivery["ID"].'\');"':"";?> >
							<div class="desc">
								<div class="name"><?= $arDelivery["NAME"] ?></div>
									<div>
									<?
									if (strlen($arDelivery["PERIOD_TEXT"])>0)
									{
										echo $arDelivery["PERIOD_TEXT"];
										?><br /><?
									}
									?>
									</div>
									<div><?=GetMessage("SALE_DELIV_PRICE");?> <?=$arDelivery["PRICE_FORMATED"]?></div>
									<?if (count($arDelivery["STORE"]) > 0):?>
										<span id="select_store"<?if(strlen($arResult["STORE_LIST"][$arResult["BUYER_STORE"]]["TITLE"]) <= 0) echo " style=\"display:none;\"";?>>
											<span class="select_store"><?=GetMessage('SOA_ORDER_GIVE_TITLE');?>: </span>
											<span class="ora-store" id="store_desc"><?=htmlspecialcharsbx($arResult["STORE_LIST"][$arResult["BUYER_STORE"]]["TITLE"])?></span>
										</span>
									<?endif;?>
								<?if(strlen($arDelivery["DESCRIPTION"]) > 0):?>
									<div><?=$arDelivery["DESCRIPTION"]?></div>
								<?endif;?>
								</div>
						</label>
						<div class="clear"></div>
					</div>
				</td>
			</tr>
			
			<?
			}else{
				if ($arDelivery["CHECKED"]=="Y"){
				?>
					<tr>
					  <td>	
						<input type="hidden" ID="<?=$arDelivery["FIELD_NAME"]?>" name="<?=$arDelivery["FIELD_NAME"]?>" value="<?=$arDelivery["ID"]?>"/>
						<?=$arDelivery["NAME"]?><b><?=GetMessage("SALE_DELIV_PRICE");?> <?=$arDelivery["PRICE_FORMATED"]?></b>
					  </td>
					</tr>  
					<tr>
						<td><?=$arDelivery["DESCRIPTION"]?></td>
					</tr>
				<?
				}
			}
		}
		?>
		<tr>
			<td>
				<?if($arResult["DELIVERY_STEP"]==2):?>
				<div class="b-group-buttons">
					<ul>
					<?foreach ($arResult["DELIVERY_DATES"] as $key => $arDeliveryDate):?>
						<li>
							<input type="radio" value="<?=$arDeliveryDate?>" id="ORDER_PROP_<?=$arParams["DELIVERY_ORDER_PROP_DELIVERY_DATE"]?>_<?=$key?>" name="ORDER_PROP_<?=$arParams["DELIVERY_ORDER_PROP_DELIVERY_DATE"]?>" <?if($key==0 || $arResult["ORDER_PROP"]["USER_PROPS"][$arParams["DELIVERY_ORDER_PROP_DELIVERY_DATE"]]["VALUE"]==$arDeliveryDate):?> checked="checked" <?endif;?>>
							<label for="ORDER_PROP_<?=$arParams["DELIVERY_ORDER_PROP_DELIVERY_DATE"]?>_<?=$key?>">
							<?=$arDeliveryDate?>
							</label>
						</li>
					<?endforeach;?>
				</div>
				<?else:?>
						<input type="hidden" ID="ORDER_PROP_<?=$arParams["DELIVERY_ORDER_PROP_DELIVERY_DATE"]?>" name="ORDER_PROP_<?=$arParams["DELIVERY_ORDER_PROP_DELIVERY_DATE"]?>" value="<?=$arResult["ORDER_PROP"]["USER_PROPS"][$arParams["DELIVERY_ORDER_PROP_DELIVERY_DATE"]]["VALUE"]?>"/>
						Предпочтительная дата доставки: <b><?=$arResult["ORDER_PROP"]["USER_PROPS"][$arParams["DELIVERY_ORDER_PROP_DELIVERY_DATE"]]["VALUE"]?></b>
				<?endif;?>
			</td>
		</tr>
	</table>
	 <?if($arResult["DELIVERY_STEP"]==2):?>
		<div class="bt3-wrapper"><a id="b-go-personaltep" href="#" class="bt3 <?if (empty($arResult["DELIVERY_ID"])) echo "disabled"?>" onclick="gopersonaldatastep()">Продолжить</a></div>	
    <?endif?>
	<?
}else{
?>
		<div class="b-box-delivery _bad">
			<h4>
				К сожалению мы не можем доставить ваш заказ.
			</h4>
			<p>возможно забрать товар самостоятельно в одном из наших оутпостов</p>
		</div>

<?
}
?>

</div>
