import configureMockStore from 'redux-mock-store';
import expect from 'expect';
import nock from 'nock';
import thunk from 'redux-thunk';

import * as actions from './course';

const middlewares = [ thunk ];
const mockStore = configureMockStore(middlewares);

describe('Course actions', () => {
  let nockMock;

  afterEach(() => {
    nock.cleanAll();
  });

  describe('fetchCourses', () => {
    beforeEach(() => {
      nockMock = nock('http://localhost/').get('/admin/api/courses/');
    });

    it('creates FETCH_COURSES_FULFILLED when fetching courses has been done', () => {
      nockMock.reply(200, { courses: [ 'some course' ] });

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
      nockMock.reply(500, {});

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

  describe('fetchCourse', () => {
    beforeEach(() => {
      nockMock = nock('http://localhost/').get('/admin/api/courses/TEST-COURSE');
    });

    it('creates FETCH_COURSE_FULFILLED when fetching a course has been done', () => {
      nockMock.reply(200, { course: { name: 'some course' } });

      const store = mockStore({ course: {} });
      const expectedActions = [
        { type: 'FETCH_COURSE_PENDING' },
        { type: 'FETCH_COURSE_FULFILLED', response: { name: 'some course' } }
      ];

      return store.dispatch(actions.fetchCourse('TEST-COURSE'))
        .then(() => {
          expect(store.getActions()).toEqual(expectedActions)
        })
    });

    it('creates FETCH_COURSE_REJECTED when fetching a course throws an error', () => {
      nockMock.reply(500, {});

      const store = mockStore({ course: {} });
      const expectedActions = [
        { type: 'FETCH_COURSE_PENDING' },
        { type: 'FETCH_COURSE_REJECTED', response: {} }
      ];

      return store.dispatch(actions.fetchCourse('TEST-COURSE'))
        .then(() => {
          expect(store.getActions()).toEqual(expectedActions)
        })
    });
  });
});
