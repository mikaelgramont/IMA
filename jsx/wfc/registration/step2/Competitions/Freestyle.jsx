import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

export default class Freestyle extends Component {
  render() {
    const { name } = this.props;
    return (
      <Field
        type="checkbox"
        name={`${name}.freestyle`}
        render={({ input, meta }) => (
          <div className="competition-item">
            <input
              type="checkbox"
              id={`${name}.freestyle`}
              name={`${name}.freestyle`}
              {...input}
            />
            <label className="radio-label" htmlFor={`${name}.freestyle`}>
              Freestyle
            </label>
          </div>
        )}
      />
    );
  }
}
