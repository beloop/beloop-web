import React from 'react';
import { Redirect, Route } from 'react-router-dom';

import CourseList from './features/course/CourseList';
import CourseEdit from './features/course/CourseEdit';

export default function App() {
  return (
    <div>
      <Route exact path="/" render={() => <Redirect to="/courses" />} />
      <Route exact path="/courses" component={CourseList} />
      <Route path="/courses/:code/edit" component={CourseEdit} />
    </div>
  );
}
