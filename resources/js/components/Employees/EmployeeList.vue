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
          <label><strong>First name:</strong></label> {{ currentEmployee.first_name }}
        </div>
        <div>
          <label><strong>Last name:</strong></label> {{ currentEmployee.last_name }}
        </div>
        <div>
          <label><strong>Email:</strong></label> {{ currentEmployee.email }}
        </div>
        <div>
          <label><strong>Company:</strong></label> {{ currentEmployee.company.name }}
        </div>
        <div>
          <label><strong>Phone:</strong></label> {{ currentEmployee.phone }}
        </div>

        <router-link :to="'/employee/' + currentEmployee.id" class="badge badge-warning">Edit</router-link>
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
          console.log(response.data.data)

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
