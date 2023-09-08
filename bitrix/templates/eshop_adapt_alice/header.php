<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
$wizTemplateId = COption::GetOptionString("main", "wizard_template_id", "eshop_adapt_horizontal", SITE_ID);

use Bitrix\Main\Page\Asset; //mic 08/09/23

CJSCore::Init(array("fx"));
//CJSCore::Init('jquery');//#ALICE
CJSCore::Init(array('jquery2'));//#ALICE mic 18/10/2021 yyy

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/fancybox/jquery.fancybox.min.css'); //mic 08/09/23
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/fancybox/jquery.fancybox.min.js'); //mic 08/09/23

$curPage = $APPLICATION->GetCurPage(true);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <link href='/images/favicon/apple-icon-57x57.png' rel='apple-touch-icon' sizes='57x57'>
    <link href='/images/favicon/apple-icon-60x60.png' rel='apple-touch-icon' sizes='60x60'>
    <link href='/images/favicon/apple-icon-72x72.png' rel='apple-touch-icon' sizes='72x72'>
    <link href='/images/favicon/apple-icon-76x76.png' rel='apple-touch-icon' sizes='76x76'>
    <link href='/images/favicon/apple-icon-114x114.png' rel='apple-touch-icon' sizes='114x114'>
    <link href='/images/favicon/apple-icon-120x120.png' rel='apple-touch-icon' sizes='120x120'>
    <link href='/images/favicon/apple-icon-144x144.png' rel='apple-touch-icon' sizes='144x144'>
    <link href='/images/favicon/apple-icon-152x152.png' rel='apple-touch-icon' sizes='152x152'>
    <link href='/images/favicon/apple-icon-180x180.png' rel='apple-touch-icon' sizes='180x180'>
    <link href='/images/favicon/android-icon-192x192.png' rel='icon' sizes='192x192' type='image/png'>
    <link href='/images/favicon/favicon-32x32.png' rel='icon' sizes='32x32' type='image/png'>
    <link href='/images/favicon/favicon-96x96.png' rel='icon' sizes='96x96' type='image/png'>
    <link href='/images/favicon/favicon-16x16.png' rel='icon' sizes='16x16' type='image/png'>
    <link href='/images/favicon/manifest.json' rel='manifest'>
	<?$APPLICATION->ShowHead();?>
	<?
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/colors.css");
	$APPLICATION->SetAdditionalCSS("/bitrix/css/main/bootstrap.css");
	$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
	?>
	<title><?$APPLICATION->ShowTitle()?></title>
