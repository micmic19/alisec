<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
	$strDispNone = " style='display: none;'";
	$itemsCount = count($arResult["ITEMS"]);
	$strDataItems = "";
	switch ($itemsCount) {
		case 1: 
			$strDataItems = "1,1,1,1";
			break;
		case 2:
			$strDataItems = "1,2,2,2";
			break;
		case 3:
			$strDataItems = "1,2,3,3";
			break;
		default:
			$strDataItems = "1,2,4,4";
	}
?>
<script type="text/javascript">
	var slidesCount=<?=json_encode($itemsCount)?>;
</script>
<div class="container carousel"<? if($itemsCount==0)echo $strDispNone; ?>>
	<div class="row">
		<div class="MultiCarousel" data-items=<?echo $strDataItems; ?> data-slide="1" id="MultiCarousel"  data-interval="10000">
            <div class="MultiCarousel-inner">

                <?foreach($arResult["ITEMS"] as $arItem):?>
					<?if(is_array($arItem["PREVIEW_PICTURE"])):?>
						<?
							$strTitle = (
							isset($arItem["PREVIEW_PICTURE"]["DESCRIPTION"]) && '' != isset($arItem["PREVIEW_PICTURE"]["DESCRIPTION"])
							? $arItem["PREVIEW_PICTURE"]["DESCRIPTION"]
							: $arItem['NAME']
							);
    	            	?>
                        <div class="item">
							<div class="pad15">
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<? echo $strTitle; ?>">
									<img class="block img-responsive" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>">
								</a>	
							</div>
						  </div>
						 <?endif;?> 
					<?endforeach;?>
            </div>
            <button class="btn btn-info leftLst"><</button>
            <button class="btn btn-info rightLst">></button>
        </div>
	</div>
</div>
