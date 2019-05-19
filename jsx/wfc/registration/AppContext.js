import React from 'react';

const AppContext = React.createContext({
  language: null,
  translations: {},
});

export default AppContext;