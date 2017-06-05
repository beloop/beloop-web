import { combineReducers } from 'redux';

import courses, * as fromCourses from './courses-reducer';

export default combineReducers({
  courses,
});

export const getCourses = (store) => fromCourses.getCourses(store.courses);
export const getCourse = (store) => fromCourses.getCourse(store.courses);
export const getLoaded = (store) => fromCourses.getLoaded(store.courses);
