import React from 'react';
import { FormattedMessage } from 'react-intl';
import { Link } from 'react-router-dom';
import { isEmpty } from 'lodash';

export default function PageHeadBreadCrumb({ links = [] }) {
  if (isEmpty(links)) {
    return null;
  }

  const createLink = (link) => {
    if (!link.to) {
      return (
        <li key={link.name}>{link.name}</li>
      );
    }

    return (
      <li key={link.name}>
        <Link to={link.to}>
          <FormattedMessage id={link.name} />
        </Link>
      </li>
    );
  };

  return (
    <ol className="breadcrumb">
      {links.map((link) => createLink(link))}
    </ol>
  );
}
