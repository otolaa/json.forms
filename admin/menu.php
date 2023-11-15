<?php

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;

loc::loadMessages(__FILE__);

if ($APPLICATION->GetGroupRight("json.forms") > "D") {

    require_once(Loader::getLocal('modules/json.forms/prolog.php'));

    // the types menu  dev.1c-bitrix.ru/api_help/main/general/admin.section/menu.php
    $aMenu = [
        "parent_menu" => "global_menu_settings", // global_menu_content - раздел "Контент" global_menu_settings - раздел "Настройки"
        "section" => "json.forms",
        "sort" => 300,
        "module_id" => "json.forms",
        "text" => 'Фиксирующий плагин',
        "title"=> 'Фиксирующий плагин: плагин должен фиксировать json данные веб-форм в файл',
        "icon" => "fileman_menu_icon", // sys_menu_icon bizproc_menu_icon util_menu_icon
        "page_icon" => "fileman_menu_icon", // sys_menu_icon bizproc_menu_icon util_menu_icon
        "items_id" => "menu_json_forms",
        "items" => [
            [
                "text" => 'Настройки плагина',
                "title" => 'Настройки плагина',
                "url" => "settings.php?mid=json.forms&lang=".LANGUAGE_ID,
            ],
        ]
    ];

    return $aMenu;
}

return false;