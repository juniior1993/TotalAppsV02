<?php

/*
 * DATABASE Connect
 */
define("CONF_DB_HOST", "localhost");
define("CONF_DB_USER", "root");
define("CONF_DB_PASS", "");
define("CONF_DB_NAME", "total_apps");

/*
 * DATA LAYER CONNECT
 */

/**
 * base TotalApps
 */
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "total_apps",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

/**
 * base TotalTranslator
 */
define("DATA_LAYER_CONFIG_TOTAL", [
    "driver" => "mysql",
    "host" => "54.233.240.58",
    "port" => "3306",
    "dbname" => "totaltranslator",
    "username" => "leitura",
    "passwd" => "(_leitura963_)",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);


/*
 * URL
 */
define("CONF_URL_SITE", "http://localhost/template_total");


/*
 * UTILS
 */
define("SITE", "Total Apps");


/*
 * Password
 */
define("CONF_PASSWORD_COST", ["cost" => 10]);
define("CONF_PASSWORD_ALGO", PASSWORD_DEFAULT);

/**
 * FOLDERS
 */

define("CONF_FILES_PATH", __DIR__ ."/../../files");