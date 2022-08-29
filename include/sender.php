<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="bx-subscribe">
	<div class="bx-block-title">РАССЫЛКА</div>
	<?$APPLICATION->IncludeComponent("alice:sender.subscribe", "", array(
	"SET_TITLE" => "N"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>
</div>