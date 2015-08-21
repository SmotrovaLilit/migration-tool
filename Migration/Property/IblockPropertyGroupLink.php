<?php
/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 21.08.15
 * Time: 16:01
 */

namespace WS\Migration;


class IblockPropertyGroupLink extends IblockProperty{

    /**
     * @var int
     */
    private $linkIblockId = 0;

    public function setArFieldsEnity($arFieldsEnity){
        $arFieldsImportant = array(
            "PROPERTY_TYPE" => "G",
            "USER_TYPE" => "",
            "LINK_IBLOCK_ID" => $this->linkIblockId,
        );
        $this->arFieldsEnity = array_merge($arFieldsEnity,$arFieldsImportant);
    }

    /**
     * @return int
     */
    public function getLinkIblockId() {
        return $this->linkIblockId;
    }

    /**
     * @param int $linkIblockId
     */
    public function setLinkIblockId($linkIblockId) {
        $this->linkIblockId = $linkIblockId;
        $this->setArFieldsEnity($this->getArFieldsEnity());
    }


}