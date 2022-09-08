<template>
  <div v-if="currentEmployee" class="edit-form">
    <h4>Tutorial</h4>
      <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" id="first_name"
          v-model="currentEmployee.first_name"
        />
      </div>
      <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" class="form-control" id="last_name"
          v-model="currentEmployee.last_name"
        />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email"
          v-model="currentEmployee.email"
        />
      </div>
      <div class="form-group">
        <label for="phone">Phone</label>
        <input type="phone" class="form-control" id="phone"
          v-model="currentEmployee.phone"
        />
      </div>
      <div class="form-group">
        <label for="company_id">Company</label>
        <select class="form-control" id="company_id" name="company_id" v-model="currentEmployee.company_id">
          <option :value="company.id"  v-for="(company, index) in companys"
          :key="index">{{ company.name }}</option>
        </select>
      </div>

      <p v-if="errors">
        <ul>
          <li style="color:red" v-for="error in errors">{{ error[0] }}</li>
        </ul>
      </p>

    <button class="badge badge-danger mr-2"
      @click="deleteEmployee"
    >
      Delete
    </button>

    <button class="badge badge-success"
      @click="updateEmployee"
    >
      Update
    </button>
    <p>{{ message }}</p>
  </div>

  <div v-else>
    <br />
    <p>Please click on a Tutorial...</p>
  </div>
</template>

<script>
import CompanyDataService from "../../services/CompanyDataService";
import EmployeeDataService from "../../services/EmployeeDataService";
export default {
  name: "company",
  data() {
    return {
      companys:[],
      currentEmployee: null,
      message: '',
      errors: [],
    };
  },
  created() {
    CompanyDataService.getAll()
        .then(response => {
          this.companys = response.data.data;
          console.log(this.companys);
        })
        .catch(e => {
          console.log(e);
        });
  },
  methods: {
    getEmployee(id) {
      EmployeeDataService.get(id)
        .then(response => {
          this.currentEmployee = response.data.data;
          console.log(response.data);
        })
        .catch(e => {
          console.log(e);
        });
    },

    updateEmployee() {
      this.currentEmployee['_method'] = 'put';
      console.log(this.currentEmployee);
      EmployeeDataService.update(this.currentEmployee.id, this.currentEmployee)
        .then(response => {
          this.message = 'The employee was updated successfully!';
        })
        .catch(e => {
            this.errors = e.response.data.errors;
        });
    },

    deleteEmployee() {
      EmployeeDataService.delete(this.currentEmployee.id)
        .then(response => {
          this.$router.push({ name: "employees" });
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  mounted() {
    this.message = '';
    this.getEmployee(this.$route.params.id);
  }
};
</script>

<style>
.edit-form {
  max-width: 300px;
  margin: auto;
}
</style>
