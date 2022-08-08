<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
   "NAME" => "Веб-сервис анализа цен и скидок",
   "DESCRIPTION" => "Веб-сервис анализа цен и скидок",
   "CACHE_PATH" => "Y",
   "PATH" => array(
      "ID" => "service",
      "CHILD" => array(
         "ID" => "webservice",
         "NAME" => "Веб-сервис анализа цен и скидок."
      )
   ),
);
?>