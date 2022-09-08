import { createWebHistory, createRouter } from "vue-router";

const routes = [
  {
    path: "/admin",
    alias: "/company",
    name: "company",
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
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;