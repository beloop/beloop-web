import { combineReducers } from 'redux';

import courses, * as fromCourses from './courses-reducer';

export default combineReducers({
  courses,
});

export const getCourses = (state) => fromCourses.getCourses(state.courses);
