import React, { Component } from 'react';
import classnames from 'classnames';

export default class AdminColumn extends Component {
  static renderBoolean(value) {
    const icon = value ? 's7-check' : 's7-cross';
    const iconClasses = classnames('icon', icon);

    return (
      <td className="text-center">
        <span className={iconClasses} />
      </td>
    );
  }

  static renderNumber(value) {
    return (
      <td className="text-center">
        {value}
      </td>
    );
  }

  static renderText(value) {
    return (
      <td>
        {value}
      </td>
    );
  }

  static renderColumn(column, entity) {
    const value = entity[column.field];
    switch (typeof value) {
      case 'boolean': return AdminColumn.renderBoolean(value);
      case 'number': return AdminColumn.renderNumber(value);
      default: return AdminColumn.renderText(value);
    }
  }

  render() {
    return AdminColumn.renderColumn(this.props.column, this.props.entity);
  }
}
