import React from 'react';

const LocaleContext = React.createContext({
  language: null,
  translations: {},
});

export default LocaleContext;