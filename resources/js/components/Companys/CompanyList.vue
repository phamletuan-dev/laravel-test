<template>
  <div class="list row">
    <div class="col-md-12">
      <h4>Company List<router-link to="/add-company" class="m-3 btn btn-sm btn-primary">Add</router-link></h4>
      <ul class="list-group">
        <li class="list-group-item"
          :class="{ active: index == currentIndex }"
          v-for="(company, index) in companys"
          :key="index"
          @click="setActiveTutorial(company, index)"
        >
          {{ company.name }}
        </li>
      </ul>
    </div>
    <br>
    <div class="col-md-6">
      <div v-if="currentCompany">
        <h4>Company Information</h4>
        <div>
          <label><strong>Email:</strong></label> {{ currentCompany.email }}
        </div>
        <div>
          <label><strong>Logo:</strong></label> {{ currentCompany.logo }}
        </div>
        <div>
          <label><strong>Website:</strong></label> {{ currentCompany.website }}
        </div>

        <router-link :to="'/company/' + currentCompany.id" class="badge badge-warning">Edit</router-link>
      </div>
      <div v-else>
        <p>Please click on a Company.</p>
      </div>
    </div>
  </div>
</template>

<script>
import CompanyDataService from "../../services/CompanyDataService";

export default {
  name: "tutorials-list",
  data() {
    return {
      companys: [],
      currentCompany: null,
      currentIndex: -1,
    };
  },
  methods: {
    retrieveCompanys() {
      CompanyDataService.getAll()
        .then(response => {
          this.companys = response.data.data;
          console.log(this.tutorials);

        })
        .catch(e => {
          console.log(e);
        });
    },

    refreshList() {
      this.retrieveTutorials();
      this.currentTutorial = null;
      this.currentIndex = -1;
    },

    setActiveTutorial(company, index) {
      this.currentCompany = company;
      this.currentIndex = company ? index : -1;
    },

    removeAllTutorials() {
      TutorialDataService.deleteAll()
        .then(response => {
          console.log(response.data);
          this.refreshList();
        })
        .catch(e => {
          console.log(e);
        });
    },
    
    searchTitle() {
      TutorialDataService.findByTitle(this.title)
        .then(response => {
          this.tutorials = response.data;
          this.setActiveTutorial(null);
          console.log(response.data);
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  mounted() {
    this.retrieveCompanys();
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
