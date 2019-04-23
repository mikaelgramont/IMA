import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

import messages from "./messages";
import TranslateHOC from "../Translate.jsx";

class Number extends Component {
  render() {
    const { name, t } = this.props;
    return (
      <Field
        name={`${name}.number`}
        render={({ input, meta }) => (
          <Fragment>
            <label htmlFor={`${name}.number`}>
              {t('riderNumber')}
              {meta.touched &&
                meta.error && <span className="error">{meta.error}</span>}
            </label>
            <input
              type="text"
              id={`${name}.number`}
              name="number"
              placeholder={t('optionalNumber')}
              {...input}
            />
          </Fragment>
        )}
      />
    );
  }
}

export default TranslateHOC(messages)(Number);