<?php
/**
 * Copyright (c) EcomDev B.V., Ivan Chepurnyi
 * See LICENSE file for license details.
 */

namespace Conference\CompleteAddress\Model;

use Magento\Checkout\Model\ShippingInformationManagement;

class ShippingInformationManagementPlugin
{
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

    public function beforeSaveAddressInformation(
        ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        $completableAddress = $this->completableAddressFactory->create(
            ['shippingInformation' => $addressInformation]
        );

        $this->completeService->completeAdddress($completableAddress);

        return [$cartId, $addressInformation];
    }
}
