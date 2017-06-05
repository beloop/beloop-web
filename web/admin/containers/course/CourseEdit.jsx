import React, { Component } from 'react';
import { FormattedMessage } from 'react-intl';
import { Tabs, TabList, TabPanel, Tab } from 'react-tabs';

import PageHead from 'Components/page-head/PageHead';
import CourseForm from 'Forms/course/CourseForm';

export default class CourseEdit extends Component {
  constructor(props) {
    super(props);

    // this.courseLoaded = false;
    this.code = this.props.match.params.code;
    this.state = {
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
    this.props.fetchCourse(this.code);
  }

  // loadCourse(code) {
  //   CourseService.getOneByCode(code).then((course) => {
  //     this.courseLoaded = true;
  //
  //     const breadcrumb = this.state.breadcrumb;
  //     breadcrumb.push({
  //       name: course.name,
  //     });
  //
  //     return this.setState({
  //       course,
  //       breadcrumb,
  //     });
  //   });
  // }

  renderCourseForm() {
    if (!this.props.loaded) {
      return null;
    }

    return (
      <CourseForm
        className="form-horizontal"
        value={this.props.data}
        onSubmit={this.onSubmit}
        onCancel={this.onCancel}
      />
    );
  }

  renderPageHead() {
    if (!this.props.loaded) {
      return null;
    }

    return (
      <PageHead
        title="admin.course.edit_title"
        values={{ name: this.props.data.name }}
        breadcrumb={this.state.breadcrumb}
      />
    );
  }

  render() {
    return (
      <div>
        {this.renderPageHead()}
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
