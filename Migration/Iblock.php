<?php

/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 19.08.15
 * Time: 9:42
 */
namespace WS\Migration;

use Bitrix\Main\DB\Exception;
use CIBlock;
use CIBlockProperty;

class Iblock extends MigrationBase {
    /**
     * @var IblockProperty[]
     */
    private $arProperties = array();

    /**
     * @var string
     */
    private $code;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $iblockType;


    /**
     * @param $code
     * @throws Exception
     */
    public function __construct($code){
        if (!\CModule::IncludeModule("iblock")) {
            throw new Exception("Не установлен модуль инфоблоков");
        }
        $this->code = $code;
    }

    /**
     *
     */
    public function setMigrationForDelete(){
        $this->actionDelete = true;
    }
    /**
     * @throws \Exception
     */
    public function migrate(){
        if (!$this->isExist()) {
            $this->id = $this->Add();
        }else{
            if ($this->isActionDelete() === true){
                return $this->Delete();
            }
            $this->Update();
        }
        $this->migrateProperties();
    }


    /**
     * @param mixed $arProperties
     * @return Iblock[]
     */
    public function setArProperties($arProperties) {
        $this->arProperties = $arProperties;
    }

    /**
     * @return array
     */
    public function getArProperties() {
        return $this->arProperties;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    protected function Add() {
        if (empty($this->code)) {
            return false;
        }
        $arFieldsImportant = array(
            "CODE" => $this->code,
            "IBLOCK_TYPE_ID" => $this->iblockType,
        );
        $arFields = array(
            "SITE_ID" => SITE_ID,
            "WORKFLOW" => 'N',
        );
        $ib = new CIBlock;
        $id = $ib->Add(array_merge($arFields,$this->getArFieldsEnity(),$arFieldsImportant));
        if ($id) {
            $this->sendMessage('ИБ - ' . $this->code . ' создан!', 'OK');
            return $id;
        } else {
            $this->sendMessage('ИБ - ' . $this->code . ' HE создан! ' . $ib->LAST_ERROR . '<br/>', 'ERR');
            throw new \Exception($ib->LAST_ERROR);
        }


        
    }

    public function Update() {
        global $DB;
        $obBlock = new CIBlock;
        $DB->StartTransaction();
        $res = $obBlock->Update($this->id, $this->getArFieldsEnity());
        if(!$res)
        {
            $DB->Rollback();
            $this->sendMessage('ИБ - ' . $this->id . ' НЕ  удалось обновить!'.$obBlock->LAST_ERROR, 'ERR');
            return false;
        }
        $DB->Commit();
        $this->sendMessage('ИБ - ' . $this->id . ' обновлен!', 'OK');
        return true;
    }

    public function Delete() {
        global $DB;
        $DB->StartTransaction();
        if(!CIBlock::Delete($this->id))
        {
            $DB->Rollback();
            $this->sendMessage('ИБ - ' . $this->id . ' НЕ  удалось удалить!', 'ERR');
            return false;
        }
        $DB->Commit();
        $this->sendMessage('ИБ - ' . $this->id . ' удален!', 'OK');
        return true;
    }

    public function isExist() {
        $code = $this->code;
        if (empty($code)) {
            return false;
        }

        $db = CIBlock::GetList(array(), array("CODE" => $code));
        while ($result = $db->Fetch()) {
            $ibResult[] = $result;
        }

        if (!empty($ibResult)) {
            $this->sendMessage('ИБ - ' . $code . ' существует!', 'INF');
            $this->id = $ibResult[0]['ID'];
            return true;
        } else {
            $this->sendMessage('ИБ - ' . $code . ' НЕ существует!', 'ERR');
        }
        return false;
    }

    private function migrateProperties() {
        if (!$this->id) {
            return false;
        }
        foreach ($this->arProperties as $iblockProperty){
            $iblockProperty->setIblockId($this->id);
            $iblockProperty->migrate();
        }

    }

    /**
     * @return string
     */
    public function getIblockType() {
        return $this->iblockType;
    }

    /**
     * @param string $iblockType
     */
    public function setIblockType($iblockType) {
        $this->iblockType = $iblockType;
    }


    public function addProperty(IblockProperty $iblockProperty) {
        $this->arProperties[] = $iblockProperty;
    }



}