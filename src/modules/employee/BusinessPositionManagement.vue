<template>
  <div class="row">
    <div class="col-sm-6">
      <h4>Position Management</h4>
    </div>
    <div class="col-sm-6 text-right">
      <button class="btn btn-success">
        <i class="fa fa-plus" aria-hidden="true"></i> Create
      </button>
    </div>
    <div class="col-sm-12">
      <table-component :column_setting="tableColumnSetting" :filter_setting="tableFilterSetting" :api="api"></table-component>
    </div>
  </div>
</template>
<script>
  export default{
    name: 'BusinessPositionManagement',
    components: {
      'table-component': require('../../components/table/TableComponent.vue')
    },
    create(){

    },
    mounted(){

    },
    data(){
      let api = 'business_position'
      let tableFilterSetting = [
        {
          name: 'description'
        }
      ]
      let tableColumnSetting = [
        {
          name: 'description'
        },
        {
          name: 'rank'
        }
      ]
      return {
        api: api,
        tableFilterSetting: tableFilterSetting,
        tableColumnSetting: tableColumnSetting
      }
    },
    props: {
    },
    methods: {
    }

  }
</script>
<style scoped>

</style>
