<?php
class PaymentConfigList
{
  const OPEN = 'open';
  const NOT_OPEN_YET = 'not_open_yet';
  const CLOSED = 'closed';

  const BOARDERCROSS = 'boardercross';
  const SLALOM = 'slalom';
  const FREESTYLE = 'freestyle';
  const DOWNHILL = 'downhill';

  const PAYMENT_MANDATORY = 'paymentMandatory';
  const PAYMENT_OPTIONAL = 'paymentOptional';
  const PAYMENT_NONE = 'paymentNone';

  const PAYPAL_SCRIPT_URL = 'https://www.paypal.com/sdk/js?currency=EUR&client-id=';

  const CDF_2019 = '1_cdf_2019';
  const WFC_2019 = '2_wfc_2019';

  static function getConfig($key) {
    $config = new stdClass();
    $config->serverProcessingUrl = BASE_URL.'paypal-transaction-complete?key='.$key;
    $config->serverProcessingUrl = BASE_URL.'paypal-transaction-complete?XDEBUG_SESSION_START=PHPSTORM&key='.$key;
    $config->key = $key;
    $config->logFile = '../logs/registrations-'. $key  .'.json';

    switch($key) {
      case self::CDF_2019:
        $config->status = self::OPEN;
        $config->jsBundle = BASE_URL.'scripts/2019-french-championships-bundle.js';
        $config->poster = BASE_URL.'images/registrations/CdF-2019.jpg';
        $config->posterSmall = BASE_URL.'images/registrations/CdF-2019-m.jpg';
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
        $config->additionalTextFields = array('licence', 'shirtSize', 'comment');

        break;
      case self::WFC_2019:
        $config->status = self::OPEN;
        $config->jsBundle = BASE_URL.'scripts/registration-bundle.js';
        $config->poster = BASE_URL.'images/poster.jpg';
        $config->posterSmall = BASE_URL.'images/poster.jpg';
        $config->languages = array('en');

        $config->paymentType = self::PAYMENT_OPTIONAL;

        $config->paypalAccount = PAYPAL_ACCOUNT_WFC_2019;
        $config->paypalClientId = PAYPAL_CLIENT_ID_WFC_2019;
        $config->paypalSecret = PAYPAL_SECRET_WFC_2019;

        $config->costs = new stdClass();
        $config->costs->online = 35;
        $config->costs->onsite = 40;

        $config->deadline = '2019-07-18';
        $config->spreadSheetId = '1_EyP3om_4al0q_i6lo6pHg6Epw-kCvjUTi1ZRWmcCiI';
        // Order must match columns in the spreadsheet
        $config->competitions = array(self::SLALOM, self::FREESTYLE);
        $config->additionalTextFields = array();

        break;
      default:
        throw new Exception("No payment config found for key '$key'");
    }

    $config->paypalScript = self::PAYPAL_SCRIPT_URL . $config->paypalClientId;

    return $config;
  }
}