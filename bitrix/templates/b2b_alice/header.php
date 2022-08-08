<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
$wizTemplateId = COption::GetOptionString("main", "wizard_template_id", "eshop_adapt_horizontal", SITE_ID);
CJSCore::Init(array("fx"));
CJSCore::Init('jquery');//#ALICE
$curPage = $APPLICATION->GetCurPage(true);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
	<?$APPLICATION->ShowHead();?>
	<?
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/colors.css");
	$APPLICATION->SetAdditionalCSS("/bitrix/css/main/bootstrap.css");
	$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
	?>
	<title><?$APPLICATION->ShowTitle()?></title>
	<link rel="icon" href="/images/favicon_b2b.ico" type="image/x-icon"/>	
	<link rel="shortcut icon" href="/images/favicon_b2b.ico" type="image/x-icon"/>
</head>
<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<div class="bx-wrapper" id="bx_eshop_wrap">
	<header class="bx-header" itemscope itemtype="http://schema.org/Organization">
		<div class="bx-header-section container">
			<div class="row">
				<div class="hidden-xs col-md-4">
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
							"MENU_DROPDOWN_COLLAPSED" => "Y",
							"COMPONENT_TEMPLATE" => "catalog_horizontal_alice"
						),
						false
					);?>
				</div>
				<div class="col-md-8 col-sm-8">
					<?$APPLICATION->IncludeComponent(
						"bitrix:search.title", 
						"visual", 
						array(
							"NUM_CATEGORIES" => "1",
							"TOP_COUNT" => "5",
							"CHECK_DATES" => "N",
							"SHOW_OTHERS" => "N",
							"PAGE" => SITE_DIR,
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
			</div>
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
			<h1 class="bx-title dbg_title"><?=$APPLICATION->ShowTitle(false);?></h1>
		</div>
	</header>
	<div class="workarea">
		<div class="container bx-content-seection">
			<div class="row">
				<div class="bx-content col-xs-12">