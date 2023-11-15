<?php

namespace Json\Forms;

use \Bitrix\Main\Engine\CurrentUser;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Application;
use \Bitrix\Main\SystemException;

/**
 * Class Api
 * @package Json\Forms
 */
class Api
{
    static $MODULE_ID = "json.forms";

    public static function setJsonOnBeforeResultAdd($WEB_FORM_ID, &$arFields, &$arrVALUES)
    {
        try
        {
            $path_files = $_SERVER["DOCUMENT_ROOT"] . Option::get("json.forms", "JF_PATH_JSON");
            $files_name = $WEB_FORM_ID . '_' . time() . '.json';
            file_put_contents($path_files . $files_name, json_encode($arrVALUES));
        }
        catch (SystemException $exception)
        {
            $e = $exception->getMessage();
            AddMessage2Log("\n".var_export($e, true). " \n \r\n ", "\Json\Forms\Api::setJsonOnBeforeResultAdd");
        }
    }
}