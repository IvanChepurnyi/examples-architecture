<?php
/**
 * Copyright (c) EcomDev B.V., Ivan Chepurnyi
 * See LICENSE file for license details.
 */

namespace Conference\CompleteAddress\Model;

class CompleteService
{
    public function completeAdddress(CompletableAddress $address)
    {
        if ($address->isComplete()) {
            return;
        }

        $address->complete('Somestreet', 'Utrecht');
    }
}
