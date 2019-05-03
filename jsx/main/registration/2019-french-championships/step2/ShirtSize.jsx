import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

import messages from "./messages";
import TranslateHOC from "../Translate.jsx";

const sizes = ['S', 'M', 'L', 'XL'];

class ShirtSize extends Component {
  render() {
    const { name, t } = this.props;
    return (
      <Field
        name={`${name}.shirtSize`}
        render={({ input, meta }) => {
          const emptyClass = input.value === "" ? "emptySelect" : "";
          return (
            <Fragment>
              <label htmlFor={`${name}.shirtSize`}>
                {t('shirtSize')}
                {meta.touched &&
                meta.error && <span className="error">{meta.error}</span>}
              </label>
              <select
                id={`${name}.shirtSize`}
                name={`${name}.shirtSize`}
                {...input}
                className={emptyClass}
              >
                <option value="">{t('chooseTheirShirtSize')}</option>
                {sizes.map(size => (
                  <option key={size} value={size}>
                    {size}
                  </option>
                ))}
              </select>
            </Fragment>
          );
        }}
      />
    );
  }
}

export default TranslateHOC(messages)(ShirtSize);