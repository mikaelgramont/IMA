import React, { Fragment } from "react";

import messages from './messages';
import TranslateHOC from '../Translate.jsx';

const Initial = ({onClick, t}) => (
  <Fragment>
    <div className="start-wrapper">
      <button
        type="button"
        className="start action-button"
        onClick={onClick}
      >
        {t('startRegistering')}
      </button>
    </div>
    <p className="tip">
      {t('youCanRegisterOthers')}
    </p>
  </Fragment>
);

export default TranslateHOC(messages)(Initial);