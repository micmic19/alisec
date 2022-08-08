<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->IncludeComponent(
	"alice:catalog.store.detail",
	"",
	Array(
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"STORE" => $arResult["STORE"],
		"TITLE" => $arParams["TITLE"],
		"PATH_TO_ELEMENT" => $arResult["PATH_TO_ELEMENT"],
		"PATH_TO_LISTSTORES" => $arResult["PATH_TO_LISTSTORES"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"SELF_DELIVERY_PLACES_IBLOCK_ID" => $arParams["SELF_DELIVERY_PLACES_IBLOCK_ID"],
	),
	$component
);?>