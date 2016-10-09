angular.module('beloop.admin')
// @ngInject
.config(($stateProvider, $urlRouterProvider) => {

    // Basic abstract states
    $stateProvider
        .state('root', {
            abstract: true,
            template: '<ui-view></ui-view>'
        });

    $stateProvider
        .state('courses', {
            url: '/courses',
            parent: 'root',
            template: require('../features/courses/list.view.html'),
            controllerAs: 'ctrl',
            controller: 'CoursesController'
        });

    $urlRouterProvider.otherwise(() => '/courses');
});