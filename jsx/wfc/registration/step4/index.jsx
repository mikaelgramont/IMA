import React, { Component, Fragment } from "react";
import classnames from "classnames";

export default class Step4 extends Component {
  render() {
    const { summaryData, isCurrent } = this.props;
    if (!summaryData) {
      return null;
    }
    const { paymentData, riders } = summaryData;
    const total = `${paymentData.amount.value}${
      paymentData.amount.currency_code
    }`;
    const transaction = paymentData.id;
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
          <p>Congratulations! Registration was successful!</p>
          <p>
            You were charged {total} in transaction{" "}
            <span className="transaction">{transaction}</span>.
          </p>
          <p>The following riders are now registered:</p>
          <ul className="registered-riders">
            {riders.map(rider => {
              const { firstName, lastName, category, country, number } = rider;
              const competingIn = [];
              if (rider.slalom) {
                competingIn.push("Slalom");
              }
              if (rider.freestyle) {
                competingIn.push("Freestyle");
              }

              return (
                <li key={`${firstName}${lastName}`}>
                  <table>
                    <tr>
                      <td className="rider-detail">Name:</td>
                      <td>{`${firstName} ${lastName}`}</td>
                    </tr>
                    <tr>
                      <td className="rider-detail">Country:</td>
                      <td>{country}</td>
                    </tr>
                    {number && (
                      <tr>
                        <td className="rider-detail">Rider Number:</td>
                        <td>{number}</td>
                      </tr>
                    )}
                    <tr>
                      <td className="rider-detail">Riding in category:</td>
                      <td>{category}</td>
                    </tr>
                    <tr>
                      <td className="rider-detail">Competing in:</td>
                      <td>{competingIn.join(", ")}</td>
                    </tr>
                  </table>
                </li>
              );
            })}
          </ul>
          <p>See you there!</p>
        </dd>
      </Fragment>
    );
  }

  componentDidMount() {}
}
