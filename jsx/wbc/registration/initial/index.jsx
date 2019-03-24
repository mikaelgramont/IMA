import React, { Fragment } from "react";

export default props => (
  <Fragment>
    <div className="start-wrapper">
      <button
        type="button"
        className="start action-button"
        onClick={props.onClick}
      >
        Start registering
      </button>
    </div>
    <p className="tip">
      You can register yourself and/or other riders.
    </p>
  </Fragment>
);
