const messages = (getText, getPlural) => (key) =>
  ({
    required: getText('Required') /* Label next to a form field indicating the user must provide that information */,
    invalid: getText('Invalid') /* Label next to a form field indicating the provided information is not valid */,

    yourInformation: getText('Your information') /* Title of a form section containing information about who is doing the registration */,
    firstName: getText('First name') /* Label of a form field containing a person's first name */,

    yourFirstName: getText('Your first name') /* Help text to tell the user to enter their first name */,

    lastName: getText('Last name') /* Label of a form field containing a person's last name */,
    yourLastName: getText('Your first name') /* Help text to tell the user to enter their last name */,

    email: getText('Email') /* Label of a form field containing a person's email */,
    yourEmail: getText('Your email') /* Help text to tell the user to enter their email */,

    continue: getText('Continue') /* Label for a button to go to the next step */,
  }[key]);

export default messages;
