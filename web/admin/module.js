angular.module('beloop.admin', [
    'ui.router',
    'pascalprecht.translate',

    'beloop.admin.config',
    'beloop.admin.directives',
    'beloop.admin.services'
]).config(($compileProvider) => {
    $compileProvider.debugInfoEnabled(false);
});