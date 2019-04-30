import React, { Component } from "react";
import { Field } from "react-final-form";

import messages from "../messages";
import TranslateHOC from "../../Translate.jsx";

class Slalom extends Component {
  render() {
    const { name, t } = this.props;
    return (
      <Field
        type="checkbox"
        name={`${name}.slalom`}
        render={({ input }) => (
          <div className="competition-item">
            <input
              type="checkbox"
              id={`${name}.slalom`}
              name={`${name}.slalom`}
              {...input}
            />
            <label className="checkbox-label" htmlFor={`${name}.slalom`}>
              {t("slalom")}
            </label>
          </div>
        )}
      />
    );
  }
}

export default TranslateHOC(messages)(Slalom);
