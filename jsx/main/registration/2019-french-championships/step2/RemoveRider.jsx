import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

export default class RemoveRider extends Component {
  render() {
    const { index, onClick, canRemove } = this.props;
    return (
      <div className="rider-name">
        <span>Rider {index + 1}</span>
        <button
          type="button"
          onClick={onClick}
          className="remove-button"
          aria-label="Remove"
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
