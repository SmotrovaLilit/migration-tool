<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once __DIR__."/Migration/MigrationBase.php";
require_once __DIR__."/Migration/Iblock.php";
require_once __DIR__."/Migration/IblockType.php";
require_once __DIR__."/Migration/Property/IblockProperty.php";
require_once __DIR__."/Migration/Property/IblockPropertyString.php";
require_once __DIR__."/Migration/Property/IblockPropertyList.php";
require_once __DIR__."/Migration/Property/IblockPropertyCheck.php";
require_once __DIR__."/Migration/Property/IblockPropertyElementLink.php";
require_once __DIR__."/Migration/Property/IblockPropertyGroupLink.php";
require_once __DIR__."/Migration/Property/IblockPropertyNumber.php";
require_once __DIR__."/Migration/Property/IblockPropertyUserLink.php";

/** тип инфоблока */
$iblockTypeCode = "MEET";
$iblockType = new \WS\Migration\IblockType($iblockTypeCode);
$iblockType->setIblockTypeName("Встреча");
if ($iblockType->migrate() == false){
    exit;
}

/** инфоблок */
$iblockCode = "MEET";
$iblock = new \WS\Migration\Iblock($iblockCode);
$iblock->setArFieldsEnity(array(
    'NAME' => 'Встреча',
));
$iblock->setIblockType($iblockTypeCode);
$property = new \WS\Migration\IblockPropertyString("ADDRESS");
$property->setArFieldsEnity(array(
    "NAME" => "Адрес встречи",
));
$iblock->addProperty($property);

$property = new \WS\Migration\IblockPropertyUserLink("USER_TARGET");
$property->setArFieldsEnity(array(
    "NAME" => "к кому назначена1",
));
$iblock->addProperty($property);

$property = new \WS\Migration\IblockPropertyList("STATUS");
$property->setArFieldsEnity(array(
    "NAME" => "Статус",
    "MULTIPLE" => "N",
    "IS_REQUIRED" => "N",
));
$property->addValue("Назначена");
$property->addValue("Подтверждена");
$property->addValue("Отказ");
$property->addValue("Назначано другое время");
$iblock->addProperty($property);
$iblock->migrate();