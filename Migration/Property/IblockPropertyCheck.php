<?php
/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 21.08.15
 * Time: 16:01
 */

namespace WS\Migration;


class IblockPropertyCheck extends IblockProperty{

    /**
     * @var array()
     */
    private $values = array(array("VALUE" => "Y","DEF" => "N","SORT" => "100"));

    /**
     * @param array $arFieldsEnity
     */
    public function setArFieldsEnity($arFieldsEnity){
        $arFieldsImportant = array(
            "PROPERTY_TYPE" => "L",
            "USER_TYPE" => "",
            "LIST_TYPE" => "C",
            "VALUES" => $this->values,
        );
        $this->arFieldsEnity = array_merge($arFieldsEnity,$arFieldsImportant);
    }


    /**
     * @param $value
     */
    public function setValue($value) {
        $this->values[]["VALUE"] = $value;
        $this->setArFieldsEnity($this->getArFieldsEnity());
    }

    /**
     * @param $value
     */
    public function setSort($value) {
        $this->values[]["SORT"] = $value;
        $this->setArFieldsEnity($this->getArFieldsEnity());
    }

    /**
     *
     */
    public function doDefaultActive() {
        $this->values[]["DEF"] = "Y";
        $this->setArFieldsEnity($this->getArFieldsEnity());
    }

    /**
     *
     */
    public function doDefaultNoActive() {
        $this->values[]["DEF"] = "N";
        $this->setArFieldsEnity($this->getArFieldsEnity());
    }



}
