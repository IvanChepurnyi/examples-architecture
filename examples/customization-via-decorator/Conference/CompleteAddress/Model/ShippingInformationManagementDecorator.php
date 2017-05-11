<?php
/**
 * Copyright (c) EcomDev B.V., Ivan Chepurnyi
 * See LICENSE file for license details.
 */

namespace Conference\CompleteAddress\Model;

use Magento\Checkout\Api\ShippingInformationManagementInterface;
use Magento\Checkout\Api\Data\ShippingInformationInterface;

class ShippingInformationManagementDecorator implements ShippingInformationManagementInterface
{
    private $shippingInformationManagement;

    private $completableAddressFactory;

    private $completeService;

    public function __construct(
        ShippingInformationManagementInterface $shippingInformationManagement,
        MagentoCompletableAddressFactory $completableAddressFactory,
        CompleteService $completeService
    ) {
        $this->shippingInformationManagement = $shippingInformationManagement;
        $this->completableAddressFactory = $completableAddressFactory;
        $this->completeService = $completeService;
    }

    public function saveAddressInformation($cartId, ShippingInformationInterface $addressInformation)
    {
        $completableAddress = $this->completableAddressFactory->create(
            ['shippingInformation' => $addressInformation]
        );

        $this->completeService->completeAdddress($completableAddress);

        return $this->shippingInformationManagement->saveAddressInformation(
            $cartId,
            $addressInformation
        );
    }
}
