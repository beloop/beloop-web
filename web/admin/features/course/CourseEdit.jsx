import React, { Component } from 'react';
import { FormattedMessage } from 'react-intl';
import { Tabs, TabList, TabPanel, Tab } from 'react-tabs';

import PageHead from 'Components/page-head/PageHead';
import CourseService from 'Services/course/course.service';
import CourseForm from 'Forms/course/CourseForm';

export default class CourseEdit extends Component {
  constructor({ match }) {
    super();

    this.courseLoaded = false;
    this.code = match.params.code;
    this.state = {
      course: {},
      breadcrumb: [
        {
          name: 'admin.common.title',
          to: '/',
        },
        {
          name: 'admin.course.title',
          to: '/courses',
        },
      ],
    };
  }

  componentWillMount() {
    this.loadCourse(this.code);
  }

  loadCourse(code) {
    CourseService.getOneByCode(code).then((course) => {
      this.courseLoaded = true;

      const breadcrumb = this.state.breadcrumb;
      breadcrumb.push({
        name: course.name,
      });

      return this.setState({
        course,
        breadcrumb,
      });
    });
  }

  renderCourseForm() {
    if (!this.courseLoaded) {
      return null;
    }

    return (<CourseForm className="form-horizontal" value={this.state.course} onSubmit={this.onSubmit} onCancel={this.onCancel} />);
  }

  onSubmit(course) {
    console.log('onSave', course);
  }

  onCancel() {
    window.location.hash = `#/courses`;
  }

  render() {
    return (
      <div>
        <PageHead
          title="admin.course.edit_title"
          values={{ name: this.state.course.name }}
          breadcrumb={this.state.breadcrumb}
        />
        <div className="main-content">
          <div className="row">
            <div className="col-sm-12">
              <Tabs selectedTabClassName="active" selectedTabPanelClassName="active">
                <TabList className="nav nav-tabs">
                  <Tab><a><FormattedMessage id="admin.course.title" /></a></Tab>
                  <Tab><a><FormattedMessage id="admin.course.lessons.title" /></a></Tab>
                  <Tab><a><FormattedMessage id="admin.course.users.title" /></a></Tab>
                </TabList>
                <TabPanel>
                  <div className="tab-content">
                    {this.renderCourseForm()}
                  </div>
                </TabPanel>
                <TabPanel>
                  <div className="tab-content">
                    <h2>Any content 1</h2>
                  </div>
                </TabPanel>
                <TabPanel>
                  <div className="tab-content">
                    <h2>Any content 1</h2>
                  </div>
                </TabPanel>
              </Tabs>
            </div>
          </div>
        </div>
      </div>
    );
  }
}
