import React, { Fragment } from "react";

export default class Step3Content extends React.Component {
  constructor(props) {
    super(props);

    this.errorElRef = React.createRef();
    this.renderError = this.renderError.bind(this);
  }

  renderError() {
    this.errorElRef.current.classList.remove("hidden");
  }

  componentDidMount() {
    const { onError, onFinish, totalCost, riders, registrar, serverProcessingUrl } = this.props;
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
          console.log("Error", err);
          this.renderError();
          onError();
        },
        onApprove: (data, actions) => {
          // Capture the funds from the transaction
          return actions.order.capture().then(details => {
            // Show a success message to your buyer
            return fetch(serverProcessingUrl, {
              method: "post",
              body: JSON.stringify({
                orderID: data.orderID,
                orderDetails: details,
                riderDetails: riders,
                registrarDetails: registrar,
              })
            }).then((data) => {
              console.log('Backend responded with:', data);
              onFinish(data);
            });
          });
        }
      })
      .render("#paypal-button-container");
  }

  render() {
    const { totalCost, riders } = this.props;
    const riderCount = riders.length;
    return (
      <Fragment>
        <p>
          {
            riderCount > 1 ? `The total for ${riderCount} is ${totalCost}\u20AC.` : `The cost for 1 rider is ${totalCost}\u20AC.`
          }
        </p>
        <div id="paypal-button-container" />
        <div id="paypal-generic-error" className="hidden">
          <span className="error" ref={this.errorElRef}>
            Payment with Paypal failed, sorry! Please get in touch with us.
          </span>
        </div>
      </Fragment>
    );
  }
}
