import React, {Component, Fragment} from "react";
import {Field} from "react-final-form";
import {UNDER14, UNDER18, LADIES, MASTERS, PRO,} from '../Categories';

import messages from "./messages";
import TranslateHOC from "../Translate.jsx";

class Category extends Component {
  render() {
    const {name, t} = this.props;
    const categories = [
      [t("under14"), UNDER14],
      [t("under18"), UNDER18],
      [t("ladies"), LADIES],
      [t("masters"), MASTERS],
      [t("pro"), PRO],
    ];

    return (
      <Field
        name={`${name}.category`}
        render={({input, meta}) => {
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
                {categories.map(([label, value]) => (
                  <option key={value} value={value}>
                    {label}
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
