import CourseService from 'Services/course/course.service';

export const fetchCourses = () => (dispatch) => {
  dispatch({ type: 'FETCH_COURSES_PENDING' });

  return CourseService.getAll()
    .then((courses) => {
      dispatch({
        type: 'FETCH_COURSES_FULFILLED',
        response: courses,
      });
    }, (error) => {
      dispatch({
        type: 'FETCH_COURSES_REJECTED',
        response: [],
      });
    });
};

export const fetchCourse = (code) => (dispatch) => {
  dispatch({ type: 'FETCH_COURSE_PENDING' });

  return CourseService.getOneByCode(code)
    .then((course) => {
      dispatch({
        type: 'FETCH_COURSE_FULFILLED',
        response: course,
      });
    }, (error) => {
      dispatch({
        type: 'FETCH_COURSE_REJECTED',
        response: {},
      });
    });
};
