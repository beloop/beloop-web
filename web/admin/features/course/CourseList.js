import React from 'react';
import { connect } from 'react-redux';

import { getCourses, getLoaded } from 'Reducers';
import * as actions from 'Actions/course';

import CourseList from 'Containers/course/CourseList';

const mapStateToProps = (state) => ({
  data: getCourses(state),
  loaded: getLoaded(state),
});

export default connect(
  mapStateToProps,
  actions
)(CourseList);
