<template>
  <div class="container content-padding">
    <div v-if="!$auth.token()" class="float-right">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-info">Welcome to LitePOS System!</h5>
          <hr>
          <div v-if="errorMessage !== '' && !isLoading" class="alert alert-danger ">
            <strong>Failed!</strong> {{errorMessage}}
          </div>
          <form class="form-horizontal">
            <div class="form-group ">
              <label class="font-weight-bold">Username</label>
              <input v-model="username"
                  v-bind:disabled="isLoading"
                  type="text"
                  class="form-control"
                  placeholder="Username">
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Password</label>
              <input v-model="password"
              v-on:keyup.13="signIn"
                  v-bind:disabled="isLoading"
                  type="password" class="form-control" placeholder="Password">
            </div>
            <div>
                <button
                    @click="signIn"
                    v-bind:disabled="isLoading"
                    type="button"
                    class="btn btn-success d-none"
                    >
                  Sign Up for <span class="font-italic font-weight-bold">Free!</span>
                </button>
                <button
                    @click="signIn"
                    v-bind:disabled="isLoading"
                    type="button"
                    class="btn btn-primary float-right"
                    >
                    <i class="fas fa-sign-in-alt"></i>
                  {{isLoading ? 'Signing in...' : 'Sign In'}}
                </button>

            </div>
          </form>

        </div>

      </div>
    </div>
    <div v-else>
      Checking Authentication...
      <button
          @click="refreshToken"
          v-bind:disabled="isLoading"
          type="button"
          class="btn btn-outline-primary"
          >
          <i class="fas fa-refresh"></i>
        {{isLoading ? 'Signing in...' : 'Refresh Token'}}
      </button>
    </div>
  </div>
</template>
<script>
export default {
  name: 'LogIn',
  mounted(){
    if(this.$auth.token()){
      this.redirectUser(this.$auth.user().account_type_id)
    }
  },
  data(){
    return {
      username: 'admin',
      password: 'admin',
      isLoading: false,
      errorMessage: '',
      token: this.$auth.token()
    }
  },
  methods: {
    signIn(){
      this.isLoading = true
      this.errorMessage = ''
      this.$auth.login({
        params: {username: this.username, password: this.password},
        rememberMe: false,
        success: (response) => {
          this.isLoading = false
          this.redirectUser(this.$auth.user().account_type_id)
        },
        error: (response) => {
          if(response.status === 401){
            this.errorMessage = 'Invalid credentials'
          }
          this.isLoading = false
        }
      })
    },
    redirectUser(accountTypeID){
      if(accountTypeID === 1){
        this.$router.push('admin')
      }else if(accountTypeID === 2){
        this.$router.push({
          path: '/cashier'
        })
      }else if(accountTypeID === 3){
        this.$router.push({
          path: '/server'
        })
      }
    },
    refreshToken(){
      this.APIRequest('authentication/refresh', {}, (response) => {
        console.log(response)
      })
    }
  }
}
</script>
<style>
</style>
