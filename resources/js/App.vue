<template>
    <div id="app">
      <nav class="navbar navbar-expand navbar-dark bg-dark">
        <router-link to="/admin" class="navbar-brand">Admin</router-link>
        <div class="navbar-nav mr-auto">
          <li class="nav-item">
            <router-link to="/companys" class="nav-link">Companys</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/employees" class="nav-link">Employees</router-link>
          </li>
        </div>
      </nav>
  
      <div class="container mt-3">
        <router-view />
      </div>
    </div>
</template>
  
  <script>
    export default {
    name: "app"
};
</script>
