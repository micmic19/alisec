<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?$APPLICATION->IncludeComponent(
	"bitrix:eshop.socnet.links", 
	"big_squares", 
	array(
		"FACEBOOK" => "",
		"VKONTAKTE" => "https://vk.com/alicenapol",
		"TWITTER" => "",
		"GOOGLE" => "",
		"INSTAGRAM" => "",
		"COMPONENT_TEMPLATE" => "big_squares"
	),
	false,
	array(
		"HIDE_ICONS" => "N"
	)
);?>