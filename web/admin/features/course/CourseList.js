import CourseList from 'Containers/course/CourseList';

import React from 'react';
import { connect } from 'react-redux';

import { getCourses } from 'Reducers';
import * as actions from 'Actions/course';

const mapStateToProps = (state) => ({
  data: getCourses(state),
});

export default connect(
  mapStateToProps,
  actions
)(CourseList);
