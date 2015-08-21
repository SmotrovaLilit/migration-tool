<?php
/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 21.08.15
 * Time: 16:01
 */

namespace WS\Migration;


class IblockPropertyList extends IblockProperty{

    /**
     * @var array()
     */
    private $values = array();

    /**
     * @param array $arFieldsEnity
     */
    public function setArFieldsEnity($arFieldsEnity){
        $arFieldsImportant = array(
            "PROPERTY_TYPE" => "L",
            "USER_TYPE" => "",
            "LIST_TYPE" => "L",
            "VALUES" => $this->values,
        );
        $this->arFieldsEnity = array_merge($arFieldsEnity,$arFieldsImportant);
    }


    /**
     * @return mixed
     */
    public function getValues() {
        return $this->values;
    }

    /**
     * @param mixed $values
     */
    public function setValues($values) {
        $this->values = $values;
        $this->setArFieldsEnity($this->getArFieldsEnity());

    }

    /**
     * @param $value
     * @param string $def
     * @param int $sort
     * @param string $xmlId
     */
    public function addValue($value,$def="N",$sort=100,$xmlId=""){
        if (empty($value)){
            return;
        }
        $this->values[] = array(
            "VALUE" => $value,
            "DEF" => $def,
            "SORT" => $sort,
            "XML_ID" => $xmlId,
        );
        $this->setArFieldsEnity($this->getArFieldsEnity());
    }


}
