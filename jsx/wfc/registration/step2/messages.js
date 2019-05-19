const messages = (getText, getPlural) => (key) =>
  ({
    required: getText('Required') /* Label next to a form field indicating the user must provide that information */,
    invalid: getText('Invalid') /* Label next to a form field indicating the provided information is not valid */,

    lessThan1000: getText('Less than 1000') /* Error message indicating a rider's number must be less than 1000 */,
    pickOneOrMore: getText('Pick one or more') /* Indicates the user must choose at least one option */,

    registeredRidersAndPrice: getText('Registered rider(s) and price') /* Name of a section to enter the information for registered riders */,

    youCanRegisterOthers: getText('You can register yourself and/or other riders.') /* Paragraph indicating that it's possible to register more than one rider at a time. */,

    registeringFor: getText('Registering for') /* Label for a section containing a list of competitions a rider can take part in */,

    addRider: getText('Add Rider') /* Label for a button to add a registered rider */,
    removeRider: getText('Remove Rider') /* Label for a button to remove a registered rider */,

    riderCount: (riderCount) => getPlural('%d rider', '%d riders', riderCount),

    total: getText('Total') /* Total cost for all registered riders */,

    continue: getText('Continue') /* Label for a button to go to the next step */,

    special: getText('Special') /* Name of a section for special information */,

    category: getText('Category') /* Label for a field to choose a category */,
    chooseCategory: getText('Choose the rider\'s category') /* Label for a field listing categories */,
    under14: getText('Under 14') /* Name of the category for riders younger than 14*/,
    under18: getText('Under 18') /* Name of the category for riders younger than 18 */,
    junior: getText('Junior') /* Name of the Junior category */,
    ladies: getText('Ladies') /* Name of the Ladies category */,
    masters: getText('Masters') /* Name of the Masters category */,
    pro: getText('Pro') /* Name of the Pro category */,

    country: getText('Country') /* Label for a field to choose a country the rider is competing for */,
    chooseCountry: getText('Choose the country they\'re riding for') /* Label for a field to choose a country the rider is competing for */,

    firstName: getText('First name') /* Label of a form field containing a person's first name */,
    lastName: getText('Last name') /* Label of a form field containing a person's last name */,
    ridersFirstName: getText('Enter the rider\'s first name') /* Help text to tell the user whose first name should be entered */,
    ridersLastName: getText('Enter the rider\'s last name') /* Help text to tell the user whose last name should be entered */,

    riderNumber: getText('Rider number') /* Label for a field to choose a rider's flag number */,
    optionalNumber: getText('Optional number') /* Indicates choosing a rider's number is not mandatory */,

    licenceNumber: getText('Licence number') /* Label for a field to enter a rider's licence number */,
    optionalLicence: getText('Optional FFRS licence number') /* Indicates choosing a rider's licence is not mandatory */,

    rider: getText('Rider') /* Indicates the rider's number in the list */,

    freestyle: getText('Freestyle') /* A competition type */,
    slalom: getText('Slalom') /* A competition type */,
    boardercross: getText('Boardercross') /* A competition type */,
    notRiding: getText('Not riding') /* Indicates a person does not intend to ride, but is registering anyway */,

    shirtSize: getText('Shirt size') /* Label for a field to choose a T-shirt size for the rider */,
    chooseTheirShirtSize: getText('Choose their shirt size') /* Label for a field to choose a T-shirt size for the rider */,

    comment: getText('Comment') /* Label for a field to leave an optional comment */,
    optionalComment: getText('You may leave a note to tell us something important') /* Label for a field to leave an optional comment */,
  }[key]);

export default messages;
