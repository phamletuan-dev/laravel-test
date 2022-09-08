import { createWebHistory, createRouter } from "vue-router";

const routes = [
  {
    path: "/admin",
    alias: "/companys",
    name: "companys",
    component: () => import("./components/Companys/CompanyList.vue")
  },
  {
    path: "/company/:id",
    name: "company-details",
    component: () => import("./components/Companys/Company.vue")
  },
  {
    path: "/add-company",
    name: "add-company",
    component: () => import("./components/Companys/AddCompany.vue")
  },
  {
    path: "/employees",
    name: "employees",
    component: () => import("./components/Employees/EmployeeList.vue")
  },
  // {
  //   path: "/employee/:id",
  //   name: "employee-details",
  //   component: () => import("./components/Employees/Employee.vue")
  // },
  {
    path: "/add-employee",
    name: "add-employee",
    component: () => import("./components/Employees/AddEmployee.vue")
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;