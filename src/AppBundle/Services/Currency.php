<?php

namespace AppBundle\Services;

use AppBundle\Exceptions\BadRequestException;
use AppBundle\Exceptions\NoAuthorizationActionException;
use AppBundle\Exceptions\UnauthorizedLoginException;
use AppBundle\Resources\Constants;
use Doctrine\Instantiator\Exception\UnexpectedValueException;
use Symfony\Component\HttpKernel\Tests\Controller;

class Currency {
    private $url;
    private $access_key;

    public function __construct($url, $access_key) {
        $this->url = $url;
        $this->access_key = $access_key;
    }

    public function checkCurrency($currency) {
        $ch = curl_init($this->url . 'currency_list.php?api_key=' . $this->access_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $symbols = json_decode($json, true);
        $count = 0;
        $found = false;
        while($count < sizeof($symbols["currencies"]) && !$found) {
            if ($symbols["currencies"][$count]["currency"] == $currency) {
                $found = true;
            }
            $count++;
        }
        if (!$found) {
            throw new BadRequestException('Currency is invalid!');
        }
    }

    public function convert($from, $to, $amount) {
        try {
            $ch = curl_init($this->url . 'currency.php?api_key=' . $this->access_key . "&from=" . $from . "&to=" . $to . "&amount=" . $amount);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);

            // Decode JSON response:
            $convert = json_decode($json, true);
        
            return $convert["amount"];
        } catch (Exception $e) {
            throw new BadRequestException("Couldnt make currency conversion!");
        }
    }
}