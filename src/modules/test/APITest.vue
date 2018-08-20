<template>
  <div class="content-padding">
    <h2>API Testing</h2>
    <div class="row">
      <div class="col-6">
        <strong>API URL: </strong> {{testAPILink}}
      </div>
      <div class="col-6">
        <strong>Time Started: </strong> {{timeStarted}} <br>
        <strong>Time Ended: </strong> {{timeEnded}} <br>
        <strong>Total Time: </strong> {{(timeEnded - timeStarted) / 1000}}
      </div>
      <div class="col-6">
        <h3>Parameter</h3>
        <br>
        <tree-view :data="sampleParam" :options="{maxDepth: 3}"></tree-view>
      </div>
      <div class="col-6">
        <h3>Response</h3>
        <br>
        <tree-view :data="response" :options="{maxDepth: 3}"></tree-view>
      </div>
    </div>
      <button @click="sendRequest" v-bind:disabled="isSending" class="btn btn-primary float-right"> Send Request</button>
  </div>
</template>
<script>
  import TreeView from 'vue-json-tree-view'
  import Vue from 'vue'
  Vue.use(TreeView)
  export default{
    name: '',
    create(){

    },
    mounted(){

    },
    data(){
      return {
        testAPILink: 'bus_trip/saleSummary',
        isSending: false,
        sampleParam: {
          group_by: ['monthly', 'yearly'],
          collect_result: 'date_year',
          condition: [{
            column: 'date_year',
            clause: '<=',
            value: (new Date()).getFullYear()
          }]
          // collect_result: 'date_year',
          // condition: [{
          //   column: 'date',
          //   clause: '<=',
          //   value: '2017-01-01'
          // }]
        },
        response: {},
        remarksCounter: 0,
        timeStarted: 0,
        timeEnded: 0
      }
    },
    props: {
    },
    methods: {
      generateSampleData(){
        // this.sampleParam = {
        //   entries: [{
        //     bus_trip_ticket_id: 2,
        //     account_id: 1,
        //     remarks: 'TestA' + this.remarksCounter
        //   }, {
        //     bus_trip_ticket_id: 1,
        //     account_id: 1,
        //     remarks: 'TestB' + this.remarksCounter++
        //   }]
        // }
        // this.sampleParam = {
        //   entries: [{
        //     bus_trip_id: 428,
        //     conductor_account_id: 1,
        //     passenger_quantity: 2,
        //     start_route_stop_id: 2,
        //     end_route_stop_id: 4,
        //     total_distance: this.remarksCounter,
        //     total_amount: 23,
        //     cash_tendered: this.remarksCounter,
        //     payment_adjustment: 2,
        //     status: 1,
        //     remarks: 'Test Data A ' + this.remarksCounter
        //   }, {
        //     bus_trip_id: 48,
        //     conductor_account_id: 1,
        //     passenger_quantity: 2,
        //     start_route_stop_id: 2,
        //     end_route_stop_id: 4,
        //     total_distance: this.remarksCounter,
        //     total_amount: 23,
        //     cash_tendered: this.remarksCounter,
        //     payment_adjustment: 2,
        //     status: 1,
        //     remarks: 'Test Data B ' + this.remarksCounter
        //   }]
        // }
      },
      sendRequest(){
        this.timeStarted = new Date()
        this.timeEnded = 0
        this.isSending = true
        this.generateSampleData()
        this.APIRequest(this.testAPILink, this.sampleParam, (response) => {
          this.response = response
          this.isSending = false
          this.timeEnded = new Date()
        }, () => {
          this.isSending = false
          this.timeEnded = new Date()
        })

      }
    }

  }
</script>
<style scoped>

</style>
