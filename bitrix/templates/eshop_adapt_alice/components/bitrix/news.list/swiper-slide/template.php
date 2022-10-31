<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
	$strDispNoneArt = " style='display: none;'";
	$itemsCountArt = count($arResult["ITEMS"]);
	$this->addExternalCss("//cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css");
    $this->addExternalJs("//cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js");
?>

<script type="text/javascript">
	var slidesCountArt=<?=json_encode($itemsCountArt)?>;
</script>

<div class="swiper article-swiper hidden-xs"<? if($itemsCountArt==0)echo $strDispNoneArt; ?>>
    <div class="swiper-wrapper<? if($itemsCountArt<1)echo " swiper-wrapper__center"; ?>">             
        <?foreach($arResult["ITEMS"] as $arItem):?>
            <?if(is_array($arItem["PREVIEW_PICTURE"])):?>
                <?
                $strTitle = (
                    isset($arItem["PREVIEW_PICTURE"]["DESCRIPTION"]) && '' != isset($arItem["PREVIEW_PICTURE"]["DESCRIPTION"])
                    ? $arItem["PREVIEW_PICTURE"]["DESCRIPTION"]
                    : $arItem['NAME']
                );
                ?>
                <div class="new2022__mag-article-item swiper-slide">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                        <div class="new2022__mag-article-item-pic new2022__mag-article-item-pic-review" title="<? echo $strTitle; ?>"
                            style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')">
                        </div>
                        <div class="new2022__mag-article-item-text">
                            <h4><?=$arItem["NAME"]?></h4>
                        </div>
                    </a>
                </div>
            <?endif;?> 
        <?endforeach;?>
    </div>
    <div class="swiper-pagination">
    </div>
</div>