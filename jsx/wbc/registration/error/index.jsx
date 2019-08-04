import React, { Fragment } from "react";

import messages from "./messages";
import TranslateHOC from "../Translate.jsx";

const Error = ({ error, t }) => (
  <Fragment>
    <div className="error error-display">
      <p>{t("paypalFailed")}</p>
      <p>{t("tryAgain")}</p>
      <pre className="error-code">{error}</pre>
    </div>
  </Fragment>
);

export default TranslateHOC(messages)(Error);
