<?php

namespace App\Http\Controllers\Logs\Filters;

use Exception;

class Utils
{
    /**
     * Convert filter name to the request valid param.
     *
     * @return string
     */
    public static function convertToParamName(string $name): string
    {
        if (false === strpos($name, '_')) {

            throw new Exception("The name param from {" . __METHOD__ . "} was invalid!");
        }

        $pieces  = explode('_', $name);

        return $pieces[0] . ucfirst($pieces[1]);
    }
}
