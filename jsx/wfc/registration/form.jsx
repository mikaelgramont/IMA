import React  from "react";

import Initial from "./initial/index.jsx";
import Step1 from "./step1/index.jsx";
import Step2 from "./step2/index.jsx";
import Step3 from "./step3/index.jsx";

const INITIAL = 0;
const STEP1 = 1;
const STEP2 = 2;
const STEP3 = 3;

export default class RegistrationForm extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      registrar: { firstName: null, lastName: null },
      riders: [],
      totalCost: 0,
      currentStep: INITIAL,
      error: null
    };
    this.goToStep = this.goToStep.bind(this);
    this.start = this.start.bind(this);
    this.step1Finish = this.step1Finish.bind(this);
    this.step2Finish = this.step2Finish.bind(this);
    this.finish = this.finish.bind(this);
    this.displayError = this.displayError.bind(this);
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

  step2Finish({riders}) {
    this.setState({
      riders,
      totalCost: riders.length * this.props.costPerRider,
      currentStep: STEP3
    });
  }

  displayError(error) {
    this.setState({ error });
  }

  finish() {}

  render() {
    const { currentStep } = this.state;

    if (currentStep === INITIAL) {
      return (
        <Initial
          onClick={this.start}
        />
      );
    }

    const { riders, registrar, totalCost } = this.state;
    const { serverProcessingUrl } = this.props;
    return (
      <div className="formWrapper">
        <h2 className="display-font form-title">Registration form</h2>
        <dl className="steps">
          <Step1
            isCurrent={currentStep === STEP1}
            onNext={this.step1Finish}
          />
          <Step2
            isCurrent={currentStep === STEP2}
            registrar={this.state.registrar}
            onNext={this.step2Finish}
          />
          <Step3
            isCurrent={currentStep === STEP3}
            onFinish={this.finish}
            onError={this.displayError}
            serverProcessingUrl={serverProcessingUrl}
            riders={riders}
            registrar={registrar}
            totalCost={totalCost}
          />
        </dl>
      </div>
    );
  }
}
