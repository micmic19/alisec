<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */


if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["ID"] = intval($arParams["ID"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);

$arParams["DEPTH_LEVEL"] = intval($arParams["DEPTH_LEVEL"]);
if($arParams["DEPTH_LEVEL"]<=0)
	$arParams["DEPTH_LEVEL"]=1;

$arResult["SECTIONS"] = array();
$arResult["ELEMENT_LINKS"] = array();

if($this->StartResultCache())
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
	}
	else
	{
		//#ALICE
GLOBAL $DB;
$strSql="SELECT DISTINCT IBLOCK_SECTION_ID FROM b_iblock_section_element
WHERE b_iblock_section_element.IBLOCK_ELEMENT_ID IN
(SELECT b_iblock_element.ID
   FROM	b_iblock_property
   INNER JOIN b_iblock_element_prop_m2
   ON b_iblock_property.ID = b_iblock_element_prop_m2.IBLOCK_PROPERTY_ID
	INNER JOIN b_iblock_element
	ON b_iblock_element.ID = b_iblock_element_prop_m2.IBLOCK_ELEMENT_ID
 WHERE b_iblock_property.CODE = 'ACTIVE_ALICE' AND b_iblock_element_prop_m2.VALUE = '".$arParams["ACTIVE_ALICE"]."' AND b_iblock_element.ACTIVE='Y')";		
		$arSections = Array();
		$arFilterSections = array(
			"IBLOCK_ID"=>$arParams["IBLOCK_ID"],
			"ACTIVE"=>"Y",
			"PROPERTY_ACTIVE_ALICE"=>$arParams["ACTIVE_ALICE"],
		);
		$rsSections = $DB->Query($strSql);
		//$rsSections = CIBlockElement::GetList(array(), $arFilterSections, array("IBLOCK_SECTION_ID"), false);
		//while($ob = $rsSections->GetNextElement()) {
		while ($ar_Sections = $rsSections->Fetch()) {
			//$ar_Sections = $ob->GetFields();//CNT	quantity elem
			$arSections[] = $ar_Sections["IBLOCK_SECTION_ID"];
			a:
			$res = CIBlockSection::GetByID($ar_Sections["IBLOCK_SECTION_ID"]);
			if($ar_res = $res->GetNext()) {
				if (!empty($ar_res["IBLOCK_SECTION_ID"])) {
					$arSections[] = $ar_res["IBLOCK_SECTION_ID"];
					$ar_Sections["IBLOCK_SECTION_ID"] = $ar_res["IBLOCK_SECTION_ID"];
					goto a;
				}
			}
		}
		$arSections = array_unique($arSections);
		//#ALICE

		$arFilter = array(
			"ID" => $arSections,//#ALICE
			"IBLOCK_ID"=>$arParams["IBLOCK_ID"],
			"GLOBAL_ACTIVE"=>"Y",
			"IBLOCK_ACTIVE"=>"Y",
			"<="."DEPTH_LEVEL" => $arParams["DEPTH_LEVEL"],
		);
		$arOrder = array(
			"left_margin"=>"asc",
		);
		$rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, array(
			"ID",
			"DEPTH_LEVEL",
			"NAME",
			"SECTION_PAGE_URL",
		));
		if($arParams["IS_SEF"] !== "Y")
			$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
		else
			$rsSections->SetUrlTemplates("", $arParams["SEF_BASE_URL"].$arParams["SECTION_PAGE_URL"]);
		while($arSection = $rsSections->GetNext())
		{
			$arResult["SECTIONS"][] = array(
				"ID" => $arSection["ID"],
				"DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"],
				"~NAME" => $arSection["~NAME"],
				"~SECTION_PAGE_URL" => $arSection["~SECTION_PAGE_URL"],
			);
			$arResult["ELEMENT_LINKS"][$arSection["ID"]] = array();
		}
		$this->EndResultCache();
	}
}

//In "SEF" mode we'll try to parse URL and get ELEMENT_ID from it
if($arParams["IS_SEF"] === "Y")
{
	$engine = new CComponentEngine($this);
	if (CModule::IncludeModule('iblock'))
	{
		$engine->addGreedyPart("#SECTION_CODE_PATH#");
		$engine->setResolveCallback(array("CIBlockFindTools", "resolveComponentEngine"));
	}
	$componentPage = $engine->guessComponentPath(
		$arParams["SEF_BASE_URL"],
		array(
			"section" => $arParams["SECTION_PAGE_URL"],
			"detail" => $arParams["DETAIL_PAGE_URL"],
		),
		$arVariables
	);
	if($componentPage === "detail")
	{
		CComponentEngine::InitComponentVariables(
			$componentPage,
			array("SECTION_ID", "ELEMENT_ID"),
			array(
				"section" => array("SECTION_ID" => "SECTION_ID"),
				"detail" => array("SECTION_ID" => "SECTION_ID", "ELEMENT_ID" => "ELEMENT_ID"),
			),
			$arVariables
		);
		$arParams["ID"] = intval($arVariables["ELEMENT_ID"]);
	}
}

if(($arParams["ID"] > 0) && (intval($arVariables["SECTION_ID"]) <= 0) && CModule::IncludeModule("iblock"))
{
	$arSelect = array("ID", "IBLOCK_ID", "DETAIL_PAGE_URL", "IBLOCK_SECTION_ID");
	$arFilter = array(
		"ID" => $arParams["ID"],
		"ACTIVE" => "Y",
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	);
	$rsElements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	if(($arParams["IS_SEF"] === "Y") && (strlen($arParams["DETAIL_PAGE_URL"]) > 0))
		$rsElements->SetUrlTemplates($arParams["SEF_BASE_URL"].$arParams["DETAIL_PAGE_URL"]);
	while($arElement = $rsElements->GetNext())
	{
		$arResult["ELEMENT_LINKS"][$arElement["IBLOCK_SECTION_ID"]][] = $arElement["~DETAIL_PAGE_URL"];
	}
}

$aMenuLinksNew = array();
$menuIndex = 0;
$previousDepthLevel = 1;
foreach($arResult["SECTIONS"] as $arSection)
{
	if ($menuIndex > 0)
		$aMenuLinksNew[$menuIndex - 1][3]["IS_PARENT"] = $arSection["DEPTH_LEVEL"] > $previousDepthLevel;
	$previousDepthLevel = $arSection["DEPTH_LEVEL"];

	$arResult["ELEMENT_LINKS"][$arSection["ID"]][] = urldecode($arSection["~SECTION_PAGE_URL"]);
	$aMenuLinksNew[$menuIndex++] = array(
		htmlspecialcharsbx($arSection["~NAME"]),
		$arSection["~SECTION_PAGE_URL"],
		$arResult["ELEMENT_LINKS"][$arSection["ID"]],
		array(
			"FROM_IBLOCK" => true,
			"IS_PARENT" => false,
			"DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"],
		),
	);
}

return $aMenuLinksNew;
?>
