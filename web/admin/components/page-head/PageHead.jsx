import React from 'react';
import { FormattedMessage, FormattedHTMLMessage } from 'react-intl';
import { Link } from 'react-router-dom';
import classnames from 'classnames';

import PageHeadBreadCrumb from './PageHeadBreadCrumb';

export default function PageHead({ title, action, values = {}, breadcrumb = [] }) {
  let actionLink;

  if (action) {
    const iconClasses = classnames('icon', 'icon-left', action.icon);
    actionLink = (
      <Link
        to={action.to}
        className="btn btn-space btn-primary btn-md pull-right"
      >
        <i className={iconClasses} /> <FormattedMessage id={action.label} />
      </Link>
    );
  }

  return (
    <div className="page-head">
      <h2>
        <FormattedHTMLMessage id={title} values={values} />
        {actionLink}
      </h2>
      <PageHeadBreadCrumb links={breadcrumb} actual={values.name} />
    </div>
  );
}
