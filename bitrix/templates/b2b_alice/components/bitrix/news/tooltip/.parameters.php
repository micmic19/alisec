<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(isset($arCurrentValues["IBLOCK_ID"]) && intval($arCurrentValues["IBLOCK_ID"])>0)
{
	$arListSections = Array('-'=>'');
	$arFilter = Array(
		'IBLOCK_ID' => intval($arCurrentValues["IBLOCK_ID"]),
		'GLOBAL_ACTIVE'=>'Y',
		'IBLOCK_ACTIVE'=>'Y',
	);
	if(isset($arCurrentValues["IBLOCK_TYPE"]) && $arCurrentValues["IBLOCK_TYPE"]!='')
		$arFilter['IBLOCK_TYPE'] = $arCurrentValues["IBLOCK_TYPE"];

	$arSec = CIBlockSection::GetList(Array('LEFT_MARGIN'=>'ASC'), $arFilter, false, array("ID", "DEPTH_LEVEL", "NAME"));
	while($arRes = $arSec->Fetch())
		$arListSections[$arRes['ID']] = str_repeat(".", $arRes['DEPTH_LEVEL']).$arRes['NAME'];
}


$arTemplateParameters = array(
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"PARENT_SECTION" => Array(
		"NAME" => GetMessage("INFO_SETTING_PARENT_SECTION"),
		"TYPE" => "LIST",
		"VALUES" => $arListSections,
	),
);


?>
