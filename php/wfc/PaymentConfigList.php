<?php
class PaymentConfigList
{
  const OPEN = 'open';
  const NOT_OPEN_YET = 'not_open_yet';
  const CLOSED = 'closed';

  const BOARDERCROSS = 'boardercross';
  const SLALOM = 'slalom';
  const FREESTYLE = 'freestyle';

  const PAYMENT_MANDATORY = 'paymentMandatory';
  const PAYMENT_OPTIONAL = 'paymentOptional';
  const PAYMENT_NONE = 'paymentNone';

  const PAYPAL_SCRIPT_URL = 'https://www.paypal.com/sdk/js?currency=EUR&client-id=';

  const CDF_2019 = '1_cdf_2019';

  static function getConfig($key) {
    $config = new stdClass();
    $config->serverProcessingUrl = BASE_URL.'paypal-transaction-complete?XDEBUG_SESSION_START=PHPSTORM&key='.$key;
    $config->key = $key;
    $config->logFile = '../../logs/registrations-'. $key  .'.json';

    switch($key) {
      default:
        throw new Exception("No payment config found for key '$key'");
    }

    $config->paypalScript = self::PAYPAL_SCRIPT_URL . $config->paypalClientId;

    return $config;
  }
}