const messages = (getText, getPlural) => (key) =>
  ({
    payment: getText('Payment') /* Name of a section where the user can start paying */,
    totalCost: (riderCount) => getPlural('The total cost for 1 rider is', 'The total cost for %d riders is', riderCount),
    onlinePaymentIsOptional: getText('Online payment is optional, you can register now and pay on-site at the event.') /* Message indicating the user may skip online payment */,
    wouldYouLikeToProceed: getText('Would you like to proceed with payment now?') /* Presents the user with the choice to pay or skip payment */,
    proceedWithPayment: getText('Proceed with payment') /* One of several payment options */,
    skipPayment: getText('Skip payment') /* One of several payment options */,
    continue: getText('Continue') /* Label for a button to go to the next step */,
  }[key]);

export default messages;
