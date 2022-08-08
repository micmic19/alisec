<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(isset($_REQUEST["ajax"]) && $_REQUEST["ajax"] === "y"){
	$APPLICATION->RestartBuffer();
	echo CUtil::PHPToJSObject($arResult["CAPTCHA_CODE"]);
	die();
}	

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");
?>

<div class="bx-content col-lg-5 col-md-5 col-xs-12">
<?
if(!empty($arParams["~AUTH_RESULT"])):
	$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
?>
	<div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
<?endif?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
	<div class="alert alert-success"><?echo GetMessage("AUTH_EMAIL_SENT")?></div>
<?else:?>

<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
	<div class="alert alert-warning"><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></div>
<?endif?>

<noindex>
	<form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
<?if($arResult["BACKURL"] <> ''):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="REGISTRATION" />

		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container"><?=GetMessage("AUTH_NAME")?></div>
			<div class="bx-authform-input-container">
				<input type="text" name="USER_NAME" maxlength="255" value="<?=$arResult["USER_NAME"]?>" />
			</div>
		</div>


		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container"><?if($arResult["EMAIL_REQUIRED"]):?><span class="bx-authform-starrequired">*</span><?endif?><?=GetMessage("AUTH_EMAIL")?></div>
			<div class="bx-authform-input-container">
				<input type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" />
			</div>
		</div>

<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
	<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>

		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container"><?if ($arUserField["MANDATORY"]=="Y"):?><span class="bx-authform-starrequired">*</span><?endif?><?=$arUserField["EDIT_FORM_LABEL"]?></div>
			<div class="bx-authform-input-container">
<?
$APPLICATION->IncludeComponent(
	"bitrix:system.field.edit",
	$arUserField["USER_TYPE"]["USER_TYPE_ID"],
	array(
		"bVarsFromForm" => $arResult["bVarsFromForm"],
		"arUserField" => $arUserField,
		"form_name" => "bform"
	),
	null,
	array("HIDE_ICONS"=>"Y")
);
?>
			</div>
		</div>

	<?endforeach;?>
<?endif;?>
<?if ($arResult["USE_CAPTCHA"] == "Y"):?>
		<input type="hidden" id = "captcha_sid" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />

		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">
				<span class="bx-authform-starrequired">*</span><?=GetMessage("CAPTCHA_REGF_PROMT")?>
			</div>
			<div class="bx-captcha">
				<img id = "captcha_image_sid" src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
				<div class="refresh-captcha" title="Обновить картинку" onclick="refreshcaptcha('<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>');"></div>			
			</div>
			<div style="clear:both;"></div>
			<div class="bx-authform-input-container">
				<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
			</div>
		</div>

<?endif?>
		<div class="bx-authform-formgroup-container">
			<input type="submit" class="btn btn-primary" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" />
		</div>

		<hr class="bxe-light">

		<div class="bx-authform-description-container">
			<?//echo ?>
		</div>

		<div class="bx-authform-description-container">
			<span class="bx-authform-starrequired">*</span><?=GetMessage("AUTH_REQ")?>
		</div>

		<div class="bx-authform-link-container hidden-xs">
			<a href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><b><?=GetMessage("AUTH_AUTH")?></b></a>
		</div>

	</form>
</noindex>

<script type="text/javascript">
document.bform.USER_NAME.focus();
</script>

<?endif?>
</div>
<div class="bx-content col-lg-7 col-md-7 col-xs-12">
	<h2>Регистрация на сайте необязательна</h2>
	<p>Регистрация производится автоматически при оформлении заказа.<br>
	   Логин и пароль будут высланы по электронной почте.</p>
	<h4 class="hidden-xs">Продавец использует предоставленные Клиентом данные в течение всего срока регистрации Клиента на Сайте в целях:</h4>
	<ul class="hidden-xs">
		<li>для регистрации/авторизации Клиента на Сайте;</li>
		<li>для обработки заказов Клиента и выполнения своих обязательств перед Клиентом;</li>
		<li>для осуществления деятельности по продвижению товаров и услуг;</li>
	</ul>
</div>
