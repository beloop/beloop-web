import CourseEdit from 'Containers/course/CourseEdit';

import React from 'react';
import { connect } from 'react-redux';

import { getCourse, getLoaded } from 'Reducers';
import * as actions from 'Actions/course';

const mapStateToProps = (state) => ({
  data: getCourse(state),
  loaded: getLoaded(state),
});

export default connect(
  mapStateToProps,
  actions
)(CourseEdit);
