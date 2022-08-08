<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
$wizTemplateId = COption::GetOptionString("main", "wizard_template_id", "eshop_adapt_horizontal", SITE_ID);
CJSCore::Init(array("fx"));
//CJSCore::Init('jquery');//#ALICE
CJSCore::Init(array('jquery2'));//#ALICE mic 18/10/2021
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
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
					<div class="bx-logo row">
						<a class="bx-logo-block hidden-xs" href="<?=SITE_DIR?>">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/company_logo.php"), false);?>
						</a>
						<a class="bx-logo-block hidden-lg hidden-md hidden-sm text-center" href="<?=SITE_DIR?>">
							<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/company_logo_mobile.php"), false);?>
						</a>
						<div class="hidden-lg hidden-md hidden-sm">
						<?$APPLICATION->ShowViewContent("city_brandzone_mobile")?>
						</div>
					</div>
						<div class="row">
							<a href="https://vk.com/alicenapol" target="_blank"><img src="/images/vk1.jpg"></a>
						</div>
				</div>
									<? $APPLICATION->IncludeComponent("alice:alice.shopcities", ".default", array(
						"IBLOCK_TYPE_ID" => "news",
							"IBLOCK_ID" => "5",
							"DIV_ROW_QUANTITY" => "4",
							"AJAX_MODE" => "N",
							"AJAX_OPTION_JUMP" => "N",
							"AJAX_OPTION_STYLE" => "Y",
							"AJAX_OPTION_HISTORY" => "N",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "36000000",
							"CACHE_GROUPS" => "Y",
							"AJAX_OPTION_ADDITIONAL" => "",
							"COMPONENT_TEMPLATE" => ".default"
						),
						false,
						array(
						"ACTIVE_COMPONENT" => "Y"
						)
					);?>					
			<div class="opt-enter col-lg-6 col-md-6 hidden-sm hidden-xs">
				<a href="http://www.alice.ru/opt/goods/classes.aspx" target="_blank">ВХОД ДЛЯ ОПТОВЫХ ПОКУПАТЕЛЕЙ</a>
			</div>

				<?if ($curPage == SITE_DIR."index.php"):?>		
				<div class="hidden-xs">
<?$APPLICATION->IncludeComponent("bitrix:advertising.banner", "bootstrap", array(
	"COMPONENT_TEMPLATE" => "bootstrap",
		"TYPE" => "MAIN",
		"NOINDEX" => "N",
		"QUANTITY" => "1",
		"BS_EFFECT" => "slide",
		"BS_CYCLING" => "Y",
		"BS_WRAP" => "Y",
		"BS_KEYBOARD" => "Y",
		"BS_ARROW_NAV" => "Y",
		"BS_BULLET_NAV" => "Y",
		"BS_HIDE_FOR_TABLETS" => "N",
		"BS_HIDE_FOR_PHONES" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "0",
		"BS_INTERVAL" => "5000",
		"BS_PAUSE" => "Y"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>

				<?$APPLICATION->ShowViewContent("city_brandzone")?>
				</div>
				<?endif;?>
				<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 hidden-xs pull-right">
					<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "", array(
							"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
							"PATH_TO_PERSONAL" => SITE_DIR."personal/",
							"SHOW_PERSONAL_LINK" => "N",
							"SHOW_NUM_PRODUCTS" => "Y",
							"SHOW_TOTAL_PRICE" => "Y",
							"SHOW_PRODUCTS" => "N",
							"POSITION_FIXED" =>"N",
							"SHOW_AUTHOR" => "Y",
							"PATH_TO_REGISTER" => SITE_DIR."login/",
							"PATH_TO_PROFILE" => SITE_DIR."personal/"
						),
						false,
						array()
					);?>
				</div>
			</div>
			<div class="row">
			<div class="col-md-2 hidden-xs">
					<?$APPLICATION->ShowViewContent("city_selector")?>			
			</div>		
					<div class="col-md-10 hidden-xs">

				<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"top_menu", 
	array(
		"ROOT_MENU_TYPE" => "top",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_TYPE" => "A",
		"CACHE_SELECTED_ITEMS" => "N",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"COMPONENT_TEMPLATE" => "top_menu",
		"CHILD_MENU_TYPE" => "top",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
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
			<?if ($curPage == SITE_DIR."index.php"):?>
			</div>			
			<div class="row">
				<div class="col-sm-12">
			<?else:?>
				<div class="col-sm-8">
			<?endif?>
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
				<?if ($curPage == SITE_DIR."index.php"):?>
					</div>
				<?endif?>

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
			<h3 class="bx-title dbg_title"><?=$APPLICATION->ShowTitle(false);?></h3>
			<?endif?>
		</div>
	</header>
	<div class="workarea">
		<div class="container bx-content-seection">
			<div class="row">
			<?$isCatalogPage = preg_match("~^".SITE_DIR."catalog/~", $curPage);$isCatalogPage=true//#ALICE?>
				<div class="bx-content <?=($isCatalogPage ? "col-xs-12" : "col-md-9 col-sm-8")?>">