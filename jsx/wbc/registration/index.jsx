import React from "react";
import ReactDOM from "react-dom";

import RegistrationForm from "./form.jsx";
import LocaleContext from "./LocaleContext";

const { language, translations, ...props } = window.__registrationConstants__;
const contextValue = { language, translations };

ReactDOM.render(
  <LocaleContext.Provider value={contextValue}>
    <RegistrationForm {...props} />
  </LocaleContext.Provider>,
  document.getElementById("form-container")
);
