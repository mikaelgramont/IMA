import React, { Component } from "react";
import { Field } from "react-final-form";

import messages from "../messages";
import TranslateHOC from "../../Translate.jsx";

class Boardercross extends Component {
  render() {
    const { name, t } = this.props;
    return (
      <Field
        type="checkbox"
        name={`${name}.boardercross`}
        render={({ input }) => (
          <div className="competition-item">
            <input
              type="checkbox"
              id={`${name}.boardercross`}
              name={`${name}.boardercross`}
              {...input}
            />
            <label className="radio-label" htmlFor={`${name}.boardercross`}>
              {t("boardercross")}
            </label>
          </div>
        )}
      />
    );
  }
}

export default TranslateHOC(messages)(Boardercross);
