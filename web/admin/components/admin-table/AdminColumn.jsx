import React, { Component } from 'react';
import { FormattedMessage } from 'react-intl';
import classnames from 'classnames';
import { map } from 'lodash';

export default class AdminColumn extends Component {
  renderBoolean(value) {
    const icon = value ? 's7-check' : 's7-cross';
    const iconClasses = classnames('icon', icon);

    return (
      <td className="text-center">
        <span className={iconClasses}></span>
      </td>
    );
  }

  renderNumber(value) {
    return (
      <td className="text-center">
        {value}
      </td>
    );
  }

  renderText(value) {
    return (
      <td>
        {value}
      </td>
    );
  }

  renderColumn(column, entity) {
    const value = entity[column.field];
    switch (typeof value) {
      case 'boolean': return this.renderBoolean(value); break;
      case 'number': return this.renderNumber(value); break;
      default: return this.renderText(value);
    }
  }

  render() {
    return this.renderColumn(this.props.column, this.props.entity)
  }
}
