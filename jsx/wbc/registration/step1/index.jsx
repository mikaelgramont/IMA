import React, { Component, Fragment } from "react";
import classnames from "classnames";
import { Form, Field } from "react-final-form";

const EMAIL_REGEX = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

export default class Step1 extends Component {
  render() {
    const { isCurrent, onNext } = this.props;
    return (
      <Form
        onSubmit={values => {
          onNext(values);
        }}
        validate={values => {
          const errors = {};
          if (!values.firstName) {
            errors.firstName = "Required";
          }
          if (!values.lastName) {
            errors.lastName = "Required";
          }
          if (!values.email) {
            errors.email = "Required";
          }
          if (!values.email.match(EMAIL_REGEX)) {
            errors.email = "Invalid";
          }
          return errors;
        }}
        render={({ handleSubmit, pristine, invalid }) => (
          <Fragment>
            <dt className={classnames("step-title", { current: isCurrent })}>
              1 - Your information
            </dt>
            <dd className={classnames("step-content", { current: isCurrent })}>
              <form onSubmit={handleSubmit}>
                <div className="form-item">
                  <Field
                    name="firstName"
                    render={({ input, meta }) => (
                      <div>
                        <label htmlFor="firstName">
                          First name
                          {meta.touched &&
                            meta.error && (
                              <span className="error">{meta.error}</span>
                            )}
                        </label>
                        <input
                          type="text"
                          id="firstName"
                          name="firstName"
                          placeholder="Your first name"
                          {...input}
                        />
                      </div>
                    )}
                  />
                </div>

                <div className="form-item">
                  <Field
                    name="lastName"
                    render={({ input, meta }) => (
                      <div>
                        <label htmlFor="lastName">
                          Last name
                          {meta.touched &&
                            meta.error && (
                              <span className="error">{meta.error}</span>
                            )}
                        </label>
                        <input
                          type="text"
                          id="lastName"
                          name="lastName"
                          placeholder="Your last name"
                          {...input}
                        />
                      </div>
                    )}
                  />
                </div>

                <div className="form-item">
                  <Field
                    name="email"
                    render={({ input, meta }) => (
                      <div>
                        <label htmlFor="email">
                          Email
                          {meta.touched &&
                            meta.error && (
                              <span className="error">{meta.error}</span>
                            )}
                        </label>
                        <input
                          type="email"
                          id="email"
                          name="email"
                          placeholder="Your email"
                          {...input}
                        />
                      </div>
                    )}
                  />
                </div>

                <div className="form-item continue-wrapper">
                  <button
                    type="submit"
                    disabled={invalid}
                    onClick={onNext}
                    className="action-button"
                  >
                    Continue
                  </button>
                </div>
              </form>
            </dd>
          </Fragment>
        )}
      />
    );
  }
}
