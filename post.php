<?php
/*
 * https://www.wolnadomena.pl/index.php?domain=softreck.com
 * http://localhost:8080/index.php?domain=softreck.com
 */

require("apifunc.php");
$html = '';


if (empty($_POST["domains"])) {
    $_POST["domains"] = "softreck.com";
}

try {

    if (isset($_POST["whois"])) {

        apifunc([
            'https://php.letjson.com/let_json.php',
            'https://php.defjson.com/def_json.php',
            'https://php.eachfunc.com/each_func.php',
            'https://domain.phpfunc.com/get_domain_by_url.php',
            'https://domain.phpfunc.com/clean_url.php',
            'https://domain.phpfunc.com/clean_url_multiline.php',

        ], function () {

            // Clean URL
            $domains = clean_url_multiline($_POST["domains"]);

            if (empty($domains)) {
                throw new Exception("domain list is empty");
            }

            $domain_list = array_values(array_filter(explode(PHP_EOL, $domains)));

            if (empty($domain_list)) {
                throw new Exception("domain list is empty");
            }

            $domain_nameserver_list = each_func($domain_list, function ($url) {

                if (empty($url)) return null;

                $url = clean_url($url);

                if (empty($url)) return null;

                if (!(strpos($url, "http://") === 0) && !(strpos($url, "https://") === 0)) {
                    $url = "http://" . $url;
                }

                $domain = get_domain_by_url($url);

                return "
 <div>
    <a href='$url' target='_blank'> $domain</a> 
    -
    <a class='whois' href='https://www.wolnadomena.pl/whois.php?domain=$domain' target='_blank'> - </a>
</div>
            ";
            });

            global $html;

            $html = implode("<br>", $domain_nameserver_list);
        });
    }

} catch (Exception $e) {
    // Set HTTP response status code to: 500 - Internal Server Error
    $html = $e->getMessage();
}
