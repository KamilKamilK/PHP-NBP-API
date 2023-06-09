<?php

namespace Controller;

use Service\CurrencyService;

class CurrencyController
{
    private CurrencyService $service;

    public function __construct(CurrencyService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $rates = $this->service->getAllExchangeRatesFromDB();
        return $this->service->mapRates($rates);
    }

    public function store()
    {
        $rates = $this->service->saveAllExchangeRates();
        return $this->service->mapRates($rates);
    }

    public function exchange()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount'], $_POST['source_code'], $_POST['target_code'])) {
            $sourceCurrency = $this->service->getCurrencyByCode($_POST['source_code']);
            $targetCurrency = $this->service->getCurrencyByCode($_POST['target_code']);

            if ($sourceCurrency !== null && $targetCurrency !== null) {
                $convertedAmount = $_POST['amount'] * ($targetCurrency['exchange_rate'] / $sourceCurrency['exchange_rate']);
            }

            $this->service->saveConversion($_POST['source_code'], $_POST['target_code'], $_POST['amount'], round($convertedAmount, 2));
            $conversions = $this->service->getConversion();

            $mappedConversions = $this->service->mapConversion($conversions);

            return ['convertedAmount' => $convertedAmount,
                'conversions' => $mappedConversions];
        }
    }
}