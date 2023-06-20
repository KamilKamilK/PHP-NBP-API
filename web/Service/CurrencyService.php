<?php

namespace Service;

use Client\NbpClient;
use Controller\CurrencyController;
use Repository\CurrencyRepository;

class CurrencyService
{
    public function handleRequest()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        $currencyService = new CurrencyService();
        $currencyController = new CurrencyController($currencyService);

        if ($path === '/' && $method === 'GET') {
            $data['rates'] = $currencyController->index();
            return $data;

        } elseif ($path === '/update' && $method === 'POST') {
            $data['rates'] = $currencyController->update();
            return $data;

        } elseif ($path === '/exchange' && $method === 'POST') {
            $data['converses'] = $currencyController->exchange();
            $data['rates'] = $currencyController->index();
            return $data;

        } else {
            http_response_code(404);
        }
    }

    public function getAllExchangeRatesFromNbp()
    {
        $client = new NbpClient();
        $response = $client->getData('A');

        return $response['rates'];
    }

    public function saveAllExchangeRates(): array
    {
        global $conn;
        $ratesFromNbp = $this->getAllExchangeRatesFromNbp();
        $ratesFromDB = $this->getAllExchangeRatesFromDB();


        $codesArrDB = [];
        foreach ($ratesFromDB as $rate) {
            $codesArrDB[] = $rate[2];
        }

        foreach ($ratesFromNbp as $rate) {
            $name = $rate['currency'];
            $code = $rate['code'];
            $exchangeRate = $rate['mid'];

            if (in_array($code, $codesArrDB)) {
                $sql = "UPDATE currency SET exchange_rate = ? WHERE currency_code = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ss', $exchangeRate, $code);
                $stmt->execute();
            } else {
                $sql = "INSERT INTO currency(name, currency_code, exchange_rate) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sss', $name, $code, $exchangeRate);
                $stmt->execute();
            }
        }

        return $this->getAllExchangeRatesFromDB();
    }

    public function getAllExchangeRatesFromDB(): array
    {
        $repository = new CurrencyRepository();
        return $repository->getAll();
    }

    public function mapRates($rates)
    {
        $mappedRates = array_map(function ($rate) {
            return [
                'id' => $rate[0],
                'currency_name' => $rate[1],
                'currency_code' => $rate[2],
                'exchange_rate' => $rate[3],
            ];
        }, $rates);

        return $mappedRates;
    }

    public function mapConversion($conversions)
    {
        $mapConversion = array_map(function ($conversion) {
            return [
                'id' => $conversion[0],
                'source_code' => $conversion[1],
                'target_code' => $conversion[2],
                'amount' => $conversion[3],
                'converted_amount' => $conversion[4],
                'created_at' => $conversion[5],
            ];
        }, $conversions);

        return $mapConversion;
    }

    public function getCurrencyByCode($code)
    {
        global $conn;
        $sql = "SELECT exchange_rate FROM currency WHERE currency_code = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $code);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function saveConversion($source_code, $target_code, $amount, $convertedAmount)
    {
        global $conn;
        $today = new \DateTime('now');
        $formattedDate = $today->format('Y-m-d H:i:s');
        $sql = "INSERT INTO conversions(source_code, target_code, amount, converted_amount, created_at) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $source_code, $target_code, $amount, $convertedAmount, $formattedDate);
        $stmt->execute();
    }

    public function getConversion(): array
    {
        $repository = new CurrencyRepository();
        return $repository->getAllConversions();
    }

    public function handleNotFoundResponse()
    {
        echo '<div class="container" style="display: flex; justify-content: center; align-items: center;">';
        echo '<h1>404 - Page not found</h1>';
        echo '</div>';
        exit;
    }
}