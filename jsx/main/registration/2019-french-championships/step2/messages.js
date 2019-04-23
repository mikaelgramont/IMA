const messages = (getText, getPlural) => (key) =>
  ({
    required: getText('Required') /* Label next to a form field indicating the user must provide that information */,
    invalid: getText('Invalid') /* Label next to a form field indicating the provided information is not valid */,

    lessThan1000: getText('Less than 1000') /* Error message indicating a rider's number must be less than 1000 */,
    pickOneOrMore: getText('Pick one or more') /* Indicates the user must choose at least one option */,

    registeredRidersAndPrice: getText('Registered rider(s) and price') /* Name of a section to enter the information for registered riders */,

    youCanRegisterOthers: getText('You can register yourself and/or other riders.') /* Paragraph indicating that it's possible to register more than one rider at a time. */,

    registeringIn: getText('Registering in') /* Label for a section containing a list of competitions a rider can take part in */,

    addRider: getText('Add Rider') /* Label for a button to add a registered rider */,
    removeRider: getText('Remove Rider') /* Label for a button to remove a registered rider */,

    riderCount: (riderCount) => getPlural('%d rider', '%d riders', riderCount),

    total: getText('Total') /* Total cost for all registered riders */,

    continue: getText('Continue') /* Label for a button to go to the next step */,

    category: getText('Category') /* Label for a field to choose a category */,
    chooseCategory: getText('Choose the rider\'s category') /* Label for a field listing categories */,
    categoryJunior: getText('Junior') /* Name of the Junior category */,
    categoryLadies: getText('Ladies') /* Name of the Ladies category */,
    categoryMasters: getText('Masters') /* Name of the Masters category */,
    categoryPro: getText('Pro') /* Name of the Pro category */,
    categoryNotRiding: getText('Not riding') /* Category for riders not competing */,

    country: getText('Country') /* Label for a field to choose a country the rider is competing for */,
    chooseCountry: getText('Choose the country they\'re riding for') /* Label for a field to choose a country the rider is competing for */,
  }[key]);

export default messages;
