<?php
/**
 * Copyright (c) EcomDev B.V., Ivan Chepurnyi
 * See LICENSE file for license details.
 */

namespace Conference\CompleteAddress\Model;

interface CompletableAddress
{
    public function isComplete(): bool;

    public function getPostcode(): string;

    public function getHouseNumber(): string;

    public function complete(string $street, string $city);
}
