export default (
  state = {
    fetching: false,
    list: [],
    index: 0,
      error: null,
  },
  action,
) => {
    switch (action.type) {
      case 'FETCH_COURSES_PENDING': {
        return {
          ...state,
          fetching: true
        };
        break;
      }
      case 'FETCH_COURSES_REJECTED': {
        return {
          ...state,
          fetching: false,
          error: action.payload
        };
        break;
      }
      case 'FETCH_COURSES_FULFILLED': {
        return {
          ...state,
          fetching: false,
          list: action.response
        };
        break;
      }
    }
    return state;
  };

 export const getCourses = (state) => state.list;
