<?php

namespace MyParcelNL\Magento\Model\Checkout;

use Magento\Framework\ObjectManagerInterface;

class ShippingInformationManagementPlugin
{

    protected $quoteRepository;
    private $objectManager;

    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        ObjectManagerInterface $objectManager
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->objectManager = $objectManager;
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param $cartId
     * @param \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ) {
//        $this->objectManager->get('Psr\Log\LoggerInterface')->debug('myparcel test1 ');
        $extAttributes = $addressInformation->getExtensionAttributes();
        if (! empty($extAttributes) && ! empty($extAttributes->getDeliveryOptions())) {
            $deliveryOptions = $extAttributes->getDeliveryOptions();
            $quote = $this->quoteRepository->getActive($cartId);
            $quote->setDeliveryOptions($deliveryOptions);
        }
    }
}
