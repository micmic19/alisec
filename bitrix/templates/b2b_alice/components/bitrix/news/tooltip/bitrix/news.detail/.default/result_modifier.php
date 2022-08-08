<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
 	if(!empty($_REQUEST["ajax_help"]) && $_REQUEST["ajax_help"] == 1)
		$arResult["DISPLAY_PREVIEW_TEXT"] = "Y";
	else
		$arResult["DISPLAY_PREVIEW_TEXT"] = "N";
?>