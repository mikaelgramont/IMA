import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

export default class Number extends Component {
  render() {
    const { name } = this.props;
    return (
      <Field
        name={`${name}.number`}
        render={({ input, meta }) => (
          <Fragment>
            <label htmlFor={`${name}.number`}>
              Rider number
              {meta.touched &&
                meta.error && <span className="error">{meta.error}</span>}
            </label>
            <input
              type="text"
              id={`${name}.number`}
              name="number"
              placeholder="Optional number"
              {...input}
            />
          </Fragment>
        )}
      />
    );
  }
}
