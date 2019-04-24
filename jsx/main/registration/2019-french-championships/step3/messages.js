const messages = (getText, getPlural) => (key) =>
  ({
    payment: getText('Payment') /* Name of a section where the user can start paying */,
    totalCost: (riderCount) => getPlural('The total cost for 1 rider is', 'The total cost for %d riders is', riderCount),
  }[key]);

export default messages;
