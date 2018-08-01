<template>
  <div class="content-wrapper container-fluid content-padding h-100" v-bind:style="{'background-image': 'url(' + require('../../assets/img/banner.jpg') + ')', 'background-repeat': 'no-repeat', 'background-size': '100%', 'background-position': 'bottom'}" >
    <div v-if="!$auth.token()" class="float-right">
      <div class="card" style="background-color: #ffffff82">
        <div class="card-body">
          <h5 class="card-title text-primary font-weight-bold">Welcome to Lite Bus POS!</h5>
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
    <div class="form-group row" v-if="false">
      <label for="inputEmail3" class="col-sm-2 col-form-label font-weight-bold">Token Birth:</label>
      <div class="col-sm-10">
        <span class="form-control-plaintext">{{formatDBDate(tokenBirth, 'MM/dd/yyy H:i:s')}}</span>
      </div>
      <label for="inputEmail3" class="col-sm-2 col-form-label font-weight-bold">Current Time:</label>
      <div class="col-sm-10">
        <span class="form-control-plaintext">{{formatDBDate(currentTime, 'MM/dd/yyy H:i:s')}}</span>
      </div>
      <label for="inputEmail3" class="col-sm-2 col-form-label font-weight-bold">Token Age:</label>
      <div class="col-sm-10">
        <span class="form-control-plaintext">{{Math.floor(tokenAge / 60000)}} Minutes {{(((tokenAge) % 60000) / 1000).toFixed(0)}} Seconds</span>
      </div>
      <label for="inputEmail3" class="col-sm-2 col-form-label font-weight-bold">Has Auth:</label>
      <div class="col-sm-10">
        <span class="form-control-plaintext">{{this.hasAuth}}</span>
      </div>
    </div>
  </div>
</template>
<script>
console.log(require('../../assets/img/banner.jpg'))
export default {
  name: 'LogIn',
  mounted(){
    if(this.$auth.check()){
      this.redirectUser(this.$auth.user().account_type_id)
    }
    this.intervalID = setInterval(this.checkTokenAge, 1000)
  },
  data(){
    return {
      username: 'admin',
      password: 'admin',
      isLoading: false,
      errorMessage: '',
      token: this.$auth.token(),
      tokenAge: 0,
      tokenBirth: '',
      currentTime: '',
      hasAuth: this.$auth.check(),
      intervalID: 0
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
          localStorage.setItem('token_birth', new Date())
          setInterval(this.checkTokenAge, 1000)
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
    /***
      This code is for debugging the jwt auth section
    **/
    refreshToken(){
      this.APIRequest('authentication/refresh', {}, (response) => {
        console.log(response)
      })
    },
    checkTokenAge(){
      this.hasAuth = this.$auth.check()
      if(!this.hasAuth){
        // alert('Expired! \n Token Age: ' + this.tokenAge)
        clearInterval(this.intervalID)
      }else{
        this.currentTime = new Date()
        this.tokenBirth = new Date(localStorage.getItem('token_birth'))

        this.tokenAge = (this.currentTime).getTime() - (this.tokenBirth).getTime()
      }
    }
  }
}
</script>
<style>
</style>
