import './module';
import './config/routes';
import './config/config';

import './directives';
import './features';
import './services';

angular.bootstrap(document.getElementById('beloop-admin'), [ 'beloop.admin' ], {
    strictDi: true
});