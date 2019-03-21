import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

const categories = [
  "junior",
  "ladies",
  "masters",
  "pro",
];

export default class Category extends Component {
  render() {
    const {name} = this.props;
    return (
      <Field
        name={`${name}.category`}
        render={({ input, meta }) => {
          const emptyClass = input.value === "" ? "emptySelect" : "";
          return (
          <Fragment>
            <label htmlFor={`${name}.category`}>
              Category
              {meta.touched &&
                meta.error && <span className="error">{meta.error}</span>}
            </label>
            <select
              id={`${name}.category`}
              name={`${name}.category`}
              {...input}
              className={emptyClass}
            >
              <option value="">Choose the rider's category</option>
              {categories.map((category) => (
                <option key={category} value={category}>{category}</option>
              ))}
            </select>
          </Fragment>
        )}}
      />
    );
  }
}
