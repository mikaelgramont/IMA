import React, { Component, Fragment } from "react";
import classnames from "classnames";
import { Form } from "react-final-form";
import arrayMutators from "final-form-arrays";
import { FieldArray } from "react-final-form-arrays";

import Boardercross from "./Competitions/Boardercross.jsx";
import Freestyle from "./Competitions/Freestyle.jsx";
import Category from "./Category.jsx";
import Country from './Country.jsx';
import FirstName from './FirstName.jsx';
import LastName from './LastName.jsx';
import Number from "./Number.jsx";
import RemoveRider from "./RemoveRider.jsx";
import NotRiding from "./NotRiding.jsx";

import messages from './messages';
import TranslateHOC from '../Translate.jsx';

const MAX_RIDERS = 5;

class Step2 extends Component {
  render() {
    const { isCurrent, registrar, onNext, getCostPreview, t } = this.props;
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
              localErrors.firstName = t('required')
            }
            if (!rider.lastName) {
              localErrors.lastName = t('required')
            }
            if (rider.number && !rider.number.match(/\d{1,3}/)) {
              localErrors.number = t('lessThan1000');
            }
            if (!rider.country) {
              localErrors.country = t('required')
            }
            if (!rider.category) {
              localErrors.category = t('required')
            }
            if (!rider.boardercross && !rider.freestyle) {
              localErrors.competition = t('pickOneOrMore');
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
          const totalCost = getCostPreview(values);

          return (
            <Fragment>
              <dt
                className={classnames("step-title", {
                  current: isCurrent
                })}
              >
                {`2 - ${t('registeredRidersAndPrice')}`}
              </dt>
              <dd
                className={classnames("step-content", {
                  current: isCurrent
                })}
              >
                <form onSubmit={handleSubmit}>
                  <p>{t('youCanRegisterOthers')}</p>

                  <FieldArray name="riders">
                    {({ fields }) =>
                      fields.map((name, index) => (
                        <div key={name}>
                          <RemoveRider index={index} onClick={() => fields.remove(index)} canRemove={canRemove} />
                          <div className="form-item">
                            <FirstName name={name}/>
                          </div>
                          <div className="form-item">
                            <LastName name={name}/>
                          </div>
                          <div className="form-item">
                            <div className="rider-competitions">
                              <span className="label">
                                {t('special')}
                              </span>
                              <div className="checkbox-wrapper">
                                <NotRiding name={name}/>
                              </div>
                            </div>
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
                                {t('registeringIn')}
                                {!pristine &&
                                fields.error[index] &&
                                fields.error[index].competition && (
                                  <span className="error">
                                      {fields.error[index].competition}
                                    </span>
                                )}
                              </span>
                              <div className="checkbox-wrapper">
                                {/* TODO: inject these from the root of the app in an array that we run through .map() */}
                                <Boardercross name={name}/>
                                <Freestyle name={name}/>
                              </div>
                            </div>
                          </div>
                          <div className="form-item">
                            <Number name={name} />
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
                        {t('addRider')}
                      </button>
                      <button
                        type="button"
                        onClick={() => pop("riders")}
                        className="action-button remove"
                        disabled={!canRemove}
                      >
                        {t('removeRider')}
                      </button>
                    </div>
                  </div>
                  <div className="summary2">
                    <span id="rider-count">
                      {t('riderCount')(riderCount)}
                    </span>{" "}
                    -{" "}
                    <span id="total">
                      {t('total')}: <span id="total-cost">{`${totalCost}\u20AC`}</span>
                    </span>
                  </div>

                  <div className="form-item continue-wrapper">
                    <button
                      type="submit"
                      disabled={invalid}
                      className="action-button"
                    >
                      {t('continue')}
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
export default TranslateHOC(messages)(Step2);