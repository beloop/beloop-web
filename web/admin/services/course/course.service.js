import ApiService from 'Services/http/api.service';

export default class CourseService {
  static getAll() {
    return ApiService.get('courses').then((response) => response.body);
  }

  static getOneByCode(code) {
    return ApiService.get('course/{code}', {}, { code }).then((response) => response.body);
  }

  static save(course) {
    const method = course.id ? 'put' : 'post';
    console.log(course);
    return ApiService[method]('course/{code}', { code: course.code }, course).then((response) => response.body);
  }
}
