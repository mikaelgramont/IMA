import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

export default class FirstName extends Component {
  render() {
    const { name } = this.props;
    return (
      <Field
        name={`${name}.firstName`}
        render={({ input, meta }) => (
          <Fragment>
            <label htmlFor={`${name}.firstName`}>
              First name
              {meta.touched &&
                meta.error && <span className="error">{meta.error}</span>}
            </label>
            <input
              type="text"
              id={`${name}.firstName`}
              name="firstName"
              placeholder="Enter the rider's first name"
              {...input}
            />
          </Fragment>
        )}
      />
    );
  }
}
