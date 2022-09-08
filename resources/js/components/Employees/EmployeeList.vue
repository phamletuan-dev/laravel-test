<template>
  <div class="list row">
    <div class="col-md-12">
      <h4>Employee List<router-link to="/add-employee" class="m-3 btn btn-sm btn-primary">Add</router-link></h4>
      <ul class="list-group">
        <li class="list-group-item"
          :class="{ active: index == currentIndex }"
          v-for="(employee, index) in employees"
          :key="index"
          @click="setActiveEmployee(employee, index)"
        >
          {{ employee.first_name + employee.last_name }}
        </li>
      </ul>
    </div>
    <div class="col-md-6 mt-4">
      <div v-if="currentEmployee">
        <h4>Employee Information</h4>
        <div>
          <label><strong>Email:</strong></label> {{ currentEmployee.email }}
        </div>
        <div>
          <label><strong>Company:</strong></label> {{ currentEmployee.company_id }}
        </div>
        <div>
          <label><strong>Phone:</strong></label> {{ currentEmployee.phone }}
        </div>

        <router-link :to="'/company/' + currentEmployee.id" class="badge badge-warning">Edit</router-link>
      </div>
      <div v-else>
        <p>Please click on a Employee.</p>
      </div>
    </div>
  </div>
</template>

<script>
import EmployeeDataService from "../../services/EmployeeDataService";

export default {
  name: "employees-list",
  data() {
    return {
      employees: [],
      currentEmployee: null,
      currentIndex: -1,
    };
  },
  methods: {
    retrieveEmployees() {
      EmployeeDataService.getAll()
        .then(response => {
          this.employees = response.data.data;
          console.log(this.employees);

        })
        .catch(e => {
          console.log(e);
        });
    },


    setActiveEmployee(employee, index) {
      this.currentEmployee = employee;
      this.currentIndex = employee ? index : -1;
    },
    
  },
  mounted() {
    this.retrieveEmployees();
  }
};
</script>

<style>
.list {
  text-align: left;
  max-width: 750px;
  margin: auto;
}
</style>
