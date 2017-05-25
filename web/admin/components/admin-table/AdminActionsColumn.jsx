import React, { Component } from 'react';
import { FormattedMessage } from 'react-intl';
import classnames from 'classnames';
import { map } from 'lodash';

export default class AdminActionsColumn extends Component {
  executeCallback(callback, entity) {
    if (typeof callback === 'function') {
      callback(entity);
    }
  }

  render() {
    const buttons = this.props.actions.map((action) => {
      const iconClasses = classnames('icon', action.icon);
      return (
        <a
          key={action.name}
          className="btn btn-default btn-xs"
          onClick={() => this.executeCallback(action.callback, this.props.entity)}
        >
          <i className={iconClasses}/>
        </a>
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
