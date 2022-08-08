Выводит список городов из склада
1. В поле Адрес -> hostname(shopsam.alice.ru)
Вызывается header.php
<? $APPLICATION->IncludeComponent("alice:alice.shopcities", ".default", array(
	"IBLOCK_TYPE_ID" => "services",
	"IBLOCK_ID" => "6",
	"DIV_ROW_QUANTITY" => "5"
	),
	false
);?>

