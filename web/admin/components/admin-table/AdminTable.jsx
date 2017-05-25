import React, { Component } from 'react';
import { FormattedMessage } from 'react-intl';
import classnames from 'classnames';

import AdminActionsColumn from './AdminActionsColumn';
import AdminColumn from './AdminColumn';

export default class AdminTable extends Component {
  renderColumns() {
    const columns = this.props.columns.map((column) => {
      const tdClasses = classnames(`w-${column.width}`);
      const tdWidths = classnames(`${column.width}%`);
      return (
        <th key={column.name} role="columnheader" className={tdClasses} width={tdWidths}>
          <FormattedMessage id={column.name} />
        </th>
      );
    });

    if (this.props.actions) {
      columns.push((
        <th key="actions" role="columnheader" className="w-10" width="10%">
          <FormattedMessage id="admin.common.field.actions.title" />
        </th>
      ));
    }

    return columns;
  }

  renderRows() {
    return this.props.data.map((entity, index) => {
      const columns = this.props.columns.map((column) => {
        return (<AdminColumn key={column.name} column={column} entity={entity} />);
      });

      if (this.props.actions) {
        columns.push((
          <AdminActionsColumn key="admin.common.field.actions.title" actions={this.props.actions} entity={entity} />
        ));
      }

      return (<tr key={`row-${index}`}>{columns}</tr>);
    });
  }

  render() {
    return (
      <div className="dataTables_wrapper form-inline dt-bootstrap no-footer">
        <div className="row am-datatable-body">
          <div className="col-sm-12">
            <table className="table table-striped table-fw-widget table-hover">
              <thead>
                <tr role="row">
                  {this.renderColumns()}
                </tr>
              </thead>
              <tbody>
                {this.renderRows()}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    );
  }
}
