<?php

namespace App\Service\Importer;

interface CustomerImporterInterface
{
    /**
     * Fetches an array of customers from the external API.
     */
    public function fetchCustomers(): array;
}
