import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

import messages from "./messages";
import TranslateHOC from "../Translate.jsx";

class LastName extends Component {
  render() {
    const { name, t } = this.props;
    return (
      <Field
        name={`${name}.lastName`}
        render={({ input, meta }) => (
          <Fragment>
            <label htmlFor={`${name}.lastName`}>
              {t('lastName')}
              {meta.touched &&
                meta.error && <span className="error">{meta.error}</span>}
            </label>
            <input
              type="text"
              id={`${name}.lastName`}
              name="lastName"
              placeholder={t("ridersLastName")}
              {...input}
            />
          </Fragment>
        )}
      />
    );
  }
}

export default TranslateHOC(messages)(LastName);
