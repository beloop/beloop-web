import React from 'react';
import { FormattedMessage } from 'react-intl';
import { Link } from 'react-router-dom';
import classnames from 'classnames';

export default function PageHead({ title, action }) {
  const iconClasses = classnames('icon', 'icon-left', action.icon);

  return (
    <div className="page-head">
      <h2>
        <FormattedMessage id={title} />
        <Link
          to={action.to}
          className="btn btn-space btn-primary btn-md pull-right"
        >
          <i className={iconClasses} /> <FormattedMessage id={action.label} />
        </Link>
      </h2>
    </div>
  );
}
