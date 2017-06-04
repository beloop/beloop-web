import React from 'react';
import { FormattedMessage } from 'react-intl';
import classnames from 'classnames';

import AdminActionsColumn from './AdminActionsColumn';
import AdminColumn from './AdminColumn';

export default function AdminTable({ data, columns, actions }) {
  const renderFooter = () => {
    // TODO: create pagination component
    return (<div className="dataTables_info">Showing X to Y of Z entries</div>);
  };

  const renderColumns = () => {
    const tableColumns = columns.map((column) => {
      const tdClasses = classnames(`w-${column.width}`);
      const tdWidths = classnames(`${column.width}%`);
      return (
        <th key={column.name} role="columnheader" className={tdClasses} width={tdWidths}>
          <FormattedMessage id={column.name} />
        </th>
      );
    });

    if (actions) {
      tableColumns.push((
        <th key="actions" role="columnheader" className="w-10" width="10%">
          <FormattedMessage id="admin.common.field.actions.title" />
        </th>
      ));
    }

    return tableColumns;
  };

  const renderRows = () => {
    return data.map((entity, rowIndex) => {
      const tableColumns = columns.map((column, columnIndex) => {
        return <AdminColumn key={`${rowIndex}.${columnIndex}`} column={column} entity={entity} />;
      });

      if (actions) {
        tableColumns.push((
          <AdminActionsColumn
            key={`admin.common.field.actions.title.${rowIndex}`}
            actions={actions}
            entity={entity}
          />
        ));
      }

      return (<tr key={rowIndex}>{tableColumns}</tr>);
    });
  }

  return (
    <div className="dataTables_wrapper form-inline dt-bootstrap no-footer">
      <div className="row am-datatable-body">
        <div className="col-sm-12">
          <table className="table table-striped table-fw-widget table-hover">
            <thead>
              <tr role="row">
                {renderColumns()}
              </tr>
            </thead>
            <tbody>
              {renderRows()}
            </tbody>
          </table>
        </div>
      </div>
      <div className="row am-datatable-footer">
        <div className="col-sm-5">
          {renderFooter()}
        </div>
      </div>
    </div>
  );
}
