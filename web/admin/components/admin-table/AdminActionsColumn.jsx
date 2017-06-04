import React from 'react';
import classnames from 'classnames';

export default function AdminActionsColumn({ entity, actions }) {
  const executeCallback = (callback) => {
    if (typeof callback === 'function') {
      callback(entity);
    }
  };

  const buttons = actions.map((action) => {
    const iconClasses = classnames('icon', action.icon);
    return (
      <button
        key={action.name}
        className="btn btn-default btn-xs"
        onClick={() => executeCallback(action.callback)}
      >
        <i className={iconClasses} />
      </button>
    );
  });

  return (
    <td>
      <div className="btn-toolbar">
        <div className="btn-group btn-space">{buttons}</div>
      </div>
    </td>
  );
}
