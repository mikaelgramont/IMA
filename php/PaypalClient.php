<?php
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PaypalClient
{
  /**
   * Returns PayPal HTTP client instance with environment that has access
   * credentials context. Use this instance to invoke PayPal APIs, provided the
   * credentials have access.
   */
  public static function client()
  {
    return new PayPalHttpClient(self::environment());
  }

  /**
   * Set up and return PayPal PHP SDK environment with PayPal access credentials.
   * This sample uses SandboxEnvironment. In production, use ProductionEnvironment.
   */
  public static function environment()
  {
    $clientId = PAYPAL_CLIENT_ID;
    $clientSecret = PAYPAL_SECRET;
    return new SandboxEnvironment($clientId, $clientSecret);
  }
}