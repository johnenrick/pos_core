<template>
  <div class="bg-light background p-2" style="height:100%!important">
    <div >
      <div class="col-12 col-md-8 col-xl-6 mx-auto">
        <div class="card mx-auto" style="">
          <div class="card-body">
            <img src="../../assets/img/mrscleancebu.jpg" alt="" class="img-thumbnail w-100">
            <br>
            <br>
            <h5 class="font-weight-bold">Lite POS Payment Portal</h5>
            <h2 class="p-1 card-title font-weight-bold text-uppercase bg-dark text-light text-center">Mrs. Clean Cebu</h2>
            <div class="form-group input-group input-group-lg">
              <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Transaction Code">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">View</button>
              </div>
            </div>
            <small class="form-text text-muted">Please type the transaction that we have sent via SMS</small>
            <br>
            <h4 class="font-weight-bold">Transaction Details</h4>
            <div class="form-group row">
              <label class="col-5 col-sm-5 col-form-label font-weight-bold">Customer: </label>
              <div class="col-7 col-sm-7">
                <input type="text" readonly class="form-control-plaintext text-right"  value="Juan Dela Cruz III">
              </div>
              <label class="col-5 col-sm-5 col-form-label font-weight-bold">Total Price: </label>
              <div class="col-7 col-sm-7">
                <input type="text" readonly class="form-control-plaintext text-right"  value="PhP 240.00">
              </div>
            </div>
            <h5 class="font-weight-bold">Particulars</h5>
            <table class="table table-hover table-sm">
              <thead>
                <tr>
                  <th>Items</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    Deep Clean 30-50 sqm
                  </td>
                  <td class="text-right">
                    123.00
                  </td>
                </tr>
                <tr>
                  <td>
                    Vacuum Cleaner
                  </td>
                  <td class="text-right">
                    100.00
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td>Total</td>
                  <td class="text-right font-weight-bold">469.00</td>
                </tr>
              </tfoot>
            </table>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
              <input type="hidden" name="cmd" value="_s-xclick">
              <input type="hidden" name="hosted_button_id" value="6X5CDAET5AUSS">
              <input type="hidden" name="amount" value="200">
              <input class="float-right" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
              <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>
<script>

</script>
<style>
.background{
  margin-top: -1rem;
  margin-left: -15px!important;
  margin-right: -15px!important;
}
</style>
