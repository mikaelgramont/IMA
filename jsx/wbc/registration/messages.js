const messages = (getText, getPlural) => (key) =>
  ({
    title: getText('Registration form') /* Title of the registration form page */,
  }[key]);

export default messages;
