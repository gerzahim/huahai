<div class="row" align="center">
  <div class="col-sm-8">
    <div class="contact-form">
      <h2 class="title text-center">Check-In Products</h2>
      <div class="status alert alert-success" style="display: none"></div>
      <form action="{{ url('contact') }}" id="main-contact-form" class="contact-form row" name="contact-form" method="post">
        <div class="form-group col-md-6">
          <input type="text" name="name" class="form-control" required="required" placeholder="Name">
        </div>


        <div class="form-group col-md-6">
          <input type="email" name="email" class="form-control" required="required" placeholder="Client or Vendor">
        </div>
        <div class="form-group col-md-12">
          <input type="text" name="subject" class="form-control" required="required" placeholder="Date">
        </div>
        <div class="form-group col-md-12">
          <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="        currier ( ups, DHL, etc.. )
        tracking number
        Note
        Bill of Number
        type In ( RMA, Purchase)
        RMA Reason
        Date In
        batch // Batch Number
        serial  //Serial Number
        Bol  //Bill of Number"></textarea>
        </div>

        <div class="form-group col-md-12">
          <input type="text" name="subject" class="form-control" required="required" placeholder="Code Product">
        </div>
        {{ csrf_field() }}
        <div class="form-group col-md-12">
          <input type="submit" name="submit" class="btn btn-primary pull-right" value="Add">
        </div>

      </form>



      <table class="table table-condensed" border="0">
        <thead>
          <tr class="cart_menu">
            <td class="image" width="10%">Code</td>
            <td class="description" width="50%">Product</td>
            <td class="price" width="10%">Price</td>
            <td class="quantity" width="5%">Quantity</td>
            <td class="description" width="5%">Delete</td>
          </tr>
        </thead>
        <tbody>

          <tr>
            <td class="cart_description">
              <p>Sku: 8888 </p>
            </td>
            <td class="">
              <p> Verga 2x </p>
            </td>
            <td class="cart_price">
              <p>$45,89</p>
            </td>
            <td class="cart_quantity">
              <div class="cart_quantity_button">
                <select name="quantity" id="quantity">
                    <option value="1">1</option>
                    <option value="2">2</option>
                  </select>

              </div>
            </td>
            <td class="cart_price" align="center">
              <a class="cart_quantity_delete" href="#"><i class="fa fa-times fa-2x"></i></a>
            </td>
          </tr>
          <tr>
            <td class="cart_description">
              <p>Sku: 8889 </p>
            </td>
            <td class="">
              <p> Verga 3x </p>
            </td>
            <td class="cart_price">
              <p>$35,89</p>
            </td>
            <td class="cart_quantity">
              <div class="cart_quantity_button">
                <select name="quantity" id="quantity">
                    <option value="1">1</option>
                    <option value="2">2</option>
                  </select>

              </div>
            </td>
            <td class="cart_price" align="center">
              <a class="cart_quantity_delete" href="#"><i class="fa fa-times fa-2x"></i></a>
            </td>
          </tr>
          <tr>
            <td class="cart_description">
              <p>Sku: 8890 </p>
            </td>
            <td class="">
              <p> Verga 4x </p>
            </td>
            <td class="cart_price">
              <p>$67,89</p>
            </td>
            <td class="cart_quantity">
              <div class="cart_quantity_button">
                <select name="quantity" id="quantity">
                    <option value="1">1</option>
                    <option value="2">2</option>
                  </select>

              </div>
            </td>
            <td class="cart_price" align="center">
              <a class="cart_quantity_delete" href="#"><i class="fa fa-times fa-2x"></i></a>
            </td>
          </tr>
        </tbody>
      </table>




    </div>





  </div>



</div>
