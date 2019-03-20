import React, { Component, Fragment } from "react";
import classnames from "classnames";

import Step3Content from "./Content.jsx";

export default class Step3 extends Component {
  render() {
    const {
      isCurrent,
      onFinish,
      onError,
      totalCost,
      riders,
      registrar,
      serverProcessingUrl
    } = this.props;
    const contentProps = { onError, onFinish, totalCost, riders, registrar, serverProcessingUrl };
    return (
      <Fragment>
        <dt
          className={classnames("step3 step-title", {
            current: isCurrent
          })}
        >
          3 - Payment
        </dt>
        <dd className={classnames("step-content", { current: isCurrent })}>
          {isCurrent ? (<Step3Content {...contentProps} />) : null}
        </dd>
      </Fragment>
    );
  }
}
