<?php

namespace Client;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class NbpClient
{
    const NBP_URL = 'http://api.nbp.pl/api';
    const HEADERS = ['Accept' => 'application/json'];

    public function getCurrentExchangeRates($table)
    {
        $url = $this->buildUrl($table);
        $response = $this->sendRequest($url);

        if (empty($response) || $response === '404 NotFound') {
            throw new Exception('Something wrong with response from NBP');
        }

        $response = json_decode($response, true);

//        var_dump($response[0]);
        return $response[0] ;
    }

    public function buildUrl($table)
    {
        return self::NBP_URL . '/exchangerates/tables/' . $table;
    }

    public function sendRequest($url): string
    {
        $client = new Client();

        $retryAttempt = 3;
        for ($attempt = 1; $attempt <= $retryAttempt; $attempt++) {
            try {
                $response = $client->request('GET', $url, self::HEADERS);
            } catch (RequestException $e){
                echo "Wystąpił błąd żądania HTTP: " . $e->getMessage();
            }

            $httpCode = $response->getStatusCode();

            if ($httpCode !== 200) {
                if ($attempt < $retryAttempt) {
                    $this->logError("Attempt $attempt: Request failed with status code $httpCode. Retrying after 5 seconds...");
                    sleep(5);
                }
            }
        }

        return $response->getBody()->getContents();
    }

    function logError($message): void
    {
        $logFile = '/srv/www/api/error.log';
        $timestamp = date('Y-m-d H:i:s');
        $errorLog = "$timestamp: $message\n";

        file_put_contents($logFile, $errorLog, FILE_APPEND);
    }
}