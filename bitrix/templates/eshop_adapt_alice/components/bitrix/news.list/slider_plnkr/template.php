<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
	$this->addExternalJs("//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js");
	$this->addExternalCss("//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css");

?>
<div class="container">
  <div id="myCarousel" class="carousel slide">

    <div class="carousel-inner">
	<?$first=true;?>	
		<?foreach($arResult["ITEMS"] as $arItem):?>

			<?if(is_array($arItem["PREVIEW_PICTURE"])):?>
				  <div class="item <?if($first==true):?>active<?endif;?>">
					<div class="col-xs-4">
					  <a href="#"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" class="img-responsive"></a>
					</div>
				  </div>
				  <?$first=false;?>
			 <?endif;?> 
		<?endforeach;?>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>