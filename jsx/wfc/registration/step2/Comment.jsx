import React, { Component, Fragment } from "react";
import { Field } from "react-final-form";

import messages from "./messages";
import TranslateHOC from "../Translate.jsx";

class Comment extends Component {
  render() {
    const { name, t } = this.props;
    return (
      <Field
        name={`${name}.comment`}
        render={({ input, meta }) => (
          <Fragment>
            <label htmlFor={`${name}.comment`}>
              {t('comment')}
              {meta.touched &&
                meta.error && <span className="error">{meta.error}</span>}
            </label>
            <textarea
              type="text"
              id={`${name}.comment`}
              name="comment"
              placeholder={t('optionalComment')}
              {...input}
            />
          </Fragment>
        )}
      />
    );
  }
}

export default TranslateHOC(messages)(Comment);