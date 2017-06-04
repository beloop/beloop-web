import CourseService from 'Services/course/course.service';

// export default fetchData(() => CourseService.getAll())(CourseList);

export const fetchCourses = () => (dispatch, getState) => {
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
