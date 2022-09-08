<template>
  <div class="submit-form">
    <h4>Add Company</h4>
    <div v-if="!submitted">
      <div class="form-group">
        <!-- Name -->
        <label for="Name">Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          required
          v-model="company.name"
          name="name"
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
          v-model="company.email"
          name="email"
        />
      </div>
      <!-- Logo -->
      <div class="form-group">
        <label for="Logo">Logo</label>
        <input
          type="file"
          class="form-control-file"
          id="logo"
          required
          v-on:change="onFileChange"
          name="logo"
        />
      </div>
      <!-- Website -->
      <div class="form-group">
      <label for="Name">Website</label>
        <input
          type="text"
          class="form-control"
          id="website"
          required
          v-model="company.website"
          name="website"
        />
      </div>

      <button @click="saveCompany" class="btn btn-success">Submit</button>
    </div>

    <div v-else>
      <h4>You submitted successfully!</h4>
    </div>
  </div>
</template>

<script>
import CompanyDataService from "../../services/CompanyDataService";

export default {
  name: "add-company",
  data() {
    return {
      company: {
        id: null,
        name: "",
        email: "",
        logo: "",
        website: ""
      },
      submitted: false
    };
  },
  methods: {
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length)
        return;
      this.company.logo =  e.target.files[0];
    },
    saveCompany() {
      var data = {
        name: this.company.name,
        email: this.company.email,
        logo: this.company.logo,
        website: this.company.website
      };
      
      CompanyDataService.create(data)
        .then(response => {
          console.log("data",data);
          this.company.id = response.data.id;
          console.log(response.data);
          this.submitted = true;
          this.$router.push({ name: "companys" });
        })
        .catch(e => {
          console.log(e);
        });
    },
    
    newTutorial() {
      this.submitted = false;
      this.tutorial = {};
    }
  }
};
</script>

<style>
.submit-form {
  max-width: 300px;
  margin: auto;
}
</style>
