<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(
	"NOTIFY_ID" => $_POST["OFFER_ID"],
	"NOTIFY_URL" => htmlspecialcharsback($_POST["SUBSCRIBE_URL"]),
	"NOTIFY_USE_CAPTHA" => "Y",
	"AJAX_POST" => "Y",
	),
	$component
);

require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_after.php");
?>