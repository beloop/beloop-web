import ApiService from 'Services/http/api.service';

export default class CourseService {
  static getAll() {
    return ApiService.get('courses').then((response) => response.body);
  }

  static getOneByCode(code) {
    return ApiService.get('course/{code}', {}, { code }).then((response) => response.body);
  }
}
