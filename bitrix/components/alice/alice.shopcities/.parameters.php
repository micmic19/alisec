<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock"))
	return;
$arIBlockType = CIBlockParameters::GetIBlockTypes();
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE_ID"], "ACTIVE"=>"Y"));
while($arr=$rsIBlock->Fetch())
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];

 $arComponentParameters = array(
"GROUPS" => array(),
"PARAMETERS" => array(
		"IBLOCK_TYPE_ID" 	=>array("PARENT" 	=> "BASE",
									"NAME" 	=> GetMessage("IBLOCK_TYPE"),
									"TYPE" 	=> "LIST",
									"VALUES"	=> $arIBlockType,
									"REFRESH" 	=> "Y"),
		"IBLOCK_ID" 		=>array("PARENT" => "BASE",
									"NAME" => GetMessage("IBLOCK_IBLOCK"),
									"TYPE" => "LIST",
									"ADDITIONAL_VALUES" => "Y",
									"VALUES" => $arIBlock,
									"REFRESH" => "Y",
									"MULTIPLE" => "N"),
		"CACHE_TIME"  		=>array("DEFAULT"=>36000000),
		"CACHE_GROUPS" 		=>array("PARENT" => "CACHE_SETTINGS",
									"NAME" => GetMessage("CP_BCT_CACHE_GROUPS"),
									"TYPE" => "CHECKBOX",
									"DEFAULT" => "Y",),
		"AJAX_MODE" => 		array(),
		"DIV_ROW_QUANTITY" 	=>array("PARENT" => "BASE",
					"NAME" 	=> iconv("windows-1251", "utf-8", "Количество строк в колонке"),
					"TYPE" 	=> "INT",
					"REFRESH" 	=> "N")
));
?>