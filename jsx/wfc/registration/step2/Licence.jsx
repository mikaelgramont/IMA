import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

import messages from "./messages";
import TranslateHOC from "../Translate.jsx";

class Licence extends Component {
  render() {
    const { name, t } = this.props;
    return (
      <Field
        name={`${name}.licence`}
        render={({ input, meta }) => (
          <Fragment>
            <label htmlFor={`${name}.licence`}>
              {t('licenceNumber')}
              {meta.touched &&
                meta.error && <span className="error">{meta.error}</span>}
            </label>
            <input
              type="text"
              id={`${name}.licence`}
              name="licence"
              placeholder={t('optionalLicence')}
              {...input}
            />
          </Fragment>
        )}
      />
    );
  }
}

export default TranslateHOC(messages)(Licence);