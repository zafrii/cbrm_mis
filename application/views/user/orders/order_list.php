<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
            <div class="card card-default">
                  <div class="card-header">
                        <div class="d-inline-block">
                              <h3 class="card-title"> <i class="fa fa-list"></i>
                                    &nbsp; Orders List </h3>
                        </div>
                        <div class="d-inline-block float-right">
                              <a href="<?= base_url('user/orders/add'); ?>" class="btn btn-success"><i
                                          class="fa fa-plus"></i>Add New Order </a>
                        </div>
                  </div>
                  <div class="card-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped ">
                              <thead>
                                    <tr>
                                          <th>Order #</th>
                                          <th><?= trans('client') ?> </th>
                                          <th><?= trans('amount') ?> </th>
                                          <th>Date Created </th>
                                          <th><?= trans('status') ?> </th>
                                          <!-- <th width="150" class="text-right"><?= trans('action') ?> </th> -->

                                    </tr>
                              </thead>
                              <tbody>
                                    <?php foreach($orders_detail as $data): ?>
                                    <tr>
                                          <td><?= $data['id']; ?></td>
                                          <td><?= $data['firstname'] .' '. $data['lastname']; ?></td>
                                          <td><?= $data['total_price'] ?></td>
                                          <td><?= date_time($data['date_created']); ?></td>
                                          <td><span
                                                      class="btn btn-success btn-flat btn-xs"><?= $data['status']; ?></span>
                                          </td>
                                          <!-- <td><div class="btn-group pull-right">
                <a href="<?= base_url('admin/invoices/view/'.$data['id']); ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                <a href="<?= base_url('admin/invoices/invoice_pdf_download/'.$data['id']); ?>" class="btn btn-primary"><i class="fa fa-download"></i></a>
                <a href="<?= base_url('admin/invoices/edit/'.$data['id']); ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                <a href="<?= base_url('admin/invoices/del/'.$data['id']); ?>" class="btn btn-danger"><i class="fa fa-remove"></i></a>
              </div></td> -->
                                    </tr>
                                    <?php endforeach; ?>
                              </tbody>
                        </table>
                  </div>
            </div>
            <!-- /.box -->
      </section>
</div>

<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
$(function() {
      $("#example1").DataTable();
});
</script>
<script>
$("#invoices").addClass('active');
</script>