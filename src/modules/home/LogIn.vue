<template>
  <div class="container">
      <div class="float-right">
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
  </div>
</template>
<script>
import AUTH from '../../services/auth'
export default {
  name: 'LogIn',
  mounted(){
  },
  data(){
    return {
      username: 'server',
      password: 'employee',
      isLoading: false,
      errorMessage: ''
    }
  },
  methods: {
    signIn(){
      this.isLoading = true
      AUTH.authenticate(this.username, this.password, (response) => {
        this.isLoading = false
        alert(response.account_type_id)
        this.$router.push({
          path: '/' // + ((response.account_type_id === 1) ? 'admin' : 'cashier')
        })
      }, (response, status) => {
        this.errorMessage = (status === 401) ? 'Username and password mismatched' : 'Cannot log in. Contact developer if error persist.'
        this.isLoading = false
      })
    }
  }
}
</script>
<style>
</style>
