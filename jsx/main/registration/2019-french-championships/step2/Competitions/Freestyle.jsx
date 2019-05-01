import React, { Component } from "react";
import { Field } from "react-final-form";

import messages from "../messages";
import TranslateHOC from "../../Translate.jsx";

class Freestyle extends Component {
  render() {
    const { name, t } = this.props;
    return (
      <Field
        type="checkbox"
        name={`${name}.freestyle`}
        render={({ input }) => (
          <div className="competition-item">
            <input
              type="checkbox"
              id={`${name}.freestyle`}
              name={`${name}.freestyle`}
              {...input}
            />
            <label className="checkbox-label" htmlFor={`${name}.freestyle`}>
              {t("freestyleRouans")}
            </label>
          </div>
        )}
      />
    );
  }
}

export default TranslateHOC(messages)(Freestyle);
