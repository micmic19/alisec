<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
function PrintPropsForm($arSource=Array(), $locationTemplate = ".default", $ReadOnly=false, $button="", $step="", $filter=array())
{
	if (!empty($arSource))
	{
		foreach($arSource as $arProperties)
		{
			if(count($filter)>0){
				if(!in_array($arProperties["ID"], $filter)){
					continue;
				}
			}
		
			?>
			<tr>
				<td>
					<div class="name">
						<?= $arProperties["NAME"] ?>:<?
						if($arProperties["REQUIED_FORMATED"]=="Y")
						{
							?><span class="sof-req">*</span><?
						}
						?>
					</div>
				
					<?
					if($arProperties["TYPE"] == "CHECKBOX")
					{
						?>

						<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">
						<input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>>
						<?
					}
					elseif($arProperties["TYPE"] == "TEXT")
					{
						?>
						<?if($ReadOlnly):?>
						<span><?=$arProperties["VALUE"]?></span>
						<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="<?=$arProperties["VALUE"]?>" />
						<?else:?>
						<input type="text" maxlength="250" onkeyup="CheckFieldsFill('<?=$button?>', '<?=$step?>')" size="<?=$arProperties["SIZE1"]?>" value="<?=$arProperties["VALUE"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>">						
						<?endif?>
						<?
					}
					elseif($arProperties["TYPE"] == "SELECT")
					{
						?>
						<select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
						<?
						foreach($arProperties["VARIANTS"] as $arVariants)
						{
							?>
							<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
							<?
						}
						?>
						</select>
						<?
					}
					elseif ($arProperties["TYPE"] == "MULTISELECT")
					{
						?>
						<select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
						<?
						foreach($arProperties["VARIANTS"] as $arVariants)
						{
							?>
							<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
							<?
						}
						?>
						</select>
						<?
					}
					elseif ($arProperties["TYPE"] == "TEXTAREA")
					{
						if($ReadOnly){?>
						<span><?=$arProperties["VALUE"]?></span>
						<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="<?=$arProperties["VALUE"]?>" />						
						<?}else{?>
						<textarea rows="<?=$arProperties["SIZE2"]?>" cols="<?=$arProperties["SIZE1"]?>" onkeyup="CheckFieldsFill('<?=$button?>', '<?=$step?>')" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>
						<?}
					}
					elseif ($arProperties["TYPE"] == "LOCATION")
					{
						if($ReadOnly){?>
						<span><?=$arProperties["VALUE_FORMATED"]?></span>
						<input type="hidden" name="<?echo $arProperties["FIELD_NAME"]?>" id="<?echo $arProperties["FIELD_NAME"]?>" value="<?=$arProperties["VALUE"]?>">
						<?}else{
						$value = 0;
						if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
						{
							foreach ($arProperties["VARIANTS"] as $arVariant)
							{
								if ($arVariant["SELECTED"] == "Y")
								{
									$value = $arVariant["ID"];
									break;
								}
							}
						}

						$GLOBALS["APPLICATION"]->IncludeComponent(
							"bitrix:sale.ajax.locations",
							$locationTemplate,
							array(
								"AJAX_CALL" => "N",
								"COUNTRY_INPUT_NAME" => "COUNTRY",
								"REGION_INPUT_NAME" => "REGION",
								"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
								"CITY_OUT_LOCATION" => "Y",
								"LOCATION_VALUE" => $value,
								"ORDER_PROPS_ID" => $arProperties["ID"],
								"ONCITYCHANGE" => "CheckFieldsFill('".$button."','".$step."')",
								"SIZE1" => $arProperties["SIZE1"], 
							),
							null,
							array('HIDE_ICONS' => 'Y')
						);
						}
					}
					elseif ($arProperties["TYPE"] == "RADIO")
					{
						foreach($arProperties["VARIANTS"] as $arVariants)
						{
							?>
							<input type="radio" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>" value="<?=$arVariants["VALUE"]?>"<?if($arVariants["CHECKED"] == "Y") echo " checked";?>> <label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"><?=$arVariants["NAME"]?></label><br />
							<?
						}
					}

					if (strlen($arProperties["DESCRIPTION"]) > 0)
					{
						?><div class="desc"><?echo $arProperties["DESCRIPTION"] ?></div><?
					}
					?>
				</td>
			</tr>
			<?
		}
		?>
		<?
		return true;
	}
	return false;
}

function CheckFillFields($arSource=Array(), $filter=array()){
	if (count($filter)==0)
		return true;
	$result = true;	
	foreach($arSource as $arProperties)
	{
		if(in_array($arProperties["ID"], $filter)){
			if ($arProperties["VALUE"]==""){
				return false;
			}
		}
	}
	return $result;
}	
?>
