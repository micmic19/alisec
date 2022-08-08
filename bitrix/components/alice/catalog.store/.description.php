<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("PAGE_TEMPLATE_NAME"),
	"DESCRIPTION" => GetMessage("STORE_MAIN_PAGE_TEMPLATE_DESCRIPTION"),
	"ICON" => "/images/cat_all.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 90,
	"PATH" => array(
		"ID" => "content",
		"CHILD" => array(
			"ID" => "catalog",
			"NAME" => GetMessage("DESC_CATALOG"),
			"SORT" => 30,
			"CHILD" => array(
				"ID" => "catalog_store",
			),
		)
	),
	"COMPLEX" => "Y"
);
?>