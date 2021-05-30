<?php
/*
 * https://whois.wolnadomena.pl/whois.php?domain=softreck.com
 * http://localhost:8080/whois.php?domain=softreck.com
 */

// Load composer framework
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require(__DIR__ . '/vendor/autoload.php');
}

use phpWhois\Whois;

error_reporting(E_ERROR | E_PARSE);

/**
 * @param array $params
 */
function whois_data($params)
{
    $domain = '';
    $whois = [];
    $message = '';
    $status = false;

    try {

        if (!isset($params['domain'])) {
            throw new Exception("domain param not exist");
        }

        $domain = $params['domain'];

        if (empty($domain)) {
            throw new Exception("domain is empty");
        }

        $domain = strtolower($domain);

        $whois = new Whois();
        $result = $whois->lookup($domain, false);
        $whois = $result['regrinfo'];
        $status = true;

    } catch (Exception $e) {
        // Set HTTP response status code to: 500 - Internal Server Error
        $message = $e->getMessage();
    }

    return [
        "whois" => $whois,
        "message" => $message,
        "domain" => $domain,
        "status" => $status
    ];
}

