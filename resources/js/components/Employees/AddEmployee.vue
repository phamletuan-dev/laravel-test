<template>
  <div class="submit-form">
    <h4>Add Employee</h4>
    <div v-if="!submitted">
      <div class="form-group">
        <!-- First Name -->
        <label for="first_name">First Name</label>
        <input
          type="text"
          class="form-control"
          id="first_name"
          required
          v-model="employee.first_name"
          name="first_name"
        />
      </div>
      <div class="form-group">
        <!-- Last Name -->
        <label for="last_name">Last Name</label>
        <input
          type="text"
          class="form-control"
          id="last_name"
          required
          v-model="employee.last_name"
          name="last_name"
        />
      </div>
      <!-- Email -->
      <div class="form-group">
        <label for="Email">Email</label>
        <input
          type="email"
          class="form-control"
          id="email"
          required
          v-model="employee.email"
          name="email"
        />
      </div>
      <!-- Company -->
      <div class="form-group">
        <label for="Email">Company</label>
        <input
          type="text"
          class="form-control"
          id="company_id"
          required
          v-model="employee.company_id"
          name="company_id"
        />
      </div>
      <!-- Phone -->
      <div class="form-group">
        <label for="Phone">Phone</label>
        <input
          type="text"
          class="form-control"
          id="phone"
          required
          v-model="employee.phone"
          name="phone"
        />
      </div>

      <button @click="saveEmployee" class="btn btn-success">Submit</button>
    </div>

    <div v-else>
      <h4>You submitted successfully!</h4>
    </div>
  </div>
</template>

<script>
import EmployeeDataService from '../../services/EmployeeDataService';

export default {
  name: "add-employee",
  data() {
    return {
      employee: {
        id: null,
        first_name: "",
        last_name: "",
        email: "",
        phone: "",
        company_id:""
      },
      submitted: false
    };
  },
  methods: {
    saveEmployee() {
      
      var data = {
        first_name: this.employee.first_name,
        last_name: this.employee.last_name,
        email: this.employee.email,
        company_id: this.employee.company_id,
        phone: this.employee.phone
      };
      console.log("data",data);
      EmployeeDataService.create(data)
        .then(response => {
          this.employee.id = response.data.id;
          console.log(response.data);
          this.submitted = true;
          this.$router.push({ name: "employees" });
        })
        .catch(e => {
          console.log(e);
        });
    },
    
  }
};
</script>

<style>
.submit-form {
  max-width: 300px;
  margin: auto;
}
</style>
