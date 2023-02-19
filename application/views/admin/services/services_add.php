  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
              <div class="card card-default">
                    <div class="card-header">
                          <div class="d-inline-block">
                                <h3 class="card-title"> <i class="fa fa-plus"></i>
                                      <?= trans('add_new_service') ?> </h3>
                          </div>
                          <div class="d-inline-block float-right">
                                <a href="<?= base_url('admin/services'); ?>" class="btn btn-success"><i
                                            class="fa fa-list"></i> <?= trans('services_list') ?></a>
                          </div>
                    </div>
                    <div class="card-body">

                          <!-- For Messages -->
                          <?php $this->load->view('admin/includes/_messages.php') ?>

                          <?php echo form_open(base_url('admin/services/add'), 'class="form-horizontal"');  ?>
                          <div class="form-group">
                                <label for="title" class="col-md-2 control-label">Title</label>

                                <div class="col-md-12">
                                      <input type="text" name="title" class="form-control" id="title" placeholder="">
                                </div>
                          </div>
                          <div class="form-group">
                                <label for="description" class="col-md-2 control-label">Description</label>

                                <div class="col-md-12">
                                      <textarea type="text" name="description" class="form-control" id="description"
                                            placeholder=""></textarea>
                                </div>
                          </div>

                          <div class="form-group">
                                <label for="rate" class="col-md-2 control-label">Rate</label>

                                <div class="col-md-12">
                                      <input type="number" name="rate" class="form-control" id="rate" placeholder="">
                                </div>
                          </div>

                          <div class="form-group">
                                <div class="col-md-12">
                                      <input type="submit" name="submit" value="Add Service"
                                            class="btn btn-primary pull-right">
                                </div>
                          </div>
                          <?php echo form_close( ); ?>
                    </div>
                    <!-- /.box-body -->
              </div>
        </section>
  </div>