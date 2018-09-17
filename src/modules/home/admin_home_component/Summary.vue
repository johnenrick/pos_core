<template>
  <div class="row row-eq-heights">

    <div class="col-sm-6 col-lg-3 mb-3">
      <div class="card text-white bg-success mb-3 text-center h-100" >
        <div class="card-body">
          <i class="fas fa-bus static-left" style="font-size: 48px;"></i>
          <span class="float-right text-right"><p class="h2 summary-text"><animated-number :value="activeBusTrip" :formatValue="shortCutNumber" :duration="300" /></p> <small >Active Trip</small></span>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
      <div class="card text-white bg-warning mb-3 text-center h-100" >
        <div class="card-body ">
          <i class="fas fa-clipboard-list static-left" style="font-size: 48px;"></i>
          <span class="float-right text-right"><p class="h2 summary-text"><animated-number :value="collectedAmount" :formatValue="shortCutNumber" :duration="1000" /></p> <small >Collected Amount</small></span>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
      <div class="card text-white bg-danger mb-3 text-center h-100" >
        <div class="card-body">
          <i class="fas fa-ban static-left" style="font-size: 48px;"></i>
          <span class="float-right text-right"><p class="h2 summary-text"><animated-number :value="voidRequests" :formatValue="shortCutNumber" :duration="1000" /></p> <small >Void Request</small></span>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3 mb-3">
      <div class="card text-white bg-info mb-3 text-center h-100" >
        <div class="card-body">
          <i class="fas fa-male static-left" style="font-size: 48px;"></i>
          <span class="float-right text-right"><p class="h2 summary-text"><animated-number :value="passengerCount" :formatValue="shortCutNumber" :duration="1000" /></p> <small >Passengers</small></span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import AnimatedNumber from 'animated-number-vue'
export default{
  components: {
    AnimatedNumber
  },
  mounted(){
    this.getSummary()
    setInterval(this.getSummary, 606000000)
  },
  data(){
    let currentDate = new Date()
    currentDate.setHours(0)
    currentDate.setMinutes(0)
    currentDate.setSeconds(1)
    return {
      currentDate: currentDate,
      activeBusTrip: 0,
      collectedAmount: 0,
      voidRequests: 0,
      passengerCount: 0
    }
  },
  methods: {
    getSummary(){
      this.getActiveBusTrips()
      this.getVoidRequest()
      this.getBusTripTicket()
    },
    getBusTripTicket(){
      let param = {
        // group_by: ['bus']
        condition: [{
          column: 'created_at',
          clause: '>=',
          value: this.DBDateFormat(this.currentDate)
        }]

      }
      this.collectedAmount = 0
      this.passengerCount = 0
      this.APIRequest('bus_trip/saleSummary', param, (response) => {
        console.log(response)
        if(response['data']){
          for(let x in response['data']){
            this.collectedAmount += response['data'][x]['total_total_amount']
            this.passengerCount += response['data'][x]['total_passenger_quantity'] * 1
          }
        }else{
        }
        console.log(this.collectedAmount, this.passengerCount)
      })
    },
    getActiveBusTrips(){
      let param = {
        condition: [{
          column: 'arrival_datetime',
          value: null
        }]
      }
      this.APIRequest('bus_trip/retrieve', param, (response) => {
        if(response['data']){
          this.activeBusTrip = response['data'].length
        }else{
          this.activeBusTrip = 0
        }
      })
    },
    getVoidRequest(){
      let param = {
        condition: [{
          column: 'is_approved',
          value: 0
        }]
      }
      this.APIRequest('void_bus_trip_ticket/retrieve', param, (response) => {
        if(response['data']){
          this.voidRequests = response['data'].length
        }else{
          this.voidRequests = 0
        }
      })
    },
    shortCutNumber(number){
      let shortcutSymbol = ''
      let shortNumber = 0
      if(number > 999999){ // M
        shortNumber = number / 1000000
        shortcutSymbol = 'M'
      }else if(number > 999){ // K
        shortNumber = number / 1000
        shortcutSymbol = 'K'
      }else{
        shortNumber = number
      }
      let finalNumber = (shortNumber % 1 > 0 ? (shortNumber).toFixed(2) : shortNumber)
      return `${finalNumber}` + shortcutSymbol
    }
  },
  filters: {
    shortCutNumber(number){
      let shortcutSymbol = ''
      let shortNumber = 0
      if(number > 999999){ // M
        shortNumber = number / 1000000
        shortcutSymbol = 'M'
      }else if(number > 999){ // K
        shortNumber = number / 1000
        shortcutSymbol = 'K'
      }else{
        shortNumber = number
      }
      return (shortNumber % 1 > 0 ? (shortNumber).toFixed(2) : shortNumber) + shortcutSymbol
    }
  }

}
</script>
<style>
 .static-left{
   position: absolute;
   left: 20px;
   top: 20px;
 }
 .summary-text{
   line-height: 0.7em;
 }
</style>
