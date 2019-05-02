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
      case self::CDF_2019:
        $config->status = self::OPEN;
        $config->jsBundle = BASE_URL.'scripts/2019-french-championships-bundle.js';
        $config->languages = array('fr', 'en');

        $config->paymentType = self::PAYMENT_OPTIONAL;

        $config->paypalAccount = PAYPAL_ACCOUNT_CDF_2019;
        $config->paypalClientId = PAYPAL_CLIENT_ID_CDF_2019;
        $config->paypalSecret = PAYPAL_SECRET_CDF_2019;

        $config->costs = new stdClass();
        $config->costs->adultTotal = 50;
        $config->costs->adultEach = 25;
        $config->costs->kidTotal = 40;
        $config->costs->kidEach = 20;

        $config->deadline = '2019-05-20';
        $config->spreadSheetId = '1mWCEXVU7P2trUOC9PbP8SeQg23XPF2M8U5g6m89czNE';
        // Order must match columns in the spreadsheet
        $config->competitions = array(self::BOARDERCROSS, self::FREESTYLE);


        break;
      default:
        throw new Exception("No payment config found for key '$key'");
    }

    $config->paypalScript = self::PAYPAL_SCRIPT_URL . $config->paypalClientId;

    return $config;
  }
}