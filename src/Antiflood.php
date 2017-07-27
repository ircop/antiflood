<?php
/**
 * Created by PhpStorm.
 * User: wingman
 * Date: 12.11.2015
 * Time: 22:31
 */

namespace Ircop\Antiflood;

class Antiflood
{
    /**
     * @param $ident
     * @return bool
     */
    public function check( $ident, $max = 1 )
    {
        if( !$ident )
            return true;

        $key = 'af:'.$ident;
        if( !\Cache::has( $key ) )
            return true;

        $count = \Cache::get( $key );
        if( !$count || !is_numeric($count) )
            return true;

        # Check actions count per `cache_time` minutes
        if( $count < $max )
            return true;

        return false;
    }
    /**
     * @return bool
     */
    public function checkIP( $max = 1 )
    {
        $key = 'af:' . $_SERVER['REMOTE_ADDR'];
        if( !\Cache::has( $key ) )
            return true;

        $count = \Cache::get( $key );
        if( !$count || !is_numeric($count) )
            return true;

        # Check actions count per `cache_time` minutes
        if( $count < $max )
            return true;

        return false;
    }

    /**
     * pushes identify key to cache
     *
     * @param     $ident
     * @param int $minutes
     */
    public function put( $ident, $minutes = 10 )
    {
        if( !$ident || !is_numeric($minutes) )
            return;

        $key = 'af:'.$ident;

        if( \Cache::has($key) && is_numeric(\Cache::get($key)) ) {
            \Cache::increment($key);
        } else {
            \Cache::put($key, 1, $minutes);
        }
    }

    /**
     * pushes identify key to cache
     *
     * @param int $minutes
     */
    public function putIP( $minutes = 10 )
    {
        $key = 'af:' . $_SERVER['REMOTE_ADDR'];

        if( \Cache::has($key) && is_numeric(\Cache::get($key)) ) {
            \Cache::increment($key);
        } else {
            \Cache::put($key, 1, $minutes);
        }
    }
}