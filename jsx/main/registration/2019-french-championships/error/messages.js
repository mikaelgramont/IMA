const messages = (getText, getPlural) => (key) =>
  ({
    paypalFailed: getText('Payment with Paypal failed, sorry!!') /* Message indicating registration payment did not work. */,
    tryAgain: getText('Please try again, or get in touch and mention the following message:') /* Introduces an error message to the user. */,
  }[key]);

export default messages;
