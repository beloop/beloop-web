import AdminListController from './admin-list.controller';

const adminListComponent = {
    template: require('./admin-list.view.html'),
    controller: AdminListController,
    controllerAs: 'ctrl',
    bindings: {
        columns: '<',
        data: '<'
    }
};

export default adminListComponent;