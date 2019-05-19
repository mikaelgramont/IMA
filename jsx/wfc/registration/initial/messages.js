const messages = (getText, getPlural) => (key) =>
  ({
    startRegistering: getText('Start Registering!') /* Label for the button to start registration for an event */,
    youCanRegisterOthers: getText('You can register yourself and/or other riders.') /* Paragraph indicating that it's possible to register more than one rider at a time. */,
  }[key]);

export default messages;
