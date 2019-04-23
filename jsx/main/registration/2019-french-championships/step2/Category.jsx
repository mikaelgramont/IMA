import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

import messages from "./messages";
import TranslateHOC from "../Translate.jsx";

class Category extends Component {
  render() {
    const { name, t } = this.props;

    const categories = [
      t("categoryJunior"),
      t("categoryLadies"),
      t("categoryMasters"),
      t("categoryPro"),
      t("categoryNotRiding")
    ];

    return (
      <Field
        name={`${name}.category`}
        render={({ input, meta }) => {
          const emptyClass = input.value === "" ? "emptySelect" : "";
          return (
            <Fragment>
              <label htmlFor={`${name}.category`}>
                {t("category")}
                {meta.touched &&
                  meta.error && <span className="error">{meta.error}</span>}
              </label>
              <select
                id={`${name}.category`}
                name={`${name}.category`}
                {...input}
                className={emptyClass}
              >
                <option value="">{t("chooseCategory")}</option>
                {categories.map(category => (
                  <option key={category} value={category}>
                    {category}
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

export default TranslateHOC(messages)(Category);
