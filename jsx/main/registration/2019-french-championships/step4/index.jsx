import React, {Component, Fragment} from "react";
import classnames from "classnames";

import TranslateHOC from "../Translate.jsx";
import messages from "./messages";

class Step4 extends Component {
  render() {
    const {summaryData, isCurrent, t, stepId} = this.props;

    const Summary = ({data}) => {
      const {paymentData, riders, skippedPayment} = data;
      let transactionSummary = null;
      if (!skippedPayment) {
        const total = `${paymentData.amount.value}${
          paymentData.amount.currency_code
          }`;
        const transaction = paymentData.id;
        transactionSummary = (
          <p>
            <span>{t('youWereCharged').replace('{total}', total)}:</span>
            &nbsp;
            <span className="transaction">{transaction}</span>.
          </p>
        );
      }

      return (
        <Fragment>
          <p>{t('success')}</p>
          {transactionSummary}
          <p>{t('registeredList')}</p>
          <ul className="registered-riders">
            {riders.map(rider => {
              const {firstName, lastName, category, country, number} = rider;
              const competingIn = [];
              if (rider.boardercross) {
                competingIn.push(t('boardercross'));
              }
              if (rider.slalom) {
                competingIn.push(t('slalom'));
              }
              if (rider.freestyle) {
                competingIn.push(t('freestyle'));
              }

              return (
                <li key={`${firstName}${lastName}`}>
                  <table>
                    <tbody>
                    <tr>
                      <td className="rider-detail">{t('name')}:</td>
                      <td>{`${firstName} ${lastName}`}</td>
                    </tr>
                    <tr>
                      <td className="rider-detail">{t('country')}:</td>
                      <td>{country}</td>
                    </tr>
                    {number && (
                      <tr>
                        <td className="rider-detail">{t('riderNumber')}:</td>
                        <td>{number}</td>
                      </tr>
                    )}
                    <tr>
                      <td className="rider-detail">{t('ridingInCategory')}:</td>
                      <td>{category}</td>
                    </tr>
                    <tr>
                      <td className="rider-detail">{t('competingIn')}:</td>
                      <td>{competingIn.join(", ")}</td>
                    </tr>
                    </tbody>
                  </table>
                </li>
              );
            })}
          </ul>
          <p>{t('seeYouThere')}</p>
        </Fragment>
      );
    };

    return (
      <Fragment>
        <dt
          className={classnames("step4 step-title", {
            current: isCurrent
          })}
        >
          {`${stepId} - ${t("finish")}`}
        </dt>
        <dd className={classnames("step-content", {current: isCurrent})}>
          {summaryData ? <Summary data={summaryData}/> : null}
        </dd>
      </Fragment>
    );
  }
}

export default TranslateHOC(messages)(Step4);
