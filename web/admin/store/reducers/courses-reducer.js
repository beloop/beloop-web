const initialState = {
  list: [],
  selected: null,
  error: null,
  fetching: false,
  loaded: false
};

export default (
  state = initialState,
  action,
) => {
  const pending = () => ({ ...state, fetching: true, loaded: false });
  const done = (data) => ({ ...state, ...data, fetching: false, loaded: true });
  const error = () => done({ ...state, error: action.payload, fetching: false, loaded: false });

  switch (action.type) {
    // Course list actions
    case 'FETCH_COURSES_PENDING': {
      return pending();
      break;
    }
    case 'FETCH_COURSES_REJECTED': {
      return error();
      break;
    }
    case 'FETCH_COURSES_FULFILLED': {
      return done({ list: action.response });
      break;
    }
    // Course edit actions
    case 'FETCH_COURSE_PENDING': {
      return pending();
      break;
    }
    case 'FETCH_COURSE_REJECTED': {
      return error();
      break;
    }
    case 'FETCH_COURSE_FULFILLED': {
      return done({ selected: action.response });
      break;
    }
  }

  return state;
};

 export const getCourses = (state) => state.list;
 export const getCourse = (state) => state.selected;
 export const getLoaded = (state) => state.loaded;
