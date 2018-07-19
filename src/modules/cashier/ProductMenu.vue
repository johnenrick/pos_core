<template>
  <div>
    <div class="row px-3">
      <div class="col-sm-12 bg-primary border border-primary text-white py-1 font-weight-bold">
        <i class="fas fa-bars"></i> PRODUCT MENU
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="input-group py-2">
          <input type="text" v-model="searchString" class="form-control border-primary" placeholder="Enter description or short name" aria-label="Recipient's username" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button @click="retrieveProductMenu" class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
          </div>
        </div>
      </div>
    </div>
    <div v-bind:style="{height: menu_height + 'px'}" style="overflow-y:scroll">
      <div v-for="(product, index) in productList" class="w-50 float-left pb-2 " v-bind:class="(index%2 === 0) ? 'pr-2' : ''" >
        <div class="row no-gutters rounded-right h-100 shadow-sm" >
          <div @click="$emit('addOrder', product['id'], 1, product['description'], product['short_name'], product['price'])"  class="col-10 p-2 productMenu" >
            <div class="" style="height:42px; overflow: hidden">
              <small class="font-weight-bold text-uppercase" >{{product['description']}}</small><br>
            </div>
            <small class="align-bottom float-right font-italic">PhP {{product['price'] | displayNumber}}</small>
          </div>
          <div class="col-2 text-center" >
            <button  class="h-100 btn btn-sm btn-warning btn-block text-white"><i class="fas fa-bars "></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default{
  name: '',
  props: {
    menu_height: Number
  },
  data(){
    return {
      searchString: null,
      productList: [
        {},
        {},
        {},
        {},
        {}
      ]
    }
  },
  mounted(){
    this.retrieveProductMenu()
  },
  methods: {
    retrieveProductMenu(){
      let param = {
        condition: [],
        sort: {description: 'asc'}
      }
      if(this.searchString){
        param.condition.push({
          column: 'description',
          clause: 'like',
          value: '%' + this.searchString + '%'
        })
      }
      this.APIRequest('product/retrieve', param, (response) => {
        if(!response['error'].length){
          this.productList = response['data']
        }
      })
    }
  }
}
</script>
<style scoped>
.productMenu{
  background-color: white
}
.productMenu:hover{
  background-color:#ffc107;
  color: white
}
.productMenu:active{
  background-color:#d39e00;
  color: white
}
</style>
