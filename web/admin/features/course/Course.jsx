import React, { Component } from 'react';

import AdminList from 'Components/admin-table/AdminTable';
import PageHead from 'Components/page-head/PageHead';
import ApiService from 'Services/http/api.service';

export default class Course extends Component {
  constructor() {
    super();

    this.columns = [
      { field: 'code', name: 'admin.course.field.code.title', width: 15 },
      { field: 'name', name: 'admin.course.field.name.title', width: 25 },
      { field: 'enrollments', name: 'admin.course.field.num_users.title', width: 5 },
      { field: 'enabled', name: 'admin.common.field.enabled.title', width: 5 },
    ];

    this.actions = [
      {
        name: 'admin.common.field.actions.preview',
        icon: 's7-look',
        callback(course) {
          console.log('preview', course);
        }
      }
    ];

    this.state = {
      courses: [],
    };
  }

  componentWillMount() {
    this.loadCourses();
  }

  loadCourses() {
    ApiService.get('courses').then((response) => this.setState({ courses: response.body }));
  }

  render() {
    return (
      <div>
        <PageHead title="admin.course.title" action={{ to: '/courses/new', label: 'admin.course.field.actions.new.title', icon: 's7-plus' }} />
        <div className="main-content">
          <div className="row">
            <div className="col-sm-12">
              <div className="widget widget-fullwidth widget-small">
                <AdminList columns={this.columns} data={this.state.courses} actions={this.actions} />
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}
