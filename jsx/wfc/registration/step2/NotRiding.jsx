import React, { Component } from "react";
import { Field } from "react-final-form";

import messages from "./messages";
import TranslateHOC from "../Translate.jsx";

class NotRiding extends Component {
  render() {
    const { name, t } = this.props;
    return (
      <Field
        type="checkbox"
        name={`${name}.notRiding`}
        render={({ input }) => (
          <div className="competition-item">
            <input
              type="checkbox"
              id={`${name}.notRiding`}
              name={`${name}.notRiding`}
              {...input}
            />
            <label className="checkbox-label" htmlFor={`${name}.notRiding`}>
              {t("notRiding")}
            </label>
          </div>
        )}
      />
    );
  }
}

export default TranslateHOC(messages)(NotRiding);
