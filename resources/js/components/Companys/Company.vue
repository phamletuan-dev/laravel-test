<template>
  <div v-if="currentCompany" class="edit-form">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name"
          v-model="currentCompany.name"
        />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email"
          v-model="currentCompany.email"
        />
      </div>
      <div class="form-group">
        <label for="email">Logo</label>
        <input  type="file" class="form-control-file" id="logo"
          v-on:change="onFileChange" 
        />
      </div>
      <img width="150" height="150" v-bind:src="currentCompany.logo"/>
      <div class="form-group">
        <label for="website">Website</label>
        <input type="text" class="form-control" id="website"
          v-model="currentCompany.website"
        />
      </div>

      <p v-if="errors">
        <ul>
          <li style="color:red" v-for="error in errors">{{ error[0] }}</li>
        </ul>
      </p>

    <button class="badge badge-danger mr-2"
      @click="deleteTutorial"
    >
      Delete
    </button>

    <button class="badge badge-success"
      @click="updateTutorial"
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

export default {
  name: "company",
  data() {
    return {
      currentCompany: null,
      errors: [],
      message: ''
    };
  },
  methods: {
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length)
        return;
        this.currentCompany.logo =  e.target.files[0];
    },
    getCompany(id) {
      CompanyDataService.get(id)
        .then(response => {
          this.currentCompany = response.data.data;
          console.log(response.data);
        })
        .catch(e => {
          console.log(e);
        });
    },

    updateTutorial() {
      this.currentCompany['_method'] = 'put';
      this.errors = [];

      CompanyDataService.update(this.currentCompany.id, this.currentCompany)
        .then(response => {
          this.message = 'The tutorial was updated successfully!';
        })
        .catch(e => {
          this.errors = e.response.data.errors;
        });
    },

    deleteTutorial() {
      CompanyDataService.delete(this.currentCompany.id)
        .then(response => {
          console.log(response.data);
          this.$router.push({ name: "companys" });
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  mounted() {
    this.message = '';
    this.getCompany(this.$route.params.id);
  }
};
</script>

<style>
.edit-form {
  max-width: 300px;
  margin: auto;
}
</style>
