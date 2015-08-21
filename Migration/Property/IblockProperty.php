<?php

/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 19.08.15
 * Time: 9:42
 */
namespace WS\Migration;

use CIBlock;
use CIBlockProperty;
use CIBlockType;
use CUtil;

class IblockProperty extends MigrationBase {

    const PROPERTY_TYPE_STRING = 'S';
    const PROPERTY_TYPE_NUMBER = 'N';
    const PROPERTY_TYPE_FILE = 'F';
    const PROPERTY_TYPE_LIST = 'L';
    const PROPERTY_TYPE_SOURCE_ELEMENT = 'E';
    const PROPERTY_TYPE_SOURCE_GROUP = 'G';

    const USER_TYPE_SOURCE_USER = 'UserID';
    const USER_TYPE_DATETIME = 'DateTime';
    const USER_TYPE_HTML = 'HTML';



    /**
     * @var int
     */
    protected $iblockId;

    /**
     * @var
     */
    private $code;

    /**
     * @var
     */
    private $id;


    /**
     * @param $code
     */
    public function __construct($code) {
        $this->code = $code;
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
    }


    /**
     * @return bool
     * @throws \Exception
     */
    protected function Add() {
        $ibp = new CIBlockProperty();
        $id = $ibp->Add(array_merge($this->getArFieldsEnity(),array(
            "IBLOCK_ID" => $this->iblockId,
            "CODE" => $this->code,
        )));
        if (!$id) {
            $this->sendMessage("Error: add property to iblock id " . $this->iblockId . " - " . $ibp->LAST_ERROR , 'ERR');
            return false;
        } else {
            $this->sendMessage("Свойтсво " . $this->code . " добавлено ", "OK");
            return true;
        }
    }


    public function Update() {
        $ibp = new CIBlockProperty();
        $id = $ibp->Update($this->id,$this->getArFieldsEnity());
        if ($id === false){
            $this->sendMessage("Error: не удалось изменить \"" . $this->code . "\" в инфобллоке " . $this->iblockId. $ibp->LAST_ERROR  , 'ERR');
            return false;
        }else{
            $this->sendMessage("Свойтсво " . $this->code . " обновлено ", "OK");
            return true;
        }
    }


    /**
     * @return bool
     */
    public function Delete() {
        $ibp = new CIBlockProperty();
        if ($ibp->Delete($this->id) == true){
            $this->sendMessage("Свойтсво " . $this->code . " удалено ", "OK");
            return true;
        }else{
            $this->sendMessage("Свойтсво " . $this->code . " не удалось удалить ".$ibp->LAST_ERROR, "ERR");
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isExist() {
        if (empty($this->code)) {
            return false;
        }
        $dbProperty = CIBlockProperty::GetList(
            array("ID" => "ASC"),
            array(
                "IBLOCK_ID" => $this->iblockId,
                "CODE" => $this->code,
            )
        );
        if ($result = $dbProperty->Fetch()) {
            $ibResult = $result;
        }

        if (!empty($ibResult)) {
            $this->sendMessage('Свойство - ' . $this->code . ' существует!', 'INF');
            $this->iblockId = $ibResult['IBLOCK_ID'];
            $this->id = $ibResult['ID'];
            return true;
        } else {
            $this->sendMessage('Свойство - ' . $this->code . ' НЕ существует!', 'INF');
        }
        return false;
    }

    /**
     * @return int
     */
    public function getIblockId() {
        return $this->iblockId;
    }


    /**
     * @param $code
     * @return bool
     */
    public function setIblockIdByCode($code) {
        $dbIblock = CIBlock::GetList(array(), array("CODE" => $code));
        if ($arIblock = $dbIblock->Fetch()){
            $this->iblockId = $arIblock["ID"];
            return true;
        }
        return false;

    }

    /**
     * @param int $iblockId
     */
    public function setIblockId($iblockId) {
        $this->iblockId = $iblockId;
    }

}