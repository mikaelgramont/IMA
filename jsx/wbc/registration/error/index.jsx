import React, { Fragment } from "react";

export default ({error}) => {
  return (
    <Fragment>
      <div className="error error-display">
        <p>Payment with Paypal failed, sorry!</p>
        <p>Please try again, or get in touch and mention the following message:</p>
        <pre className="error-code">{error}</pre>
      </div>
    </Fragment>
  );
};
