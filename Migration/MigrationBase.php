<?php

/**
 * Created by PhpStorm.
 * User: programmer
 * Date: 19.08.15
 * Time: 9:42
 */
namespace WS\Migration;

abstract class MigrationBase {

    /**
     * @var bool
     */
    protected $actionDelete = false;

    /**
     * @var array
     */
    protected $arFieldsEnity = array();



    public function sendMessage($mess, $type) {
        if (!empty($type) && !empty($mess)) {
            switch ($type) {
                case ('OK') :
                    echo '<p><font color="green">' . $mess . '</font></p>';
                    break;
                case ('ERR') :
                    echo '<p><font color="red">' . $mess . '</font></p>';
                    break;
                case ('INF') :
                    echo '<p><font color="gray">' . $mess . '</font></p>';
                    break;
            }
        }

        return false;
    }
    protected abstract function Add();

    protected abstract function Update();

    protected abstract function Delete();

    protected abstract function isExist();

    /**
     *
     */
    public function setMigrationForDelete(){
        $this->actionDelete = true;
    }

    /**
     * @return boolean
     */
    public function isActionDelete() {
        return $this->actionDelete;
    }

    /**
     * @return array
     */
    public function getArFieldsEnity() {
        return $this->arFieldsEnity;
    }

    /**
     * @param array $arFieldsEnity
     */
    public function setArFieldsEnity($arFieldsEnity) {
        if (is_array($arFieldsEnity)){
            $this->arFieldsEnity = $arFieldsEnity;
        }
    }
}