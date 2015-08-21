<?php

/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 19.08.15
 * Time: 9:42
 */
namespace WS\Migration;

use CIBlockType;
use CUtil;

class IblockType extends MigrationBase {

    /**
     * @var string
     */
    private $iblockTypeId;

    /**
     * @var string
     */
    private $iblockTypeName = "Название типа инфоблока";



    /**
     * @param $iblockType
     */
    public function __construct($iblockType) {
        $this->iblockTypeId = $iblockType;
        $this->setDefaultArParamsIblockType();
    }



    /**
     * @throws \Exception
     */
    public function migrate(){
        if (!$this->isExist()) {
            return $this->Add();
        }else{
            if ($this->isActionDelete() === true){
                return $this->Delete();
            }
            return $this->Update();
        }
    }


    /**
     * @return bool
     * @throws \Exception
     */
    protected function Add() {
        $code = $this->iblockTypeId;
        if (empty($code)) {
            return false;
        }
        $arFields = array_merge($this->getArFieldsEnity(),array('ID' => $code));
        global $DB;
        $DB->StartTransaction();

        $obBlocktype = new CIBlockType;
        $res = $obBlocktype->Add($arFields);
        if (!$res) {
            $DB->Rollback();
            $this->sendMessage('Тип ИБ - ' . $code . ' HE создан! ' . $obBlocktype->LAST_ERROR . '<br/>', 'ERR');
            throw new \Exception($obBlocktype->LAST_ERROR);
        }
        $DB->Commit();
        $this->sendMessage('Тип ИБ - ' . $code . ' создан!', 'OK');
        return true;
    }


    public function Update() {
        global $DB;
        $obBlocktype = new CIBlockType;
        $DB->StartTransaction();
        $res = $obBlocktype->Update($this->iblockTypeId, $this->getArFieldsEnity());
        if(!$res)
        {
            $DB->Rollback();
            $this->sendMessage('Типa ИБ - ' . $this->iblockTypeId . ' НЕ  удалось обновить!'.$obBlocktype->LAST_ERROR, 'ERR');
            return false;
        }
        $DB->Commit();
        $this->sendMessage('Типa ИБ - ' . $this->iblockTypeId . ' обновлен!', 'OK');
        return true;


    }

    public function Delete() {
        global $DB;
        $DB->StartTransaction();
        if(!CIBlockType::Delete($this->iblockTypeId))
        {
            $DB->Rollback();
            $this->sendMessage('Типa ИБ - ' . $this->iblockTypeId . ' НЕ  удалось удалить!', 'ERR');
            return false;
        }
        $DB->Commit();
        $this->sendMessage('Типa ИБ - ' . $this->iblockTypeId . ' удален!', 'OK');
        return true;
    }

    /**
     * @return bool
     */
    public function isExist() {
        $code = $this->iblockTypeId;
        if (empty($code)) {
            return false;
        }
        $arParams = array(
            'ORDER' => array(
                'SORT' => 'ASC'
            ),
            'FILTER' => array(
                '=ID' => $code
            )
        );

        $db = CIBlockType::GetList($arParams['ORDER'], $arParams['FILTER']);
        while ($result = $db->Fetch()) {
            $typeResult[] = $result;
        }

        if (!empty($typeResult)) {
            $this->sendMessage('Тип ИБ - ' . $code . ' существует!', 'INF');
            return true;
        } else {
            $this->sendMessage('Типa ИБ - ' . $code . ' НЕ существует!', 'ERR');
        }
        return false;
    }

    /**
     * @return string
     */
    public function getIblockTypeName() {
        return $this->iblockTypeName;
    }

    /**
     * @param string $iblockTypeName
     */
    public function setIblockTypeName($iblockTypeName) {
        $this->iblockTypeName = $iblockTypeName;
        $this->arFieldsEnity["LANG"]["ru"]["NAME"] = $this->iblockTypeName;
        $this->arFieldsEnity["LANG"]["en"]["NAME"] = Cutil::translit($this->iblockTypeName, "ru");
    }



    private function setDefaultArParamsIblockType() {
        $this->arParamsIblockType = array(
            'SECTIONS' => 'N',
            'IN_RSS' => 'N',
            'SORT' => '500',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'LANG' => Array(
                'ru' => Array(
                    'NAME' => $this->iblockTypeName,
                    'ELEMENT_NAME' => 'Элементы',
                    'SECTION_NAME' => 'Разделы',

                ),
                'en' => Array(
                    'NAME' => Cutil::translit($this->iblockTypeName, "ru"),
                    'ELEMENT_NAME' => 'Elemments',
                    'SECTION_NAME' => 'Sections',
                )
            )
        );
    }

}