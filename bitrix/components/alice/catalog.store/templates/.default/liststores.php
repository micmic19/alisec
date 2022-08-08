<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent(
	"alice:catalog.store.list",
	"",
	Array(
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"SHOPS_IBLOCK_ID" => $arParams["SHOPS_IBLOCK_ID"],
		"SELF_DELIVERY_PLACES_IBLOCK_ID" => $arParams["SELF_DELIVERY_PLACES_IBLOCK_ID"],
		"MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
		"TITLE" => $arParams["TITLE"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"PATH_TO_ELEMENT" => $arResult["PATH_TO_ELEMENT"],
		"PATH_TO_LISTSTORES" => $arResult["PATH_TO_LISTSTORES"],
	),
	$component
);?>