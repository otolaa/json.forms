<?php
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Config\Option;

loc::loadMessages(__FILE__);

Class json_forms extends CModule
{
    public $MODULE_ID = "json.forms";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_CSS;

    public function __construct()
    {
        $arModuleVersion = [];
        include(__DIR__.'/version.php');
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("jf_module_name");
        $this->MODULE_DESCRIPTION = Loc::getMessage("jf_module_desc");
        $this->PARTNER_NAME = 'Alex Noodles';
        $this->PARTNER_URI = '//github.com/otolaa';
    }

    public function getPageLocal($page)
    {
        return str_replace('index.php', $page, Loader::getLocal('modules/'.$this->MODULE_ID.'/install/index.php'));
    }

    public function getStringText($obj)
    {
        return is_array($obj)?implode('<br>', $obj):$obj;
    }

    public function InstallFiles($arParams = [])
    {
        CopyDirFiles($this->getPageLocal('admin'), $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
        CheckDirPath($_SERVER["DOCUMENT_ROOT"]."/upload/json_forms/"); // Проверяет физическое существование указанного пути. При необходимости - создает все каталоги входящие в данный путь.
        return true;
    }

    public function UnInstallFiles()
    {
        DeleteDirFiles($this->getPageLocal('admin'), $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
        return true;
    }

    public function DoInstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
        $this->InstallFiles();
        Option::set($this->MODULE_ID, 'JF_PATH_JSON', '/upload/json_forms/');

        $eventManager = Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandler(
            'form',
            'onBeforeResultAdd',
            $this->MODULE_ID,
            '\Json\Forms\Api',
            'setJsonOnBeforeResultAdd'
        );

        $APPLICATION->IncludeAdminFile("Установка модуля ".$this->MODULE_ID, $this->getPageLocal('step.php'));
        return true;
    }

    public function DoUninstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
        $this->UnInstallFiles();
        Option::delete($this->MODULE_ID); // Will remove all module variables
        $APPLICATION->IncludeAdminFile("Деинсталляция модуля ".$this->MODULE_ID, $this->getPageLocal('unstep.php'));
        return true;
    }
}