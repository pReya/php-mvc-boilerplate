<?php

class Config
{
    protected static $instance = null;

    protected static $configVars = [
        "defaultController" => "gameday",
        "defaultAction" => "index",
        "apiBaseUrl" => "https://www.openligadb.de/api/",
        "leagueSeason" => "2017",
    ];

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    public static function getConfig($name)
    {
        return isset(self::$configVars[$name]) ? self::$configVars[$name] : "";
    }

    protected function __clone()
    {
    }

    protected function __construct()
    {
    }

}