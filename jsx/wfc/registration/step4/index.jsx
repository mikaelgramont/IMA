import React, { Component, Fragment } from "react";
import classnames from "classnames";

export default class Step4 extends Component {
  render() {
    const { error, status, isCurrent} = this.props;
    return (
      <Fragment>
        <dt
          className={classnames("step4 step-title", {
            current: isCurrent
          })}
        >
          4 - Finish
        </dt>
        <dd className={classnames("step-content", { current: isCurrent })}>
          Are we done yet?
        </dd>
      </Fragment>
    );
  }

  componentDidMount() {}
}
