import React from 'react';

class AppContextValueObject {
  constructor(values) {
    this.values = {
      language: '',
      translations: {},
    };

    Object.keys(values).forEach((key) => {
      if (this.values.hasOwnProperty(key)) {
        this.values[key] = values[key];
      } else {
        throw new Error(`Trying to assign unknown property: ${key}`);
      }
    });
  }

  getValues() {
    return this.values;
  }
}

const AppContext = React.createContext(AppContextValueObject);

export default AppContext;