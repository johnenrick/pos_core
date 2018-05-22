<template>
  <div class="row">
    <div class="col-sm-12 col-md-8 offset-md-2">
      <table class="table  table-hover table-sm">
        <thead class="text-center">
          <tr>
            <th colspan="2">Z Reading</th>
          </tr>
        </thead>
        <tbody>
          <tr class="font-weight-bold">
            <td>{{readingDate}}</td>
            <td>{{readingTime}}</td>
          </tr>
          <tr>
            <td>Transaction Number</td>
            <td>{{transactionNumberRange}}</td>
          </tr>
          <tr class="sectionTitle">
            <td colspan="2">Sales Breakdown</td>
          </tr>
          <tr>
            <td>Gross Sales</td>
            <td>{{grossSales | displayNumber}}</td>
          </tr>
          <tr>
            <td>Total Discount</td>
            <td>{{totalDiscount | displayNumber}}</td>
          </tr>
          <tr v-for="totaDiscountAmount in totalDiscountAmountList" style="font-style:italic">
            <td>&nbsp;&nbsp;&nbsp;&nbsp;- {{totaDiscountAmount['description']}}</td>
            <td>{{totaDiscountAmount['amount'] | displayNumber}}</td>
          </tr>
          <tr >
            <td>Net Sales</td>
            <td class="totalCell">{{grossSales - totalDiscount | displayNumber}}</td>
          </tr>
          <tr class="sectionTitle">
            <td colspan="2">Payment Medium Breakdown</td>
          </tr>
          <tr>
            <td>Cash Tendered</td>
            <td >{{cashTendered | displayNumber}}</td>
          </tr>
          <tr >
            <td>Credit Card</td>
            <td >{{creditCard | displayNumber}}</td>
          </tr>
          <tr >
            <td></td>
            <td class="totalCell">{{creditCard + cashTendered | displayNumber}}</td>
          </tr>
          <tr class="sectionTitle">
            <td colspan="2">VAT Sales Summary</td>
          </tr>
          <tr >
            <td>VAT Sales</td>
            <td >{{VATSales | displayNumber}}</td>
          </tr>
          <tr >
            <td>VAT Exempt Sales</td>
            <td >{{VATExemptSales | displayNumber}}</td>
          </tr>
          <tr >
            <td>Zero Rated Sales</td>
            <td >{{zeroRatedSales | displayNumber}}</td>
          </tr>
          <tr >
            <td>VAT Collected</td>
            <td >{{VATCollected | displayNumber}}</td>
          </tr>
          <tr >
            <td></td>
            <td class="totalCell">{{VATSales + VATExemptSales + zeroRatedSales + VATCollected | displayNumber}}</td>
          </tr>
          <tr class="sectionTitle">
            <td colspan="2">Credit Card Summary</td>
          </tr>
          <tr v-for="creditCardAmount in creditCardAmountList">
            <td>{{creditCardAmount['description']}}</td>
            <td>{{creditCardAmount['amount'] | displayNumber}}</td>
          </tr>
          <tr class="sectionTitle">
            <td colspan="2">Other Details</td>
          </tr>
          <tr>
            <td>Sales Transaction Count</td>
            <td >{{VATExemptSales | displayNumber}}</td>
          </tr>
          <tr >
            <td>Average Sales Per Transaction</td>
            <td >{{salesTransactionAverageAmount | displayNumber}}</td>
          </tr>
          <tr >
            <td>Transaction Count</td>
            <td >{{transactionCount | displayNumber}}</td>
          </tr>
          <tr >
            <td>Voided Transaction Count</td>
            <td >{{VATExemptSales | displayNumber}}</td>
          </tr>
          <tr >
            <td>Sales Item Count</td>
            <td >{{salesItemCount | displayNumber}}</td>
          </tr>
          <tr >
            <td>Voided Item Count</td>
            <td >{{voidedItemCount | displayNumber}}</td>
          </tr>
          <tr >
            <td>Voided Amount</td>
            <td >{{voidedAmount | displayNumber}}</td>
          </tr>
          <tr class="sectionTitle">
            <td colspan="2"></td>
          </tr>
          <tr class="font-weight-bold">
            <td>Reset Counter Number</td>
            <td >{{resetCounterNumber}}</td>
          </tr>
          <tr class="font-weight-bold">
            <td>Previous NRGT</td>
            <td >{{previousNGRT}}</td>
          </tr>
          <tr class="font-weight-bold">
            <td>Current Sales</td>
            <td >{{resetSales | displayNumber}}</td>
          </tr>
          <tr class="font-weight-bold">
            <td>Current NGRT</td>
            <td >{{currentNGRT | displayNumber}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
  export default{
    create(){

    },
    mounted(){

    },
    props: {
    },
    data(){
      return {
        readingDate: 'None',
        readingTime: 'None',
        transactionNumberRange: '0 - 0',
        grossSales: 0,
        totalDiscountAmountList: [{
          description: 'Person With Disability',
          amount: 0
        },
        {
          description: 'Senior Citizen',
          amount: 0
        }],
        cashTendered: 0,
        creditCard: 0,
        VATSales: 0,
        VATCollected: 0,
        VATExemptSales: 0,
        zeroRatedSales: 0,
        creditCardAmountList: [{
          description: 'Banco de Oro',
          amount: 0
        },
        {
          description: 'Bank of the Philippine Island',
          amount: 0
        }],
        salesTransactionCount: 0,
        salesTransactionAverageAmount: 0,
        transactionCount: 0,
        voidedTransactionCount: 0,
        salesItemCount: 0,
        voidedItemCount: 0,
        voidedAmount: 0,
        resetCounterNumber: 0,
        previousNGRT: 0,
        resetSales: 0,
        currentNGRT: 0
      }
    },
    methods: {
    },
    computed: {
      totalDiscount: function(){
        let total = 0
        for(let x = 0; x < this.totalDiscountAmountList.length; x++){
          total += this.totalDiscountAmountList[x]['amount']
        }
        return total
      }
    }

  }
</script>
<style scoped>
  table td:nth-child(2){
    text-align:right
  }
  .totalCell{
    border-top: solid 2px black
  }
  table td{
    border: none
  }
  .sectionTitle td{
    padding-top: 20px;
    border-bottom: dashed 1px;
    text-align:center;
    font-style: italic;
  }
  .sectionTitle:hover{
    background-color: none!important
  }
  .totalCell{
    font-weight: bold
  }
</style>
