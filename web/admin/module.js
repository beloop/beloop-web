angular.module('beloop.admin', [
    'ui.router',

    'beloop.admin.config',
    'beloop.admin.directives',
    'beloop.admin.services'
]).config(($compileProvider) => {
    $compileProvider.debugInfoEnabled(false);
});