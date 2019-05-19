const messages = (getText, getPlural) => (key) =>
  ({
    finish: getText('Finish') /* Name of the last registration form section */,
    success: getText('Congratulations! Registration was successful!') /* Message displayed when registration was successful */,
    youWereCharged: getText('You were charged {total} in transaction number') /* Payment summary message */,
    registeredList: getText('The following riders are now registered:') /* Label for a list of registered riders */,
    slalom: getText('Slalom') /* A type of competition */,
    boardercross: getText('Boardercross') /* A type of competition */,
    freestyle: getText('Freestyle') /* A type of competition */,
    seeYouThere: getText('See you there!') /* A friendly message */,
    name: getText('Name') /* Indicates the name of a registered rider */,
    country: getText('Country') /* Indicates a registered rider's country */,
    riderNumber: getText('Rider Number') /* Indicates a registered rider's number */,
    ridingInCategory: getText('Riding in category') /* Indicates a registered rider's category */,
    registeredIn: getText('Registered in') /* Indicates the competitions a rider is registered in */,
  }[key]);

export default messages;
