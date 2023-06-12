<?php

namespace Interfaces;

interface ClientInterface
{
    public function getData();
    public function buildUrl(?string $table);
    public function logError(string $message);
}