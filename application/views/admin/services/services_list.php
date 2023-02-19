<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
      <section class="content">
            <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>
            <div class="card">
                  <div class="card-header">
                        <div class="d-inline-block">
                              <h3 class="card-title"><i class="fa fa-list"></i>&nbsp; <?= trans('services_list') ?></h3>
                        </div>
                        <div class="d-inline-block float-right">
                              <?php if($this->rbac->check_operation_permission('add')): ?>
                              <a href="<?= base_url('admin/services/add'); ?>" class="btn btn-success"><i
                                          class="fa fa-plus"></i> <?= trans('add_new_service') ?></a>
                              <?php endif; ?>
                        </div>
                  </div>
            </div>
            <div class="card">
                  <div class="card-body table-responsive">
                        <table id="na_datatable" class="table table-bordered table-striped" width="100%">
                              <thead>
                                    <tr>
                                          <th>#<?= trans('id') ?></th>
                                          <th>Title</th>
                                          <th>Description</th>
                                          <th>Rate</th>
                                          <th><?= trans('status') ?></th>
                                    </tr>
                              </thead>
                        </table>
                  </div>
            </div>
      </section>
</div>


<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.js"></script>

<script>
//---------------------------------------------------
var table = $('#na_datatable').DataTable({
      "processing": true,
      "serverSide": false,
      "ajax": "<?=base_url('admin/services/datatable_json')?>",
      "order": [
            [0, 'asc']
      ],
      "columnDefs": [{
                  "targets": 0,
                  "name": "id",
                  'searchable': true,
                  'orderable': true
            },
            {
                  "targets": 1,
                  "name": "title",
                  'searchable': true,
                  'orderable': true
            },
            {
                  "targets": 2,
                  "name": "description",
                  'searchable': true,
                  'orderable': false
            },
            {
                  "targets": 3,
                  "name": "rate",
                  'searchable': true,
                  'orderable': true
            },
            {
                  "targets": 4,
                  "name": "is_active",
                  'searchable': false,
                  'orderable': false
            }
      ]
});
</script>


<script type="text/javascript">
$("body").on("change", ".tgl_checkbox", function() {
      console.log('checked');
      $.post('<?=base_url("admin/services/change_status")?>', {
                  '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                  id: $(this).data('id'),
                  status: $(this).is(':checked') == true ? 1 : 0
            },
            function(data) {
                  $.notify("Status Changed Successfully", "success");
            });
});
</script>