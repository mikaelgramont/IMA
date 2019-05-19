import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

import messages from "./messages";
import TranslateHOC from "../Translate.jsx";

class FirstName extends Component {
  render() {
    const { name, t } = this.props;
    return (
      <Field
        name={`${name}.firstName`}
        render={({ input, meta }) => (
          <Fragment>
            <label htmlFor={`${name}.firstName`}>
              {t("firstName")}
              {meta.touched &&
                meta.error && <span className="error">{meta.error}</span>}
            </label>
            <input
              type="text"
              id={`${name}.firstName`}
              name="firstName"
              placeholder={t("ridersFirstName")}
              {...input}
            />
          </Fragment>
        )}
      />
    );
  }
}

export default TranslateHOC(messages)(FirstName);
