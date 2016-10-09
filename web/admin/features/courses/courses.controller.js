// @ngInject
class CoursesController {
    // @ngInject
    constructor(apiService) {
        this.apiService = apiService;
    }

    $onInit(){
        this.columns = [
            { field: 'code', name: 'admin.course.field.code.title', width: 15 },
            { field: 'name', name: 'admin.course.field.name.title', width: 25 },
            { field: 'startDate', name: 'admin.course.field.start_date.title', width: 20 },
            { field: 'endDate', name: 'admin.course.field.end_date.title', width: 20 },
            { field: 'enrolledUsers', name: 'admin.course.field.num_users.title', width: 5 },
            { field: 'enabled', name: 'admin.common.field.enabled.title', width: 5 },
            { field: '', name: 'admin.common.field.actions.title', width: 10 }
        ];

        this.getCourses();
    }

    getCourses() {
        this.apiService.get('courses').then(response => {
            this.courses = response.data;
        });
    }
}

export default CoursesController;