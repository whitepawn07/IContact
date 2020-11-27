<template>
     <div class="content">
    <div class="md-layout">
      <div class="md-layout-item">
        <md-card class="md-card-plain">
          <md-card-header data-background-color="green">
            <h4 class="title">Import Contacts</h4>
          </md-card-header>
          <md-card-content>
                <vue-csv-import v-model="uploadedFile" :map-fields="['name', 'phone', 'email']"  @canImport="disabledSubmitButton" ></vue-csv-import>
                <div class="mt-2">
                    <!-- {{ uploadedFile }} -->
                    
                </div>
          </md-card-content>
        </md-card>
      </div>
        <div class="loading-overlay" v-if="loading">
            <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
        </div>
    </div>
  </div>
</template>
<script>
import VueCsvImport from '../components/widgets/VueCsvImport.vue';
import Contact from '../commons/services/import.js';

export default {
    components: {
        VueCsvImport
    },
    data: () => ({
      uploadedFile: null,
      canSubmit: true,
      loading: false
    }),
    methods: {
        async disabledSubmitButton() {
            try{
                const response = await Contact.import(this.uploadedFile)
                .then( response => {
                    this.$router.push('contacts');
                })
                .catch(error => {
                    // this.resetForm()
                    // _.map( error.response.data.message, (val, key) => {
                    //     this.formValidation[key] = val.pop();
                    // });
                });

            }   catch (error) {
                console.log(error);
            }
        }
    }
}
</script>
<style lang="scss" scoped>

    #app {
        font-family: "Avenir", Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
    }
    .container {
        text-align: left;
    }
    pre code {
        background-color: #eee;
        border: 1px solid #999;
        display: block;
        padding: 20px;
    }
    #app .form {
        text-align: left;
    }

</style>