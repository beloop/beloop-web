import configureMockStore from 'redux-mock-store';
import expect from 'expect';
import nock from 'nock';
import thunk from 'redux-thunk';

import * as actions from './course';

const middlewares = [ thunk ];
const mockStore = configureMockStore(middlewares);

describe('Course actions', () => {
  afterEach(() => {
    nock.cleanAll();
  });

  describe('fetchCourses', () => {
    it('creates FETCH_COURSES_FULFILLED when fetching courses has been done', () => {
      nock('http://localhost/')
        .get('/admin/api/courses/')
        .reply(200, { courses: [ 'some course' ] });

      const store = mockStore({ courses: [] });
      const expectedActions = [
        { type: 'FETCH_COURSES_PENDING' },
        { type: 'FETCH_COURSES_FULFILLED', response: [ 'some course' ] }
      ];

      return store.dispatch(actions.fetchCourses())
        .then(() => {
          expect(store.getActions()).toEqual(expectedActions)
        })
    });

    it('creates FETCH_COURSES_REJECTED when fetching courses throws an error', () => {
      nock('http://localhost/')
        .get('/admin/api/courses/')
        .reply(500, {});

      const store = mockStore({ courses: [] });
      const expectedActions = [
        { type: 'FETCH_COURSES_PENDING' },
        { type: 'FETCH_COURSES_REJECTED', response: [] }
      ];

      return store.dispatch(actions.fetchCourses())
        .then(() => {
          expect(store.getActions()).toEqual(expectedActions)
        })
    });
  });
});
