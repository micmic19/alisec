<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
	$strDispNone = " style='display: none;'";
	$itemsCount = count($arResult["ITEMS"]);
	$this->addExternalJs("//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js");
	$this->addExternalCss("//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css");
?>
<div class="container"<? if($itemsCount==0)echo $strDispNone; ?>>
	<div class="row">
		<div class="col-xs-11 col-md-11 col-centered">

			<div id="carousel" class="carousel slide" data-ride="carousel" data-type="multi" data-interval="250">
			<ol class="carousel-indicators">
				<li data-target="#carousel" data-slide-to="0" class="active"></li>
				<?for ($i = 1; $i < count($arResult["ITEMS"]); $i++):?>
					<li data-target="#carousel" data-slide-to="<?echo $i?>"></li>
				<?endfor;?>
			</ol>	
			<div class="carousel-inner">
					<?$first=true;?>	
					<?foreach($arResult["ITEMS"] as $arItem):?>
						<?if(is_array($arItem["PREVIEW_PICTURE"])):?>
							  <div class="item <?if($first==true):?>active<?endif;?>">
								<div class="carousel-col">
									<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
										<img class="block img-responsive" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>">
									</a>	
								</div>
							  </div>
							  <?$first=false;?>
						 <?endif;?> 
					<?endforeach;?>
				</div>
				<!-- Controls -->
				<div class="left carousel-control">
					<a href="#carousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
				</div>
				<div class="right carousel-control">
					<a href="#carousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>

		</div>
	</div>
</div>