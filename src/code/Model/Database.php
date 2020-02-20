<?php

namespace TickX\Scraper\Model;

use Medoo\Medoo;

class Database
{
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_NAME = 'tickx';
    const DB_SERVER = '127.0.0.1';


    public static function getConnection()
    {
        return new Medoo([
            'database_type' => 'mysql',
            'database_name' => self::DB_NAME,
            'server'        => self::DB_SERVER,
            'username'      => self::DB_USER,
            'password'      => self::DB_PASS
        ]);
    }

}