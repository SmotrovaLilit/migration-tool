<?php
/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 21.08.15
 * Time: 16:01
 */

namespace WS\Migration;


class IblockPropertyString extends IblockProperty{

    /**
     * @var
     */
    private $rowCount = 1;

    public function setArFieldsEnity($arFieldsEnity){
        $arFieldsImportant = array(
            "PROPERTY_TYPE" => "S",
            "USER_TYPE" => "",
            "ROW_COUNT" => $this->rowCount,
        );
        $this->arFieldsEnity = array_merge($arFieldsEnity,$arFieldsImportant);
    }

    /**
     * @return mixed
     */
    public function getRowCount() {
        return $this->rowCount;

    }

    /**
     * @param mixed $rowCount
     */
    public function setRowCount($rowCount) {
        $this->rowCount = $rowCount;
        $this->setArFieldsEnity($this->getArFieldsEnity());
    }
}