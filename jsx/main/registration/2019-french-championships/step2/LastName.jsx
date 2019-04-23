import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

export default class LastName extends Component {
  render() {
    const { name } = this.props;
    return (
      <Field
        name={`${name}.lastName`}
        render={({ input, meta }) => (
          <Fragment>
            <label htmlFor={`${name}.lastName`}>
              Last name
              {meta.touched &&
                meta.error && <span className="error">{meta.error}</span>}
            </label>
            <input
              type="text"
              id={`${name}.lastName`}
              name="lastName"
              placeholder="Enter the rider's last name"
              {...input}
            />
          </Fragment>
        )}
      />
    );
  }
}
