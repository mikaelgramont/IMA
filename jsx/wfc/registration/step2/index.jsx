import React, { Component, Fragment } from "react";
import classnames from "classnames";
import { Form, Field } from "react-final-form";

import arrayMutators from "final-form-arrays";
import { FieldArray } from "react-final-form-arrays";

const MAX_RIDERS = 5;

export default class Step2 extends Component {
  render() {
    const { isCurrent, registrar, onNext } = this.props;
    const { firstName, lastName } = registrar;

    return (
      <Form
        onSubmit={values => {
          onNext(values);
        }}
        mutators={{
          ...arrayMutators
        }}
        validate={values => {
          const errors = {};
          const riderErrors = [];

          values.riders.forEach((rider, index) => {
            const localErrors = {};
            if (!rider.firstName) {
              localErrors.firstName = "Required";
            }
            if (!rider.lastName) {
              localErrors.lastName = "Required";
            }
            riderErrors[index] = localErrors;
          });
          errors.riders = riderErrors;

          return errors;
        }}
        initialValues={{ riders: [{ firstName, lastName }] }}
        render={({
          values,
          handleSubmit,
          pristine,
          invalid,
          form: {
            mutators: { push, pop }
          }
        }) => {
          const canRemove = values.riders.length > 1;
          const canAdd = values.riders.length < MAX_RIDERS;

          return (
            <Fragment>
              <dt
                className={classnames("step-title", { current: isCurrent })}
              >
                2 - Registered rider(s) and price
              </dt>
              <dd
                className={classnames("step-content", { current: isCurrent })}
              >
                <form onSubmit={handleSubmit}>
                  <p>You can register yourself or several riders.</p>

                  <FieldArray name="riders">
                    {({ fields }) =>
                      fields.map((name, index) => (
                        <div key={name}>
                          <div className="form-item">
                            <div className="rider-name">
                              <span>Rider {index + 1}</span>
                              <button
                                type="button"
                                onClick={() => fields.remove(index)}
                                className="remove-button"
                                aria-label="Remove"
                                disabled={!canRemove}
                              >
                                <svg
                                  viewBox="0 0 510 510"
                                  className="icon remove-icon"
                                >
                                  <use xlinkHref="#remove-icon" />
                                </svg>
                              </button>
                            </div>
                            <Field
                              name={`${name}.firstName`}
                              render={({ input, meta }) => (
                                <div>
                                  <label htmlFor={`${name}.firstName`}>
                                    First name
                                    {meta.touched &&
                                      meta.error && (
                                        <span className="error">
                                          {meta.error}
                                        </span>
                                      )}
                                  </label>
                                  <input
                                    type="text"
                                    id={`${name}.firstName`}
                                    name="firstName"
                                    placeholder="Enter the rider's first name"
                                    {...input}
                                  />
                                </div>
                              )}
                            />
                          </div>
                          <div key={name} className="form-item">
                            <Field
                              name={`${name}.lastName`}
                              render={({ input, meta }) => (
                                <div>
                                  <label htmlFor={`${name}.lastName`}>
                                    Last name
                                    {meta.touched &&
                                      meta.error && (
                                        <span className="error">
                                          {meta.error}
                                        </span>
                                      )}
                                  </label>
                                  <input
                                    type="text"
                                    id={`${name}.lastName`}
                                    name="lastName"
                                    placeholder="Enter the rider's last name"
                                    {...input}
                                  />
                                </div>
                              )}
                            />
                          </div>
                          <hr className="rider-separator" />
                        </div>
                      ))
                    }
                  </FieldArray>

                  <div className="summary1">
                    <div className="buttons">
                      <button
                        type="button"
                        onClick={() =>
                          push("riders", { firstName: "", lastName: "" })
                        }
                        className="action-button add"
                        disabled={!canAdd}
                      >
                        Add Rider
                      </button>
                      <button
                        type="button"
                        onClick={() => pop("riders")}
                        className="action-button remove"
                        disabled={!canRemove}
                      >
                        Remove Rider
                      </button>
                    </div>
                  </div>
                  {/*<div className="summary2">*/}
                  {/*<span id="rider-count">1 rider</span> - <span id="total">Total: <span id="total-cost">35</span> &euro;</span>*/}
                  {/*</div>*/}

                  <div className="form-item continue-wrapper">
                    <button
                      type="submit"
                      disabled={invalid}
                      className="action-button"
                    >
                      Continue
                    </button>
                  </div>
                </form>
              </dd>
            </Fragment>
          );
        }}
      />
    );
  }
}
