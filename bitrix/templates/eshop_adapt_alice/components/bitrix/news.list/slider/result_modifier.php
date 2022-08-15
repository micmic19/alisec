<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arParams['ROTATE_TIMER'] = intval($arParams['ROTATE_TIMER']);
if (0 > $arParams['ROTATE_TIMER'])
	$arParams['ROTATE_TIMER'] = 30;
$arParams['ROTATE_TIMER'] *= 1000;

?>