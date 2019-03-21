import React, { Component, Fragment } from "react";
import classnames from "classnames";
import { Form, Field } from "react-final-form";
import arrayMutators from "final-form-arrays";
import { FieldArray } from "react-final-form-arrays";

import Country from './Country.jsx';
import Category from "./Category.jsx";

const MAX_RIDERS = 5;

export default class Step2 extends Component {
  render() {
    const { isCurrent, registrar, onNext, costPerRider } = this.props;
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
            if (!rider.category) {
              localErrors.category = "Required";
            }
            if (!rider.country) {
              localErrors.country = "Required";
            }
            if (rider.number && !rider.number.match(/\d{1,3}/)) {
              localErrors.number = "Less than 1000";
            }
            if (!rider.slalom && !rider.freestyle) {
              localErrors.competition = "Pick one or more";
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
          errors: allErrors,
          form: {
            mutators: { push, pop }
          }
        }) => {
          const canRemove = values.riders.length > 1;
          const canAdd = values.riders.length < MAX_RIDERS;

          const riderCount = values.riders.length;
          const totalCost = costPerRider * riderCount;

          return (
            <Fragment>
              <dt
                className={classnames("step-title", {
                  current: isCurrent
                })}
              >
                2 - Registered rider(s) and price
              </dt>
              <dd
                className={classnames("step-content", {
                  current: isCurrent
                })}
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
                                <Fragment>
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
                                </Fragment>
                              )}
                            />
                          </div>
                          <div className="form-item">
                            <Field
                              name={`${name}.lastName`}
                              render={({ input, meta }) => (
                                <Fragment>
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
                                </Fragment>
                              )}
                            />
                          </div>
                          <div className="form-item">
                            <Category name={name}/>
                          </div>
                          <div className="form-item">
                            <Country name={name}/>
                          </div>
                          <div className="form-item">
                            <div className="rider-competitions">
                              <span className="label">
                                Competing in
                                {!pristine &&
                                fields.error[index] &&
                                fields.error[index].competition && (
                                  <span className="error">
                                      {fields.error[index].competition}
                                    </span>
                                )}
                              </span>
                              <div className="checkbox-wrapper">
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
                                      <label
                                        className="radio-label"
                                        htmlFor={`${name}.slalom`}
                                      >
                                        Slalom
                                      </label>
                                    </div>
                                  )}
                                />

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
                                      <label
                                        className="radio-label"
                                        htmlFor={`${name}.freestyle`}
                                      >
                                        Freestyle
                                      </label>
                                    </div>
                                  )}
                                />
                              </div>
                            </div>
                          </div>
                          <div className="form-item">
                            <Field
                              name={`${name}.number`}
                              render={({ input, meta }) => (
                                <Fragment>
                                  <label htmlFor={`${name}.number`}>
                                    Rider number
                                    {meta.touched &&
                                    meta.error && (
                                      <span className="error">
                                          {meta.error}
                                        </span>
                                    )}
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
                  <div className="summary2">
                    <span id="rider-count">
                      {riderCount > 1 ? `${riderCount} riders` : `1 rider`}
                    </span>{" "}
                    -{" "}
                    <span id="total">
                      Total: <span id="total-cost">{`${totalCost}\u20AC`}</span>
                    </span>
                  </div>

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
