import axios from "axios";

export default axios.create({
  baseURL: "http://localhost/test-laravel/public/api/",
  headers: {
    "Content-Type": "multipart/form-data",
  }
});
