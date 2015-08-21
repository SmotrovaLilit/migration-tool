<?php
/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 21.08.15
 * Time: 16:01
 */

namespace WS\Migration;


class IblockPropertyNumber extends IblockProperty{


    public function setArFieldsEnity($arFieldsEnity){
        $arFieldsImportant = array(
            "PROPERTY_TYPE" => "N",
            "USER_TYPE" => "",
        );
        $this->arFieldsEnity = array_merge($arFieldsEnity,$arFieldsImportant);
    }

}