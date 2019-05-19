import React, { Component, Fragment } from "react";
import classnames from "classnames";
import { Form, Field } from "react-final-form";

import messages from './messages';
import TranslateHOC from '../Translate.jsx';

const EMAIL_REGEX = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

class Step1 extends Component {
  render() {
    const { stepId, isCurrent, onNext, t, titleClick} = this.props;
    return (
      <Form
        onSubmit={values => {
          onNext(values);
        }}
        validate={values => {
          const errors = {};
          if (!values.firstName) {
            errors.firstName = t('required');
          }
          if (!values.lastName) {
            errors.lastName = t('required');
          }
          if (!values.email) {
            errors.email = t('required');
          } else if (!values.email.match(EMAIL_REGEX)) {
            errors.email = t('invalid');
          }
          return errors;
        }}
        render={({ handleSubmit, pristine, invalid }) => (
          <Fragment>
            <dt className={classnames("step-title", { current: isCurrent, clickable: !!titleClick })} onClick={() => {if (titleClick) {titleClick()} }}>
              {`${stepId} - ${t('yourInformation')}`}
            </dt>
            <dd className={classnames("step-content", { current: isCurrent })}>
              <form onSubmit={handleSubmit}>
                <div className="form-item">
                  <Field
                    name="firstName"
                    render={({ input, meta }) => (
                      <div>
                        <label htmlFor="firstName">
                          {t('firstName')}
                          {meta.touched &&
                            meta.error && (
                              <span className="error">{meta.error}</span>
                            )}
                        </label>
                        <input
                          type="text"
                          id="firstName"
                          name="firstName"
                          placeholder={t('yourFirstName')}
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
                          {t('lastName')}
                          {meta.touched &&
                            meta.error && (
                              <span className="error">{meta.error}</span>
                            )}
                        </label>
                        <input
                          type="text"
                          id="lastName"
                          name="lastName"
                          placeholder={t('yourLastName')}
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
                          {t('email')}
                          {meta.touched &&
                            meta.error && (
                              <span className="error">{meta.error}</span>
                            )}
                        </label>
                        <input
                          type="email"
                          id="email"
                          name="email"
                          placeholder={t('yourEmail')}
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
                    {t('continue')}
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

export default TranslateHOC(messages)(Step1);