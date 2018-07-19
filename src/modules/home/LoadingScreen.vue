<template>
  <div class="container">
    <div class="text-center">
      <div class="loader mt-5" ></div>
      Please wait...
    </div>
  </div>
</template>
<script>
export default {
  name: 'LogIn',
  mounted(){

  },
  data(){

  },
  methods: {
  }
}
</script>
<style>
.loader {
  border: 10px solid #353a40;
  border-radius: 50%;
  border-top: 10px solid #868e95;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  margin-left: auto;
  margin-right: auto;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
