angular.module('beloop.admin')
    // @ngInject
    .config(($locationProvider, $stateProvider, $urlRouterProvider) => {
        // $locationProvider.html5Mode(true);

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
    })
    // @ngInject
    .config(($translateProvider) => {
        $translateProvider.useStaticFilesLoader({
            prefix: '/admin/translations/',
            suffix: '.json'
        });
        $translateProvider.preferredLanguage('en');
    });