</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<div class="bx-wrapper" id="bx_eshop_wrap">
	<header class="bx-header" itemscope itemtype="http://schema.org/Organization">
		<div class="bx-header-section container">
			<div class="row">
				<div class="col-sm-1 hidden-xs"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/vk_header.php"), false);?></div>							
				<div class="col-md-9 col-sm-7 hidden-xs">
					<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"top_menu_multilevel", 
	array(
		"ROOT_MENU_TYPE" => "top",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_TYPE" => "N",
		"CACHE_SELECTED_ITEMS" => "N",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"COMPONENT_TEMPLATE" => "top_menu_multilevel",
		"CHILD_MENU_TYPE" => "bottom",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
				</div>
				<div class="col-md-2 col-sm-4 hidden-xs"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/telephone_header.php"), false);?></div>				
			</div>
			<div class="row">
				<div class="bx-logo col-md-2 col-lg-1 col-sm-2">
					<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/company_logo.php"), false);?>
				</div>
				<div class="col-md-5 col-lg-7 col-sm-6">

					<?$APPLICATION->IncludeComponent(
						"bitrix:search.title", 
						"visual", 
						array(
							"NUM_CATEGORIES" => "1",
							"TOP_COUNT" => "5",
							"CHECK_DATES" => "N",
							"SHOW_OTHERS" => "N",
							"PAGE" => SITE_DIR."catalog/",
							"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
							"CATEGORY_0" => array(
								0 => "iblock_catalog",
								1 => "iblock_offers",
							),
							"CATEGORY_0_iblock_catalog" => array(
								0 => "2",
							),
							"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
							"SHOW_INPUT" => "Y",
							"INPUT_ID" => "title-search-input",
							"CONTAINER_ID" => "search",
							"PRICE_CODE" => array(
								0 => "BASE",
							),
							"SHOW_PREVIEW" => "Y",
							"PREVIEW_WIDTH" => "75",
							"PREVIEW_HEIGHT" => "75",
							"CONVERT_CURRENCY" => "Y",
							"COMPONENT_TEMPLATE" => "visual",
							"ORDER" => "date",
							"USE_LANGUAGE_GUESS" => "Y",
							"PRICE_VAT_INCLUDE" => "Y",
							"PREVIEW_TRUNCATE_LEN" => "",
							"CURRENCY_ID" => "RUB",
							"CATEGORY_0_iblock_offers" => array(
								0 => "3",
							)
						),
						false
					);?>
				</div>
				<div class="opt-enter col-lg-2 col-md-3 hidden-sm hidden-xs">
					<a href="http://www.alice.ru/opt/goods/classes.aspx" target="_blank">ДЛЯ ОПТОВЫХ ПОКУПАТЕЛЕЙ</a>
				</div>
				<div class="col-md-2 col-sm-4 hidden-xs pull-right">
					<?$APPLICATION->IncludeComponent(
						"bitrix:sale.basket.basket.line", 
						"modern", 
						array(
							"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
							"PATH_TO_PERSONAL" => SITE_DIR."personal/",
							"SHOW_PERSONAL_LINK" => "N",
							"SHOW_NUM_PRODUCTS" => "Y",
							"SHOW_TOTAL_PRICE" => "Y",
							"SHOW_PRODUCTS" => "N",
							"POSITION_FIXED" => "N",
							"SHOW_AUTHOR" => "Y",
							"PATH_TO_REGISTER" => SITE_DIR."login/",
							"PATH_TO_PROFILE" => SITE_DIR."personal/",
							"COMPONENT_TEMPLATE" => "modern",
							"SHOW_EMPTY_VALUES" => "Y"
						),
						false
					);?>
				</div>
			</div>
			<div class="row">
				<div class="hidden-xs <?=(($curPage == SITE_DIR."index.php" || $curPage == SITE_DIR."catalog/index.php") ? "col-md-12": "col-sm-4")?>">
					<?if ($wizTemplateId == "eshop_adapt_horizontal"):?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:menu", 
							"catalog_horizontal_alice", 
							array(
								"ROOT_MENU_TYPE" => "left",
								"MENU_CACHE_TYPE" => "A",
								"MENU_CACHE_TIME" => "600",
								"MENU_CACHE_USE_GROUPS" => "Y",
								"MENU_THEME" => "site",
								"CACHE_SELECTED_ITEMS" => "N",
								"MENU_CACHE_GET_VARS" => array(
								),
								"MAX_LEVEL" => "1",
								"CHILD_MENU_TYPE" => "left",
								"USE_EXT" => "Y",
								"DELAY" => "N",
								"ALLOW_MULTI_SELECT" => "N",
								"MENU_DROPDOWN_COLLAPSED" => (($curPage==SITE_DIR."index.php" || $curPage==SITE_DIR."catalog/index.php")?"N":"Y"),
								"COMPONENT_TEMPLATE" => "catalog_horizontal_alice"
							),
							false
						);?>
					<?endif?>
				</div>
			</div>			
			<?if ($curPage != SITE_DIR."index.php"):?>
				<div class="row">
					<div class="col-lg-12">
						<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "", array(
								"START_FROM" => "0",
								"PATH" => "",
								"SITE_ID" => "-"
							),
							false,
							Array('HIDE_ICONS' => 'Y')
						);?>
					</div>
				</div>
				<div class="row">
					<h3 class="<?=($curPage=="/about/shops/index.php" ? "bx-title-center" : "")?> bx-title dbg_title"><?=$APPLICATION->ShowTitle(false);?></h3>
					<?if (preg_match('/catalog\/[a-z0-9_\-]+\/index\.php/', $curPage)):?>
						<div class="col-md-3">Можно купить как в интернет магазине, так и со склада и в магазинах сети "Элис" в Санкт-Петербурге</div>
					<?endif?>
				</div>
			<?endif?>
			</div>
		</div>
	</header>
	<div class="workarea">
		<div class="container bx-content-seection">
			<div class="row">
			<?$isCatalogPage = preg_match("~^".SITE_DIR."catalog/~", $curPage);$isCatalogPage=true//#ALICE?>
				<div class="bx-content <?=($isCatalogPage ? "col-xs-12" : "col-md-9 col-sm-8")?>">