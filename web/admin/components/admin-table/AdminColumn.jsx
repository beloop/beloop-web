import React from 'react';
import classnames from 'classnames';

export default function AdminColumn({ column, entity }) {
  const renderBoolean = (value) => {
    const icon = value ? 's7-check' : 's7-cross';
    const iconClasses = classnames('icon', icon);

    return (
      <td className="text-center">
        <span className={iconClasses} />
      </td>
    );
  };

  const renderNumber = (value) => {
    return (
      <td className="text-center">
        {value}
      </td>
    );
  };

  const renderText = (value) => {
    return (
      <td>
        {value}
      </td>
    );
  };

  const value = entity[column.field];
  switch (typeof value) {
    case 'boolean': return renderBoolean(value);
    case 'number': return renderNumber(value);
    default: return renderText(value);
  }
}
