import axios from "axios";

export default axios.create({
  baseURL: "http://localhost/test-laravel/public/api/",
  headers: {
    "Content-type": "application/json"
  }
});
