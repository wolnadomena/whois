<?php
/*
 * https://whois.wolnadomena.pl/whois.php?domain=softreck.com
 * http://localhost:8080/whois.php?domain=softreck.com
 */

require("apifunc.php");

header('Content-Type: application/json');

apifunc([
    'https://php.defjson.com/def_json.php',
    'whois_data.php'
], function () {

    echo def_json("", whois_data($_GET));
});