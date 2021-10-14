<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Composer\\InstalledVersions' => $vendorDir . '/composer/InstalledVersions.php',
    'Mollie\\Api\\CompatibilityChecker' => $baseDir . '/src/CompatibilityChecker.php',
    'Mollie\\Api\\Endpoints\\ChargebackEndpoint' => $baseDir . '/src/Endpoints/ChargebackEndpoint.php',
    'Mollie\\Api\\Endpoints\\CollectionEndpointAbstract' => $baseDir . '/src/Endpoints/CollectionEndpointAbstract.php',
    'Mollie\\Api\\Endpoints\\CustomerEndpoint' => $baseDir . '/src/Endpoints/CustomerEndpoint.php',
    'Mollie\\Api\\Endpoints\\CustomerPaymentsEndpoint' => $baseDir . '/src/Endpoints/CustomerPaymentsEndpoint.php',
    'Mollie\\Api\\Endpoints\\EndpointAbstract' => $baseDir . '/src/Endpoints/EndpointAbstract.php',
    'Mollie\\Api\\Endpoints\\InvoiceEndpoint' => $baseDir . '/src/Endpoints/InvoiceEndpoint.php',
    'Mollie\\Api\\Endpoints\\MandateEndpoint' => $baseDir . '/src/Endpoints/MandateEndpoint.php',
    'Mollie\\Api\\Endpoints\\MethodEndpoint' => $baseDir . '/src/Endpoints/MethodEndpoint.php',
    'Mollie\\Api\\Endpoints\\OnboardingEndpoint' => $baseDir . '/src/Endpoints/OnboardingEndpoint.php',
    'Mollie\\Api\\Endpoints\\OrderEndpoint' => $baseDir . '/src/Endpoints/OrderEndpoint.php',
    'Mollie\\Api\\Endpoints\\OrderLineEndpoint' => $baseDir . '/src/Endpoints/OrderLineEndpoint.php',
    'Mollie\\Api\\Endpoints\\OrderPaymentEndpoint' => $baseDir . '/src/Endpoints/OrderPaymentEndpoint.php',
    'Mollie\\Api\\Endpoints\\OrderRefundEndpoint' => $baseDir . '/src/Endpoints/OrderRefundEndpoint.php',
    'Mollie\\Api\\Endpoints\\OrganizationEndpoint' => $baseDir . '/src/Endpoints/OrganizationEndpoint.php',
    'Mollie\\Api\\Endpoints\\PaymentCaptureEndpoint' => $baseDir . '/src/Endpoints/PaymentCaptureEndpoint.php',
    'Mollie\\Api\\Endpoints\\PaymentChargebackEndpoint' => $baseDir . '/src/Endpoints/PaymentChargebackEndpoint.php',
    'Mollie\\Api\\Endpoints\\PaymentEndpoint' => $baseDir . '/src/Endpoints/PaymentEndpoint.php',
    'Mollie\\Api\\Endpoints\\PaymentLinkEndpoint' => $baseDir . '/src/Endpoints/PaymentLinkEndpoint.php',
    'Mollie\\Api\\Endpoints\\PaymentRefundEndpoint' => $baseDir . '/src/Endpoints/PaymentRefundEndpoint.php',
    'Mollie\\Api\\Endpoints\\PermissionEndpoint' => $baseDir . '/src/Endpoints/PermissionEndpoint.php',
    'Mollie\\Api\\Endpoints\\ProfileEndpoint' => $baseDir . '/src/Endpoints/ProfileEndpoint.php',
    'Mollie\\Api\\Endpoints\\ProfileMethodEndpoint' => $baseDir . '/src/Endpoints/ProfileMethodEndpoint.php',
    'Mollie\\Api\\Endpoints\\RefundEndpoint' => $baseDir . '/src/Endpoints/RefundEndpoint.php',
    'Mollie\\Api\\Endpoints\\SettlementPaymentEndpoint' => $baseDir . '/src/Endpoints/SettlementPaymentEndpoint.php',
    'Mollie\\Api\\Endpoints\\SettlementsEndpoint' => $baseDir . '/src/Endpoints/SettlementsEndpoint.php',
    'Mollie\\Api\\Endpoints\\ShipmentEndpoint' => $baseDir . '/src/Endpoints/ShipmentEndpoint.php',
    'Mollie\\Api\\Endpoints\\SubscriptionEndpoint' => $baseDir . '/src/Endpoints/SubscriptionEndpoint.php',
    'Mollie\\Api\\Endpoints\\WalletEndpoint' => $baseDir . '/src/Endpoints/WalletEndpoint.php',
    'Mollie\\Api\\Exceptions\\ApiException' => $baseDir . '/src/Exceptions/ApiException.php',
    'Mollie\\Api\\Exceptions\\IncompatiblePlatform' => $baseDir . '/src/Exceptions/IncompatiblePlatform.php',
    'Mollie\\Api\\Exceptions\\UnrecognizedClientException' => $baseDir . '/src/Exceptions/UnrecognizedClientException.php',
    'Mollie\\Api\\HttpAdapter\\CurlMollieHttpAdapter' => $baseDir . '/src/HttpAdapter/CurlMollieHttpAdapter.php',
    'Mollie\\Api\\HttpAdapter\\Guzzle6And7MollieHttpAdapter' => $baseDir . '/src/HttpAdapter/Guzzle6And7MollieHttpAdapter.php',
    'Mollie\\Api\\HttpAdapter\\Guzzle6And7RetryMiddlewareFactory' => $baseDir . '/src/HttpAdapter/Guzzle6And7RetryMiddlewareFactory.php',
    'Mollie\\Api\\HttpAdapter\\MollieHttpAdapterInterface' => $baseDir . '/src/HttpAdapter/MollieHttpAdapterInterface.php',
    'Mollie\\Api\\HttpAdapter\\MollieHttpAdapterPicker' => $baseDir . '/src/HttpAdapter/MollieHttpAdapterPicker.php',
    'Mollie\\Api\\HttpAdapter\\MollieHttpAdapterPickerInterface' => $baseDir . '/src/HttpAdapter/MollieHttpAdapterPickerInterface.php',
    'Mollie\\Api\\MollieApiClient' => $baseDir . '/src/MollieApiClient.php',
    'Mollie\\Api\\Resources\\BaseCollection' => $baseDir . '/src/Resources/BaseCollection.php',
    'Mollie\\Api\\Resources\\BaseResource' => $baseDir . '/src/Resources/BaseResource.php',
    'Mollie\\Api\\Resources\\Capture' => $baseDir . '/src/Resources/Capture.php',
    'Mollie\\Api\\Resources\\CaptureCollection' => $baseDir . '/src/Resources/CaptureCollection.php',
    'Mollie\\Api\\Resources\\Chargeback' => $baseDir . '/src/Resources/Chargeback.php',
    'Mollie\\Api\\Resources\\ChargebackCollection' => $baseDir . '/src/Resources/ChargebackCollection.php',
    'Mollie\\Api\\Resources\\CurrentProfile' => $baseDir . '/src/Resources/CurrentProfile.php',
    'Mollie\\Api\\Resources\\CursorCollection' => $baseDir . '/src/Resources/CursorCollection.php',
    'Mollie\\Api\\Resources\\Customer' => $baseDir . '/src/Resources/Customer.php',
    'Mollie\\Api\\Resources\\CustomerCollection' => $baseDir . '/src/Resources/CustomerCollection.php',
    'Mollie\\Api\\Resources\\Invoice' => $baseDir . '/src/Resources/Invoice.php',
    'Mollie\\Api\\Resources\\InvoiceCollection' => $baseDir . '/src/Resources/InvoiceCollection.php',
    'Mollie\\Api\\Resources\\Issuer' => $baseDir . '/src/Resources/Issuer.php',
    'Mollie\\Api\\Resources\\IssuerCollection' => $baseDir . '/src/Resources/IssuerCollection.php',
    'Mollie\\Api\\Resources\\Mandate' => $baseDir . '/src/Resources/Mandate.php',
    'Mollie\\Api\\Resources\\MandateCollection' => $baseDir . '/src/Resources/MandateCollection.php',
    'Mollie\\Api\\Resources\\Method' => $baseDir . '/src/Resources/Method.php',
    'Mollie\\Api\\Resources\\MethodCollection' => $baseDir . '/src/Resources/MethodCollection.php',
    'Mollie\\Api\\Resources\\MethodPrice' => $baseDir . '/src/Resources/MethodPrice.php',
    'Mollie\\Api\\Resources\\MethodPriceCollection' => $baseDir . '/src/Resources/MethodPriceCollection.php',
    'Mollie\\Api\\Resources\\Onboarding' => $baseDir . '/src/Resources/Onboarding.php',
    'Mollie\\Api\\Resources\\Order' => $baseDir . '/src/Resources/Order.php',
    'Mollie\\Api\\Resources\\OrderCollection' => $baseDir . '/src/Resources/OrderCollection.php',
    'Mollie\\Api\\Resources\\OrderLine' => $baseDir . '/src/Resources/OrderLine.php',
    'Mollie\\Api\\Resources\\OrderLineCollection' => $baseDir . '/src/Resources/OrderLineCollection.php',
    'Mollie\\Api\\Resources\\Organization' => $baseDir . '/src/Resources/Organization.php',
    'Mollie\\Api\\Resources\\OrganizationCollection' => $baseDir . '/src/Resources/OrganizationCollection.php',
    'Mollie\\Api\\Resources\\Payment' => $baseDir . '/src/Resources/Payment.php',
    'Mollie\\Api\\Resources\\PaymentCollection' => $baseDir . '/src/Resources/PaymentCollection.php',
    'Mollie\\Api\\Resources\\PaymentLink' => $baseDir . '/src/Resources/PaymentLink.php',
    'Mollie\\Api\\Resources\\PaymentLinkCollection' => $baseDir . '/src/Resources/PaymentLinkCollection.php',
    'Mollie\\Api\\Resources\\Permission' => $baseDir . '/src/Resources/Permission.php',
    'Mollie\\Api\\Resources\\PermissionCollection' => $baseDir . '/src/Resources/PermissionCollection.php',
    'Mollie\\Api\\Resources\\Profile' => $baseDir . '/src/Resources/Profile.php',
    'Mollie\\Api\\Resources\\ProfileCollection' => $baseDir . '/src/Resources/ProfileCollection.php',
    'Mollie\\Api\\Resources\\Refund' => $baseDir . '/src/Resources/Refund.php',
    'Mollie\\Api\\Resources\\RefundCollection' => $baseDir . '/src/Resources/RefundCollection.php',
    'Mollie\\Api\\Resources\\ResourceFactory' => $baseDir . '/src/Resources/ResourceFactory.php',
    'Mollie\\Api\\Resources\\Settlement' => $baseDir . '/src/Resources/Settlement.php',
    'Mollie\\Api\\Resources\\SettlementCollection' => $baseDir . '/src/Resources/SettlementCollection.php',
    'Mollie\\Api\\Resources\\Shipment' => $baseDir . '/src/Resources/Shipment.php',
    'Mollie\\Api\\Resources\\ShipmentCollection' => $baseDir . '/src/Resources/ShipmentCollection.php',
    'Mollie\\Api\\Resources\\Subscription' => $baseDir . '/src/Resources/Subscription.php',
    'Mollie\\Api\\Resources\\SubscriptionCollection' => $baseDir . '/src/Resources/SubscriptionCollection.php',
    'Mollie\\Api\\Types\\InvoiceStatus' => $baseDir . '/src/Types/InvoiceStatus.php',
    'Mollie\\Api\\Types\\MandateMethod' => $baseDir . '/src/Types/MandateMethod.php',
    'Mollie\\Api\\Types\\MandateStatus' => $baseDir . '/src/Types/MandateStatus.php',
    'Mollie\\Api\\Types\\OnboardingStatus' => $baseDir . '/src/Types/OnboardingStatus.php',
    'Mollie\\Api\\Types\\OrderLineStatus' => $baseDir . '/src/Types/OrderLineStatus.php',
    'Mollie\\Api\\Types\\OrderLineType' => $baseDir . '/src/Types/OrderLineType.php',
    'Mollie\\Api\\Types\\OrderStatus' => $baseDir . '/src/Types/OrderStatus.php',
    'Mollie\\Api\\Types\\PaymentMethod' => $baseDir . '/src/Types/PaymentMethod.php',
    'Mollie\\Api\\Types\\PaymentMethodStatus' => $baseDir . '/src/Types/PaymentMethodStatus.php',
    'Mollie\\Api\\Types\\PaymentStatus' => $baseDir . '/src/Types/PaymentStatus.php',
    'Mollie\\Api\\Types\\ProfileStatus' => $baseDir . '/src/Types/ProfileStatus.php',
    'Mollie\\Api\\Types\\RefundStatus' => $baseDir . '/src/Types/RefundStatus.php',
    'Mollie\\Api\\Types\\SequenceType' => $baseDir . '/src/Types/SequenceType.php',
    'Mollie\\Api\\Types\\SettlementStatus' => $baseDir . '/src/Types/SettlementStatus.php',
    'Mollie\\Api\\Types\\SubscriptionStatus' => $baseDir . '/src/Types/SubscriptionStatus.php',
    '_PhpScoper49d996c9b91b\\Composer\\CaBundle\\CaBundle' => $vendorDir . '/composer/ca-bundle/src/CaBundle.php',
);
