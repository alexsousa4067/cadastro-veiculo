<?php

if (file_exists(__DIR__ . '/../../.env')) {
    //define as variaveis de ambiente
    $lines = file(__DIR__ . '/../../.env');
    foreach ($lines as $line) {
        $line = trim($line);
        if (!empty($line)) {
            putenv(trim($line));
        }
    }
}

/**
 * DATABASE
 */
define("CONF_DB_HOST", getenv("CONF_DB_HOST"));
define("CONF_DB_USER", getenv("CONF_DB_USER"));
define("CONF_DB_PASS", getenv("CONF_DB_PASS"));
define("CONF_DB_NAME", getenv("CONF_DB_NAME"));

/**
 * PROJECT URLs
 */
define("CONF_URL_BASE", getenv("CONF_URL_BASE"));

/**
 * SITE
 */
define("CONF_SITE_NAME", getenv("CONF_SITE_NAME"));
define("CONF_SITE_LANG", getenv("pt_BR"));

/**
 * DATES
 */
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y-m-d H:i:s");

/**
 * PASSWORD
 */
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["cost" => 10]);

/**
 * VIEW
 */
define("CONF_VIEW_EXT", "php");
define("CONF_VIEW_THEME", "site");

setlocale(LC_TIME, getenv("LOCALE"));
date_default_timezone_set(getenv("TIMEZONE"));