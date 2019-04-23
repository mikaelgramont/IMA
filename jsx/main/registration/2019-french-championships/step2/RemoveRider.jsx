import React, { Component } from "react";

import messages from "./messages";
import TranslateHOC from "../Translate.jsx";

class RemoveRider extends Component {
  render() {
    const { index, onClick, canRemove, t } = this.props;
    return (
      <div className="rider-name">
        <span>{t('rider')} {index + 1}</span>
        <button
          type="button"
          onClick={onClick}
          className="remove-button"
          aria-label={t('removeRider')}
          disabled={!canRemove}
        >
          <svg
            viewBox="0 0 510 510"
            className="icon remove-icon"
          >
            <use xlinkHref="#remove-icon" />
          </svg>
        </button>
      </div>

    );
  }
}

export default TranslateHOC(messages)(RemoveRider);