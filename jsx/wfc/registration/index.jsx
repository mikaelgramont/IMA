import React from 'react';
import ReactDOM  from 'react-dom';

import RegistrationForm from './form.jsx';

const props = window.__registrationConstants__;

ReactDOM.render((
  <RegistrationForm {...props} />
), document.getElementById('form-container'));