import Vue from 'vue'
import Router from 'vue-router'

import Courses from 'features/courses/courses'

Vue.use(Router)

const routes = []
routes.push({
  path: '/courses',
  name: 'courses',
  component: Courses
})

export default new Router({ routes })
