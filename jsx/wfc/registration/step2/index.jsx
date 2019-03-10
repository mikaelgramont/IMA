import React, { Fragment } from "react";
import classnames from "classnames";
import { Form, Field } from "react-final-form";

import arrayMutators from "final-form-arrays";
import { FieldArray } from "react-final-form-arrays";

export default ({ isCurrent, registrar, onNext }) => (
  <Form
    onSubmit={values => {
      onNext(values);
    }}
    mutators={{
      ...arrayMutators
    }}
    validate={values => {
      console.log({values});
      const errors = {};
      return errors;
    }}
    initialValues={{ riders: [registrar] }}
    render={({
      handleSubmit,
      pristine,
      invalid,
      form: {
        mutators: { push, pop }
      }
    }) => (
      <Fragment>
        <dt
          className={classnames("step-title", { current: isCurrent })}
          id="step2-title"
        >
          2 - Registered rider(s) and price
        </dt>
        <dd className={classnames("step-content", { current: isCurrent })}>
          <form onSubmit={handleSubmit}>
            <p>You can register yourself or several riders.</p>

            <FieldArray name="riders">
              {({ fields }) =>
                fields.map((name, index) => (
                    <div key={name}>
                      <div className="form-item">
                        <div>
                          <span>Rider {index + 1}</span>
                          <button type="button" onClick={() => fields.remove(index)} className="action-button remove">Remove</button>
                        </div>
                        <Field
                          name={`${name}.firstName`}
                          render={({ input, meta }) => (
                            <div>
                              <label htmlFor={`${name}.firstName`}>First name</label>
                              <input type="text" id={`${name}.firstName`} name="firstName" placeholder="First name" {...input}/>
                              {meta.touched && meta.error && <span className="error">{meta.error}</span>}
                            </div>
                          )}
                        />
                      </div>
                      <div key={name} className="form-item">
                        <Field
                          name={`${name}.lastName`}
                          render={({ input, meta }) => (
                            <div>
                              <label htmlFor={`${name}.lastName`}>Last name</label>
                              <input type="text" id={`${name}.lastName`} name="lastName" placeholder="Last name" {...input}/>
                              {meta.touched && meta.error && <span className="error">{meta.error}</span>}
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
                  onClick={() => push("riders", undefined)}
                  className="action-button add"
                >
                  Add Rider
                </button>
                <button
                  type="button"
                  onClick={() => pop("riders")}
                  className="action-button remove"
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
