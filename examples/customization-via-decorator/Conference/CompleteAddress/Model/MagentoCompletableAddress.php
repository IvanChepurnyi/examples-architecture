<?php
/**
 * Copyright (c) EcomDev B.V., Ivan Chepurnyi
 * See LICENSE file for license details.
 */

namespace Conference\CompleteAddress\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;

class MagentoCompletableAddress implements CompletableAddress
{
    private $shippingInformation;

    public function __construct(ShippingInformationInterface $shippingInformation)
    {
        $this->shippingInformation = $shippingInformation;
    }

    public function isComplete(): bool
    {
        return !empty($this->getShippingAddress()->getCity())
            && count($this->getShippingAddress()->getStreet()) > 1;
    }

    public function getPostcode(): string
    {
        return $this->getShippingAddress()->getPostcode();
    }

    public function getHouseNumber(): string
    {
        return $this->getShippingAddress()->getStreet()[0];
    }

    public function complete(string $street, string $city)
    {
        $this->getShippingAddress()->setCity($city);
        $this->getShippingAddress()->setStreet([
            $this->getShippingAddress()->getStreet()[0],
            $street
        ]);
    }

    private function getShippingAddress(): \Magento\Quote\Api\Data\AddressInterface
    {
        return $this->shippingInformation->getShippingAddress();
    }
}
