import React, {Fragment} from 'react';
import classnames from 'classnames';
import { Form, Field } from "react-final-form";

export default ({isCurrent, onNext}) => (
  <Form
    onSubmit={(values) => {
      onNext(values);
    }}
    initialValues={{firstName: 'Mika', lastName: 'Gramont', email: 'mgramont@gmail.com'}}
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
      return errors;
    }}
    render={({ handleSubmit, pristine, invalid }) => (
      <Fragment>
        <dt className={classnames("step-title", {current: isCurrent})}>1 - Your information</dt>
        <dd className={classnames("step-content", {current: isCurrent})}>
          <form onSubmit={handleSubmit}>

            <div className="form-item">
              <Field
                name="firstName"
                render={({ input, meta }) => (
                  <div>
                    <label htmlFor="firstName">First name</label>
                    <input type="text" id="firstName" name="firstName" placeholder="Your first name" {...input}/>
                    {meta.touched && meta.error && <span className="error">{meta.error}</span>}
                  </div>
                )}
              />
            </div>

            <div className="form-item">
              <Field
                name="lastName"
                render={({ input, meta }) => (
                  <div>
                    <label htmlFor="lastName">Last name</label>
                    <input type="text" id="lastName" name="lastName" placeholder="Your last name" {...input}/>
                    {meta.touched && meta.error && <span className="error">{meta.error}</span>}
                  </div>
                )}
              />
            </div>

            <div className="form-item">
              <Field
                name="email"
                render={({ input, meta }) => (
                  <div>
                    <label htmlFor="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Your email" {...input}/>
                    {meta.touched && meta.error && <span className="error">{meta.error}</span>}
                  </div>
                )}
              />
            </div>

            <div className="form-item continue-wrapper">
              <button type="submit" disabled={invalid} onClick={onNext} className="action-button">Continue</button>
            </div>
          </form>
        </dd>
      </Fragment>
    )}>
  </Form>
);
