<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Admin' => $baseDir . '/app/models/Admin.php',
    'Apis\\CoinWayApi' => $baseDir . '/app/models/Apis/CoinWayApi.php',
    'AvailableCurrency' => $baseDir . '/app/models/AvailableCurrency.php',
    'BroadCast' => $baseDir . '/app/models/BroadCast.php',
    'CMS' => $baseDir . '/app/models/CMS.php',
    'Company' => $baseDir . '/app/models/Company.php',
    'Config' => $baseDir . '/app/classes/Config.php',
    'Filters\\Filters\\CampaignCategoryFilter' => $baseDir . '/app/models/v2/Filters/Filters/CampaignCategoryFilter.php',
    'Filters\\Filters\\CampaignFilter' => $baseDir . '/app/models/v2/Filters/Filters/CampaignFilter.php',
    'Filters\\Filters\\DepositOrderFilter' => $baseDir . '/app/models/v2/Filters/Filters/DepositOrderFilter.php',
    'Filters\\Filters\\EarningFilter' => $baseDir . '/app/models/v2/Filters/Filters/EarningFilter.php',
    'Filters\\Filters\\Mt4TradesFilter' => $baseDir . '/app/models/v2/Filters/Filters/testFilter.php',
    'Filters\\Filters\\OrderFilter' => $baseDir . '/app/models/v2/Filters/Filters/OrderFilter.php',
    'Filters\\Filters\\SubscriptionOrderFilter' => $baseDir . '/app/models/v2/Filters/Filters/SubscriptionOrderFilter.php',
    'Filters\\Filters\\SupportTicketFilter' => $baseDir . '/app/models/v2/Filters/Filters/SupportTicketFilter.php',
    'Filters\\Filters\\TradingAccountFilter' => $baseDir . '/app/models/v2/Filters/Filters/TradingAccountFilter.php',
    'Filters\\Filters\\UserBankFilter' => $baseDir . '/app/models/v2/Filters/Filters/UserBankFilter.php',
    'Filters\\Filters\\UserDocumentFilter' => $baseDir . '/app/models/v2/Filters/Filters/UserDocumentFilter.php',
    'Filters\\Filters\\UserFilter' => $baseDir . '/app/models/v2/Filters/Filters/UserFilter.php',
    'Filters\\Filters\\WalletFilter' => $baseDir . '/app/models/v2/Filters/Filters/WalletFilter.php',
    'Filters\\Filters\\WithdrawalFilter' => $baseDir . '/app/models/v2/Filters/Filters/WithdrawalFilter.php',
    'Filters\\QueryFilter' => $baseDir . '/app/models/v2/Filters/QueryFilter.php',
    'Filters\\Traits\\Filterable' => $baseDir . '/app/models/v2/Filters/Traits/Filterable.php',
    'Filters\\Traits\\RangeFilterable' => $baseDir . '/app/models/v2/Filters/Traits/RangeFilterable.php',
    'Input' => $baseDir . '/app/classes/Input.php',
    'IspPoolsSchedule' => $baseDir . '/app/models/IspPoolsSchedule.php',
    'LevelIncomeReport' => $baseDir . '/app/models/LevelIncomeReport.php',
    'LicenseKey' => $baseDir . '/app/models/LicenseKey.php',
    'Location' => $baseDir . '/app/classes/Location.php',
    'MIS' => $baseDir . '/app/classes/MIS.php',
    'Mailer' => $baseDir . '/app/classes/Mailer.php',
    'MlmSales' => $baseDir . '/app/models/MlmSales.php',
    'MlmSetting' => $baseDir . '/app/models/MlmSetting.php',
    'Newsletter' => $baseDir . '/app/models/Newsletter.php',
    'Notifications' => $baseDir . '/app/models/Notifications.php',
    'Orders' => $baseDir . '/app/models/Orders.php',
    'PasswordReset' => $baseDir . '/app/models/PasswordReset.php',
    'Personalization' => $baseDir . '/app/models/v2/Personalization/Personalization.php',
    'Personalization\\Traits\\Placeholder' => $baseDir . '/app/models/v2/Personalization/Traits/Placeholder.php',
    'PoolsCommissionSchedule' => $baseDir . '/app/models/PoolsCommissionSchedule.php',
    'Products' => $baseDir . '/app/models/Products.php',
    'ProductsCategory' => $baseDir . '/app/models/ProductsCategory.php',
    'Redirect' => $baseDir . '/app/classes/Redirect.php',
    'SMS' => $baseDir . '/app/classes/SMS.php',
    'Session' => $baseDir . '/app/classes/Session.php',
    'SettlementTracker' => $baseDir . '/app/models/SettlementTracker.php',
    'SiteSettings' => $baseDir . '/app/models/SiteSettings.php',
    'SubscriptionOrder' => $baseDir . '/app/models/SubscriptionOrder.php',
    'SubscriptionPlan' => $baseDir . '/app/models/SubscriptionPlan.php',
    'SupportMessage' => $baseDir . '/app/models/SupportMessage.php',
    'SupportTicket' => $baseDir . '/app/models/SupportTicket.php',
    'Testimonials' => $baseDir . '/app/models/Testimonials.php',
    'Token' => $baseDir . '/app/classes/Token.php',
    'Upload' => $baseDir . '/app/classes/Upload.php',
    'User' => $baseDir . '/app/models/User.php',
    'Validator' => $baseDir . '/app/classes/Validator.php',
    'World\\City' => $baseDir . '/app/models/World/City.php',
    'World\\Country' => $baseDir . '/app/models/World/Country.php',
    'World\\State' => $baseDir . '/app/models/World/State.php',
    'app' => $baseDir . '/app/core/app.php',
    'classes\\Auth\\Auth' => $baseDir . '/app/classes/Auth.php',
    'controller' => $baseDir . '/app/core/controller.php',
    'operations' => $baseDir . '/app/core/operations.php',
    'v2\\Models\\AdminComment' => $baseDir . '/app/models/v2/Models/AdminComment.php',
    'v2\\Models\\Document' => $baseDir . '/app/models/v2/Models/Document.php',
    'v2\\Models\\ISPWallet' => $baseDir . '/app/models/v2/Models/ISPWallet.php',
    'v2\\Models\\Isp' => $baseDir . '/app/models/v2/Models/Isp.php',
    'v2\\Models\\UserDocument' => $baseDir . '/app/models/v2/Models/UserDocument.php',
    'v2\\Models\\UserWithdrawalMethod' => $baseDir . '/app/models/v2/Models/UserWithdrawalMethod.php',
    'v2\\Models\\Wallet' => $baseDir . '/app/models/v2/Models/Wallet.php',
    'v2\\Models\\Withdrawal' => $baseDir . '/app/models/v2/Models/Withdrawal.php',
    'v2\\Security\\TwoFactor' => $baseDir . '/app/models/v2/Security/TwoFactor.php',
    'v2\\Shop\\Contracts\\OrderInterface' => $baseDir . '/app/models/v2/Shop/Contracts/OrderInterface.php',
    'v2\\Shop\\Contracts\\PaymentMethodInterface' => $baseDir . '/app/models/v2/Shop/Contracts/PaymentMethodInterface.php',
    'v2\\Shop\\Payments\\CoinPay' => $baseDir . '/app/models/v2/Shop/Payments/CoinPay.php',
    'v2\\Shop\\Payments\\Paypal\\PayPal' => $baseDir . '/app/models/v2/Shop/Payments/Paypal/Paypal.php',
    'v2\\Shop\\Payments\\Paypal\\PaypalAgreement' => $baseDir . '/app/models/v2/Shop/Payments/Paypal/PaypalAgreement.php',
    'v2\\Shop\\Payments\\Paypal\\Subscription' => $baseDir . '/app/models/v2/Shop/Payments/Paypal/Subscription.php',
    'v2\\Shop\\Payments\\Paystack' => $baseDir . '/app/models/v2/Shop/Payments/Paystack.php',
    'v2\\Shop\\Shop' => $baseDir . '/app/models/v2/Shop/Shop.php',
    'v2\\Traits\\Wallet' => $baseDir . '/app/models/v2/Traits/Wallet.php',
);
