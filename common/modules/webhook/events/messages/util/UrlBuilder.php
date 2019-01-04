<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 23/11/2561
 * Time: 13:29
 */
namespace common\modules\webhook\events\messages\util;

use yii\web\Request;

class UrlBuilder
{
    public static function buildUrl(Request $req, array $paths)
    {
        // NOTE: You should configure $baseUri according to your environment
        // Perhaps, it is prefer to use $_SERVER['HTTP_HOST'], $_SERVER['HTTP_X_FORWARDED_HOST'] or etc
        $baseUri = $req->getBaseUrl();
        foreach ($paths as $path) {
            $baseUri .= '/' . urlencode($path);
        }
        return $baseUri;
    }
}