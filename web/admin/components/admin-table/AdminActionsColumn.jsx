import React, { Component } from 'react';
import classnames from 'classnames';

export default class AdminActionsColumn extends Component {
  static executeCallback(callback, entity) {
    if (typeof callback === 'function') {
      callback(entity);
    }
  }

  render() {
    const buttons = this.props.actions.map((action) => {
      const iconClasses = classnames('icon', action.icon);
      return (
        <button
          key={action.name}
          className="btn btn-default btn-xs"
          onClick={() => AdminActionsColumn.executeCallback(action.callback, this.props.entity)}
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
}
