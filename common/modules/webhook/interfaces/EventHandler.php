<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/11/2561
 * Time: 21:21
 */
namespace common\modules\webhook\interfaces;

interface EventHandler
{
    public function handle();
}