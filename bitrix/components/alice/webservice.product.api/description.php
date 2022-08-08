<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
   "NAME" => "Веб-сервис для установки остатков по складам",
   "DESCRIPTION" => "Веб-сервис для установки остатков по складам",
   "CACHE_PATH" => "Y",
   "PATH" => array(
      "ID" => "service",
      "CHILD" => array(
         "ID" => "webservice",
         "NAME" => "Веб-сервис для установки остатков по складам."
      )
   ),
);
?>