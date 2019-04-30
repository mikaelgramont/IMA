import React, { Fragment } from "react";

import TranslateHOC from "../Translate.jsx";

import messages from "./messages";

class Payment extends React.Component {
  componentDidMount() {
    const {
      onError,
      onFinish,
      totalCost,
      riders,
      registrar,
      serverProcessingUrl
    } = this.props;
    paypal
      .Buttons({
        createOrder: (data, actions) => {
          // Set up the transaction
          return actions.order.create({
            purchase_units: [
              {
                amount: {
                  value: totalCost
                }
              }
            ]
          });
        },
        onError: err => {
          console.log("Paypal Button onError", err);
          onError(err);
        },
        onApprove: (data, actions) => {
          // Capture the funds from the transaction
          return actions.order
            .capture()
            .then(details => {
              // Show a success message to your buyer
              return fetch(serverProcessingUrl, {
                method: "post",
                headers: {
                  Accept: "application/json",
                  "Content-Type": "application/json"
                },
                body: JSON.stringify({
                  orderID: data.orderID,
                  orderDetails: details,
                  riderDetails: riders,
                  registrarDetails: registrar
                })
              })
                .then(response => {
                  return response.json();
                })
                .then(data => {
                  onFinish(data);
                });
            })
            .catch(err => {
              console.log("Paypal Button unhandled error", err);
              onError(err);
            });
        }
      })
      .render("#paypal-button-container");
  }

  render() {
    const { riders, t, totalCost } = this.props;
      const riderCount = riders.length;
    const totalCostMsg = t('totalCost')(riderCount);

    return (
      <Fragment>
        <p>
          {`${totalCostMsg}: ${totalCost}\u20AC.`}
        </p>
        <div id="paypal-button-container" />
      </Fragment>
    );
  }
}

export default TranslateHOC(messages)(Payment);