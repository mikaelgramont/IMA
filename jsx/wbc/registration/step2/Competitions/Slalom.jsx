import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

export default class Slalom extends Component {
  render() {
    const { name } = this.props;
    return (
      <Field
        type="checkbox"
        name={`${name}.slalom`}
        render={({ input, meta }) => (
          <div className="competition-item">
            <input
              type="checkbox"
              id={`${name}.slalom`}
              name={`${name}.slalom`}
              {...input}
            />
            <label className="radio-label" htmlFor={`${name}.slalom`}>
              Slalom
            </label>
          </div>
        )}
      />
    );
  }
}