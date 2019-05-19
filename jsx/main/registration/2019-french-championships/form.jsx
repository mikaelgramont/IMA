import React from "react";

import Error from "./error/index.jsx";
import Initial from "./initial/index.jsx";
import Step1 from "./step1/index.jsx";
import Step2 from "./step2/index.jsx";
import Step3 from "./step3/index.jsx";
import Step4 from "./step4/index.jsx";

import LocaleContext from "./LocaleContext";
import TranslateHOC from "./Translate.jsx";
import calculate from "./CostCalculator";
import messages from "./messages";
import {PAYMENT_NONE} from "./Constants";

const ERROR = -1;
const INITIAL = 0;
const STEP1 = 1;
const STEP2 = 2;
const STEP3 = 3;
const STEP4 = 4;

class RegistrationForm extends React.Component {
  static contextType = LocaleContext;

  constructor(props) {
    super(props);

    this.state = {
      registrar: { firstName: null, lastName: null },
      riders: [],
      totalCost: 0,
      currentStep: INITIAL,
      error: null,
      summaryData: null,
    };
    this.goToStep = this.goToStep.bind(this);
    this.start = this.start.bind(this);
    this.step1Finish = this.step1Finish.bind(this);
    this.step2Finish = this.step2Finish.bind(this);
    this.finish = this.finish.bind(this);
    this.onError = this.onError.bind(this);
    this.getCostPreview = this.getCostPreview.bind(this);
  }

  start() {
    this.goToStep(STEP1);
  }

  goToStep(step) {
    this.setState({
      currentStep: step
    });
  }

  step1Finish(registrar) {
    this.setState({
      registrar,
      currentStep: STEP2
    });
  }

  step2Finish({ riders }) {
    const totalCost = calculate(riders, this.props.costs);
    this.setState({
      riders,
      totalCost,
      currentStep: STEP3
    });
  }

  getCostPreview({ riders }) {
    return calculate(riders, this.props.costs);
  }

  onError(error) {
    console.log("form.error", error);
    this.setState({ error, currentStep: ERROR });
  }

  finish(data) {
    console.log("form.finish", data);
    if (data.status === "NOK") {
      this.onError(data.error);
      return;
    }

    this.setState({ currentStep: STEP4, summaryData: data });
  }

  render() {
    const { currentStep, riders, registrar, totalCost } = this.state;
    const { t, serverProcessingUrl, paymentType } = this.props;

    const stepIds = paymentType === PAYMENT_NONE ? {1: 1, 2: 2, 3: null, 4: 3} : {1: 1, 2: 2, 3: 3, 4: 4};

    if (currentStep === INITIAL) {
      return <Initial onClick={this.start} />;
    }
    if (currentStep === ERROR) {
      return <Error error={this.state.error.message} />;
    }

    // WIP
    const canGoBack = currentStep < STEP4 && false;

    return (
        <div className="formWrapper">
          <h2 className="display-font form-title">{t("title")}</h2>
          <dl className="steps">
            <Step1
              stepId={stepIds[1]}
              isCurrent={currentStep === STEP1}
              onNext={this.step1Finish}
              titleClick={canGoBack && currentStep > STEP1 ? () => {this.goToStep(STEP1)} : null}
            />
            <Step2
              stepId={stepIds[2]}
              isCurrent={currentStep === STEP2}
              registrar={this.state.registrar}
              onNext={this.step2Finish}
              getCostPreview={this.getCostPreview}
              titleClick={canGoBack && currentStep > STEP2 ? () => {this.goToStep(STEP2)} : null}
            />
            {paymentType !== PAYMENT_NONE && (
              <Step3
                stepId={stepIds[3]}
                paymentType={paymentType}
                isCurrent={currentStep === STEP3}
                onFinish={this.finish}
                onError={this.onError}
                serverProcessingUrl={serverProcessingUrl}
                riders={riders}
                registrar={registrar}
                totalCost={totalCost}
                titleClick={canGoBack && currentStep > STEP3 ? () => {this.goToStep(STEP3)} : null}
              />
            )}
            <Step4
              stepId={stepIds[4]}
              isCurrent={currentStep === STEP4}
              summaryData={this.state.summaryData}
            />
          </dl>
        </div>
    );
  }
}

export default TranslateHOC(messages)(RegistrationForm);
