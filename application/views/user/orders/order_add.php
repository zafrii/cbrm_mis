<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datepicker/datepicker3.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
            <div class="card card-default">
                  <div class="card-header">
                        <div class="d-inline-block">
                              <h3 class="card-title"> <i class="fa fa-plus"></i>
                                    &nbsp; Add New Order </h3>
                        </div>
                        <div class="d-inline-block float-right">
                              <a href="<?= base_url('user/orders'); ?>" class="btn btn-success"><i
                                          class="fa fa-list"></i> Orders List</a>
                        </div>
                  </div>
                  <div class="card-body">

                        <!-- For Messages -->
                        <?php $this->load->view('user/includes/_messages.php') ?>

                        <?php echo form_open( base_url('user/orders/add')); ?>
                        <div class="row">
                              <div class="col-md-12">
                                    <div class="card">
                                          <div class="card-body">
                                                <div class="row">
                                                      <div class="col-md-3">
                                                            <div class="form-group">
                                                                  <label for="cnic" class="control-label">CNIC</label>
                                                                  <input type="text" name="cnic" class="form-control"
                                                                        id="cnic" placeholder="eg. 33100-1512413-5"
                                                                        required>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-3">
                                                            <label for="date" class="control-label">Name</label>
                                                            <input type="text" name="name" class="form-control"
                                                                  id="name" placeholder="" required>
                                                      </div>
                                                      <div class="col-md-3">
                                                            <label for="date" class="control-label">Father Name</label>
                                                            <input type="text" name="father_name" class="form-control"
                                                                  id="father_name" placeholder="" required>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>

                              <div class="col-md-12">
                                    <div class="card">
                                          <div class="card-body">
                                                <table class="table">
                                                      <thead>
                                                            <tr>
                                                                  <th><?= trans('action') ?></th>
                                                                  <th>Service</th>
                                                                  <th><?= trans('price') ?></th>
                                                                  <th><?= trans('total') ?></th>
                                                            </tr>
                                                      </thead>
                                                      <tbody class="field_wrapper">

                                                      </tbody>
                                                </table>

                                                <div class="col-md-5 pull-right">
                                                      <table class="table">
                                                            <tr>
                                                                  <input type="hidden" name="grand_total"
                                                                        class="grand_total" value="">
                                                                  <th><strong><?= trans('total') ?>: </strong></th>
                                                                  <td class="text-right"><span
                                                                              id="grand_total">0.00</span></td>
                                                            </tr>
                                                      </table>
                                                </div>


                                          </div>
                                          <!-- /.card-body -->
                                    </div>
                              </div>

                              <div class="col-md-12">
                                    <div class="card">
                                          <div class="card-body">
                                                <input type="submit" name="submit" value="Submit Order"
                                                      class="btn btn-primary pull-right">
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <?php echo form_close(); ?>
                  </div>
            </div>
      </section>



      <!-- bootstrap datepicker -->
      <script src="<?= base_url() ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
      <script>
      $('.datepicker').datepicker({
            autoclose: true
      });
      </script>

      <script type="text/javascript">
      const services = <?=json_encode($services_list)?>;
      let services_html = '<option value="">Select a service</option>';
      for (let i = 0; i < services.length; i++) {
            services_html +=
                  `<option value="${services[i]['id']}" data-price="${services[i]['rate']}">${services[i]['title']}</option>`;
      }

      $(function() {

            //---------------------------------------------------------------
            $('#customer').change(function(e) {
                  var id = $('#customer').val();
                  var post_data = {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                  };
                  $.ajax({
                        type: 'POST',
                        url: '<?= base_url("user/invoices/customer_detail/"); ?>' +
                              id,
                        data: post_data,
                        success: function(response) {
                              var data = JSON.parse(response);
                              console.log(data.id);
                              $('#firstname').val(data.firstname);
                              $('#address').val(data.address);
                              $('#email').val(data.email);
                              $('#mobile_no').val(data.mobile_no);
                        }
                  });

            });

            //---------------------------------------------------------------
            $(document).on("click change paste keyup", ".calcEvent", function() {
                  calculate_total();
            });

            var max_field = 10;
            var add_button = $('.add_button');
            var wrapper = $('.field_wrapper');

            function get_html_fields(row = 1) {
                  let td = '';
                  if (row == 0) {
                        td =
                              '<td> <a href="javascript:void(0);" class="add_button btn btn-sm btn-primary" title="Add field"><i class="fa fa-plus"></i></a> </td>';
                  } else {
                        td =
                              '<td> <a href="javascript:void(0);" class="remove_button btn btn-sm btn-danger" title="Remove field"><i class="fa fa-minus"></i></a> </td>';
                  }
                  var html_fields =
                        `<tr class="item">
                          ${td}
                          <td> <div class="form-group"> <select name="service[]" class="form-control service" required>${services_html}</select> </div> </td>
                          <td> <div class="form-group"> <input type="text" name="price[]" class="form-control calcEvent price" placeholder="" required> </div> </td>
                          <td> <input type="hidden" name="total[]" class="form-control item_total" placeholder="" required><strong class="item_total">0.00</strong> </td>
                        </tr>`;
                  return html_fields;
            }
            var x = 1; // 
            $(wrapper).append(get_html_fields(0));

            $(document).on("click", ".add_button", function() {
                  if (x < max_field) {
                        x++;
                        $(wrapper).append(get_html_fields());
                  }
            });

            $(wrapper).on('click', '.remove_button', function(e) {
                  e.preventDefault();
                  $(this).closest('tr').remove(); //Remove field html
                  x--; //Decrement field counter
            });

            $(wrapper).on("change", ".service", function() {

                  console.log($(this).val());
                  console.log($($(this)).find(":selected").data('price'));
                  $(this).closest('tr').find('input.price').val($($(this)).find(":selected")
                        .data('price'));
                  calculate_total()
            });

      });



      function update_service_payment(event, value) {
            console.log(event);
            console.log(value);
      }

      //---------------------------------------------------------------
      function calculate_total() {
            console.log('calculate_total')
            var sub_total = 0;
            var total = 0;

            $('tr.item').each(function() {

                  var price = parseFloat($(this).find(".price").val());
                  console.log(price);
                  sub_total += price;

                  $(this).find('.item_total').text(price.toFixed(2));
                  $(this).find('.item_total').val(price.toFixed(2));
            });

            total += parseFloat(sub_total);

            $('#grand_total').text(total.toFixed(2));
            $('.grand_total').val(total.toFixed(2)); // for hidden field

      }
      </script>

      <script>
      $('#invoices').addClass('active');
      </script>