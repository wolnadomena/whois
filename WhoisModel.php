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
class WhoisModel
{
    public $params = [];

    private $domain = '';
    private $whois = [];
    private $message = '';
    private $status = false;

    /**
     * WhoisModel constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @param string $domain
     * @param array $whois
     * @param string $message
     * @param bool $status
     */
    public function setWhois($domain, array $whois, $message, $status)
    {
        $this->domain = $domain;
        $this->whois = $whois;
        $this->message = $message;
        $this->status = $status;
    }


    public function whois()
    {
        try {

            if (!isset($this->params['domain'])) {
                throw new Exception("domain param not exist");
            }

            $this->domain = $this->params['domain'];

            if (empty($this->domain)) {
                throw new Exception("domain is empty");
            }

            $this->domain = strtolower($this->domain);

            $whois = new Whois();
            $result = $whois->lookup($this->domain, false);
            $this->whois = $result['regrinfo'];
            $this->status = true;

        } catch (Exception $e) {
            // Set HTTP response status code to: 500 - Internal Server Error
            $this->message = $e->getMessage();
        }
    }

    public function getWhois()
    {
        return [
            "whois" => $this->whois,
            "message" => $this->message,
            "domain" => $this->domain,
            "status" => $this->status
        ];
    }

}

//$whois = new WhoisModel($_GET);
//var_dump(
//    $whois->getWhois()
//);
