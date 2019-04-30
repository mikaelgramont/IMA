import React, {Component, Fragment} from "react";
import classnames from "classnames";
import {Form, Field} from "react-final-form";

import TranslateHOC from "../Translate.jsx";
import {PAYMENT_MANDATORY, PAYMENT_OPTIONAL} from "../Constants";

import Payment from "./Payment.jsx";
import messages from "./messages";

const YES = 'yes';
const NO = 'no';

class Step3 extends Component {
  constructor(props) {
    super(props);

    this.state = {
      hasElectedToPay: null
    };
  }

  render() {
    const {
      isCurrent,
      t,
      stepId,
    } = this.props;
    return (
      <Fragment>
        <dt
          className={classnames("step3 step-title", {
            current: isCurrent
          })}
        >
          {`${stepId} - ${t('payment')}`}
        </dt>
        <dd className={classnames("step-content", {current: isCurrent})}>
          {isCurrent ? this.renderContent() : null}
        </dd>
      </Fragment>
    );
  }

  renderContent() {
    const {hasElectedToPay} = this.state;
    const {
      onFinish,
      onError,
      totalCost,
      riders,
      registrar,
      serverProcessingUrl,
      paymentType,
      t
    } = this.props;

    const showPaymentForm = paymentType === PAYMENT_MANDATORY || hasElectedToPay && paymentType === PAYMENT_OPTIONAL;

    if (showPaymentForm) {
      const contentProps = {
        onError,
        onFinish,
        totalCost,
        riders,
        registrar,
        serverProcessingUrl,
      };
      return (<Payment {...contentProps} />);
    } else if (paymentType === PAYMENT_OPTIONAL) {
      // Show form to elect to pay or not and either set hasElectedToPay or move to the next step.
      return <Form
        onSubmit={(value) => {
          if (value.proceedWithPayment === YES) {
            this.setState({hasElectedToPay: true})
          } else {
            return fetch(serverProcessingUrl, {
              method: "post",
              headers: {
                Accept: "application/json",
                "Content-Type": "application/json"
              },
              body: JSON.stringify({
                orderID: null,
                riderDetails: riders,
                registrarDetails: registrar
              })
            })
              .then(response => {
                return response.json();
              })
              .then(data => {
                onFinish({...data, skippedPayment: true});
              });
          }
        }}
        render={({values, handleSubmit}) => {
          const disabled = !values.proceedWithPayment;
          return (
            <form onSubmit={handleSubmit}>
              <p>{t('onlinePaymentIsOptional')}</p>
              <p>{t('wouldYouLikeToProceed')}</p>
              <div className="form-item">
                <div className="checkbox-wrapper">
                  <Field
                    name="proceedWithPayment"
                    component="input"
                    type="radio"
                    value={YES}
                    id="proceed-yes"
                  />
                  <label className="radio-label" htmlFor="proceed-yes">
                    {t('proceedWithPayment')}
                  </label>
                </div>
                <div className="checkbox-wrapper">
                  <Field
                    name="proceedWithPayment"
                    component="input"
                    type="radio"
                    value={NO}
                    id="proceed-no"
                  />
                  <label className="radio-label" htmlFor="proceed-no">
                    {t('skipPayment')}
                  </label>
                </div>
              </div>
              <div className="form-item continue-wrapper">
                <button
                  type="submit"
                  disabled={disabled}
                  className="action-button"
                >
                  {t('continue')}
                </button>
              </div>
            </form>
          );
        }}
      />;
    }

  }
}

export default TranslateHOC(messages)(Step3);