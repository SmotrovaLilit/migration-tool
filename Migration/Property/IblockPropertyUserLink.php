<?php
/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 21.08.15
 * Time: 16:01
 */

namespace WS\Migration;


class IblockPropertyUserLink extends IblockProperty{


    /**
     * @param array $arFieldsEnity
     */
    public function setArFieldsEnity($arFieldsEnity){
        $arFieldsImportant = array(
            "PROPERTY_TYPE" => "S",
            "USER_TYPE" => "UserID",
        );
        $this->arFieldsEnity = array_merge($arFieldsEnity,$arFieldsImportant);
    }


}