<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
            <div class="container-fluid">
                  <div class="row mb-2">
                        <div class="col-sm-6">
                              <h1 class="m-0 text-dark"><?= trans('dashboard') ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#"><?= trans('home') ?></a></li>
                                    <li class="breadcrumb-item active"><?= trans('dashboard') ?></li>
                              </ol>
                        </div><!-- /.col -->
                  </div><!-- /.row -->
            </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
            <div class="container-fluid">
                  <div class="row">

                        <div class="col-lg-3 col-6">
                              <!-- small box -->
                              <div class="small-box bg-warning">
                                    <div class="inner">
                                          <h3><?= $all_users; ?></h3>

                                          <p><?= trans('user_registrations') ?></p>
                                    </div>
                                    <div class="icon">
                                          <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="<?=base_url('admin/users')?>"
                                          class="small-box-footer"><?= trans('more_info') ?> <i
                                                class="fa fa-arrow-circle-right"></i></a>
                              </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                              <!-- small box -->
                              <div class="small-box bg-info">
                                    <div class="inner">
                                          <h3><?= $active_users; ?></h3>

                                          <p><?= trans('active_users') ?></p>
                                    </div>
                                    <div class="icon">
                                          <i class="ion ion-bag"></i>
                                    </div>
                                    <a href="<?=base_url('admin/users')?>"
                                          class="small-box-footer"><?= trans('more_info') ?> <i
                                                class="fa fa-arrow-circle-right"></i></a>
                              </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                              <!-- small box -->
                              <div class="small-box bg-success">
                                    <div class="inner">
                                          <h3><?= $verified_users; ?></h3>

                                          <p>Email Verified Users</p>
                                    </div>
                                    <div class="icon">
                                          <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="<?=base_url('admin/users')?>"
                                          class="small-box-footer"><?= trans('more_info') ?> <i
                                                class="fa fa-arrow-circle-right"></i></a>
                              </div>
                        </div>
                        <div class="col-lg-3 col-6">
                              <!-- small box -->
                              <div class="small-box bg-danger">
                                    <div class="inner">
                                          <h3><?= $admin_approval_users; ?></h3>

                                          <p>Admin Approved Users</p>
                                    </div>
                                    <div class="icon">
                                          <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="<?=base_url('admin/users')?>"
                                          class="small-box-footer"><?= trans('more_info') ?> <i
                                                class="fa fa-arrow-circle-right"></i></a>
                              </div>
                        </div>


                        <!-- ./col -->
                  </div>
                  <div class="row">
                        <div class="col-lg-6 col-6">
                              <div class="card bg-info-gradient">
                                    <div class="card-header no-border">
                                          <h3 class="card-title">
                                                <i class="fa fa-th mr-1"></i>
                                                Orders Graph
                                          </h3>

                                          <div class="card-tools">
                                                <button type="button" class="btn bg-info btn-sm" data-widget="collapse">
                                                      <i class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn bg-info btn-sm" data-widget="remove">
                                                      <i class="fa fa-times"></i>
                                                </button>
                                          </div>
                                    </div>
                                    <div class="card-body">
                                          <div class="chart" id="line-chart" style="height: 250px;"></div>
                                    </div>
                                    <!-- /.card-body -->
                                    <!-- /.card-footer -->
                              </div>
                        </div>
                  </div>
            </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?= base_url() ?>assets/plugins/morris/morris.min.js"></script>
<script>
var orders = <?=json_encode($orders)?>;
var line = new Morris.Line({
      element: 'line-chart',
      resize: true,
      data: orders,
      xkey: 'y',
      ykeys: ['orders'],
      labels: ['orders'],
      lineColors: ['#efefef'],
      lineWidth: 2,
      hideHover: 'auto',
      gridTextColor: '#fff',
      gridStrokeWidth: 0.4,
      pointSize: 4,
      pointStrokeColors: ['#efefef'],
      gridLineColor: '#efefef',
      gridTextFamily: 'Open Sans',
      gridTextSize: 10
})
</script>