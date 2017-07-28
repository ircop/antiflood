<?php
/**
 * Created by PhpStorm.
 * User: wingman
 * Date: 12.11.2015
 * Time: 22:33
 */

namespace Ircop\Antiflood\Facade;

use Illuminate\Support\Facades\Facade;

class Antiflood extends Facade
{
    protected static function getFacadeAccessor() { return 'antiflood'; }
}