  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

              <div class="card card-default">
                    <div class="card-header">
                          <div class="d-inline-block">
                                <h3 class="card-title"> <i class="fa fa-pencil"></i>
                                      &nbsp; Set Customers Price </h3>
                          </div>
                    </div>
                    <div class="card-body">

                          <!-- For Messages -->
                          <?php $this->load->view('admin/includes/_messages.php') ?>

                          <?php echo form_open(base_url('admin/services/edit/'.$service_id), 'class="form-horizontal"' )?>
                          <div class="row">
                                <div class="col-md-4">
                                      <div class="form-group">
                                            <label for="user_id" class=" control-label">Customers</label>
                                            <select type="text" name="user_id" class="form-control" required>
                                                  <option value="">Select a customer</option>
                                                  <?php if($remaining_users!="" && count($remaining_users)> 0): ?>
                                                  <?php foreach($remaining_users as $data): ?>
                                                  <option value="<?=$data['id']?>">
                                                        <?= $data['firstname'] .' '. $data['lastname']; ?></option>
                                                  <?php endforeach; ?>
                                                  <?php endif; ?>
                                            </select>
                                      </div>
                                </div>
                                <div class="col-md-4">
                                      <div class="form-group">
                                            <label for="rate" class=" control-label">Rate</label>


                                            <input type="text" name="rate" value="" class="form-control" id="rate"
                                                  placeholder="">
                                      </div>
                                </div>

                                <div class="col-md-12">
                                      <div class="form-group">
                                            <input type="submit" name="submit" value="Update User Rate"
                                                  class="btn btn-primary pull-right">
                                      </div>
                                </div>
                          </div>
                          <?php echo form_close(); ?>
                    </div>
                    <!-- /.box-body -->
              </div>

              <div class="card card-default">
                    <div class="card-header">
                          <div class="d-inline-block">
                                <h3 class="card-title"> <i class="fa fa-list"></i>
                                      &nbsp; Customer Rates </h3>
                          </div>
                          <div class="d-inline-block float-right">
                                <a href="<?= base_url('admin/services'); ?>" class="btn btn-success"><i
                                            class="fa fa-list"></i> View All Services</a>
                          </div>
                    </div>
                    <div class="card-body table-responsive">
                          <table id="example1" class="table table-bordered table-striped ">
                                <thead>
                                      <tr>
                                            <th>Customer</th>
                                            <th><?= trans('amount') ?> </th>
                                            <th>Date Created </th>
                                      </tr>
                                </thead>
                                <tbody>
                                      <?php if($service_users!="" && count($service_users)> 0): ?>
                                      <?php foreach($service_users as $data): ?>
                                      <tr>
                                            <td><?= $data['firstname'] .' '. $data['lastname']; ?></td>
                                            <td><?= $data['rate'] ?></td>
                                            <td><?= date_time($data['date_created']); ?></td>
                                      </tr>
                                      <?php endforeach; ?>
                                      <?php endif; ?>
                                </tbody>
                          </table>
                    </div>
              </div>
        </section>
  </div>