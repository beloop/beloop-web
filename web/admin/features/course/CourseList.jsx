import React, { Component } from 'react';

import AdminList from 'Components/admin-table/AdminTable';
import PageHead from 'Components/page-head/PageHead';
import CourseService from 'Services/course/course.service';

export default class CourseList extends Component {
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
          window.open(`/course/${course.code}`, '_blank');
        },
      },
      {
        name: 'admin.common.field.actions.edit',
        icon: 's7-pen',
        callback(course) {
          window.location.hash = `#/courses/${course.code}/edit`;
        },
      },
      {
        name: 'admin.common.field.actions.duplicate',
        icon: 's7-copy-file',
        callback(course) {
          console.log('duplicate', course);
        },
      },
    ];

    this.state = {
      courses: [],
    };
  }

  componentWillMount() {
    this.loadCourses();
  }

  loadCourses() {
    CourseService.getAll().then(courses => this.setState({ courses }));
  }

  render() {
    return (
      <div>
        <PageHead
          title="admin.course.title"
          action={{ to: '/courses/new', label: 'admin.course.field.actions.new.title', icon: 's7-plus' }}
        />
        <div className="main-content">
          <div className="row">
            <div className="col-sm-12">
              <div className="widget widget-fullwidth widget-small">
                <AdminList
                  columns={this.columns}
                  data={this.state.courses}
                  actions={this.actions}
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}
