import React, { Fragment } from "react";

export default props => (
  <Fragment>
    <p>
      Press the button below to start registering yourself and/or other riders.
    </p>
    <div className="start-wrapper">
      <button
        type="button"
        className="start action-button"
        onClick={props.onClick}
      >
        Start registering
      </button>
    </div>
  </Fragment>
);
