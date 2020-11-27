<template>
  <div class="centered-container">
      <md-content class="md-elevation-3">

      <div class="title">
        <div class="md-title">Login</div>
      </div>
      <form novalidate class="md-layout" @submit.prevent="auth">
        <md-field :class="{'md-invalid': !!formValidation.email}">
          <label>E-mail</label>
          <md-input v-model="login.email" autofocus></md-input>
          <span class="md-error" v-if="!!formValidation.email">{{formValidation.email}}</span>
        </md-field>

        <md-field md-has-password :class="{'md-invalid': !!formValidation.password}">
          <label>Password</label>
          <md-input v-model="login.password" type="password"></md-input>
          <span class="md-error" v-if="!!formValidation.password">{{formValidation.password}}</span>
        </md-field>
        
        <md-checkbox v-model="login.remember_me" class="md-primary">Remember me</md-checkbox>
        
        <div class="actions md-layout md-alignment-center-space-between">
            <a href="/resetpassword">Sign up</a>
            <md-button type="submit" class="md-raised md-primary">Log in</md-button>
        </div>

        <div class="loading-overlay" v-if="loading">
            <md-progress-spinner md-mode="indeterminate" :md-stroke="2"></md-progress-spinner>
        </div>
      </form>

      </md-content>
  </div>
</template>
<script>
import _ from 'lodash';;
import Auth from '../commons/services/auth.js';

function initialState() {
  return {
    email: null,
    password: null
  };
}

export default {
  name: "App",
  data() {
    return {
      loading: false,
      error: false,
      error_message: "",
      formValidation: initialState(),
      login: {
        email: "",
        password: "",
        remember_me: false
      }
    };
  },
  methods: {
    resetForm() {
      Object.assign(this.formValidation, initialState());
    },
    async auth() {
      try {
        this.loading = true;
        const response = await Auth.login(this.login)
        .then( response => {
          Auth.setToken(response.data);
          this.$router.push('contacts');
        })
        .catch(error => {
          this.resetForm()
          _.map( error.response.data.message, (val, key) => {
            this.formValidation[key] = val.pop();
          });
        });
        
        this.loading = false;
      } catch (error) {
        this.loading = false;
      };
    }
  }
};
</script>
<style lang="scss">
  @import '../../css/login.scss';
</style>
