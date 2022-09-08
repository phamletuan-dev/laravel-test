import http from "../http-common";

class CompanyDataService {
  getAll() {
    return http.get("/company");
  }

  get(id) {
    return http.get(`/company/${id}`);
  }

  create(data) {
    return http.post("/company", data);
  }

  update(id, data) {
    return http.put(`/company/${id}`, data);
  }

  delete(id) {
    return http.delete(`/tutorials/${id}`);
  }

  deleteAll() {
    return http.delete(`/tutorials`);
  }

  findByTitle(title) {
    return http.get(`/tutorials?title=${title}`);
  }
}

export default new CompanyDataService();
