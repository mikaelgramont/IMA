import React from "react";

import Error from "./error/index.jsx";
import Initial from "./initial/index.jsx";
import Step1 from "./step1/index.jsx";
import Step2 from "./step2/index.jsx";
import Step3 from "./step3/index.jsx";
import Step4 from "./step4/index.jsx";

const ERROR = -1;
const INITIAL = 0;
const STEP1 = 1;
const STEP2 = 2;
const STEP3 = 3;
const STEP4 = 4;

export default class RegistrationForm extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      registrar: { firstName: null, lastName: null },
      riders: [],
      totalCost: 0,
      currentStep: INITIAL,
      error: null,
      summaryData: null
    };
    this.goToStep = this.goToStep.bind(this);
    this.start = this.start.bind(this);
    this.step1Finish = this.step1Finish.bind(this);
    this.step2Finish = this.step2Finish.bind(this);
    this.finish = this.finish.bind(this);
    this.onError = this.onError.bind(this);
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
    this.setState({
      riders,
      totalCost: riders.length * this.props.costPerRider,
      currentStep: STEP3
    });
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
    const { currentStep } = this.state;

    if (currentStep === INITIAL) {
      return <Initial onClick={this.start} />;
    }
    if (currentStep === ERROR) {
      return <Error error={this.state.error.message} />;
    }

    const { riders, registrar, totalCost } = this.state;
    const { serverProcessingUrl, costPerRider } = this.props;
    return (
      <div className="formWrapper">
        <h2 className="display-font form-title">Registration form</h2>
        <dl className="steps">
          <Step1 isCurrent={currentStep === STEP1} onNext={this.step1Finish} />
          <Step2
            isCurrent={currentStep === STEP2}
            registrar={this.state.registrar}
            onNext={this.step2Finish}
            costPerRider={costPerRider}
          />
          <Step3
            isCurrent={currentStep === STEP3}
            onFinish={this.finish}
            onError={this.onError}
            serverProcessingUrl={serverProcessingUrl}
            riders={riders}
            registrar={registrar}
            totalCost={totalCost}
          />
          <Step4
            isCurrent={currentStep === STEP4}
            summaryData={this.state.summaryData}
          />
        </dl>
      </div>
    );
  }
}
