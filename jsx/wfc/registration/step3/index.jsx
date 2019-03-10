import React, { Fragment } from "react";
import classnames from "classnames";

export default ({ isCurrent, onFinish, onError }) => (
  <Fragment>
    <dt
      className={classnames("step3 step-title clickable", {
        current: isCurrent
      })}
    >
      3 - Payment
    </dt>
    <dd className="step3 step-content">
      <div id="paypal-button-container" />
      <div id="paypal-generic-error" className="hidden error">
        Payment through Paypal failed, sorry! Please get in touch with us.
      </div>
    </dd>
  </Fragment>
);
