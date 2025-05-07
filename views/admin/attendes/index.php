<div class="main-content">

    <div class="page-content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-6">

                    <div class="page-title-box">

                        <h4><?=$title?></h4>

                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Dashboard</a></li>

                            <li class="breadcrumb-item active"><?=$title?></li>

                        </ol>

                    </div>

                </div>

                <div class="col-sm-6">

                    <div class="state-information d-none d-sm-block">

                        <div class="state-graph">

                            <a href="<?=base_url('admin/attendes/import/');?>" class="btn btn-primary waves-effect waves-light btn-lg"></i>Import</a>

                        </div>

                    </div>

                    <div class="state-information d-none d-sm-block">

                        <!-- <div class="state-graph">

                            <a href="base_url('admin/attendes/download_logos/');?>" class="btn btn-primary waves-effect waves-light btn-lg"></i>Download logo</a>

                        </div> -->

                    </div>

                </div>

            </div>

            <?php if ($this->session->flashdata('message') !== null) {?>

            <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible">

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close">×</button>

                <?php print_r($this->session->flashdata('message')['1']);?>

            </div>

            <?php }?>

            <div class="row">

                <div class="col-12">

                    <div class="card">

                    <div class="card-header">

                        <h4 class="card-title"><?=$title?></h4>

                    </div>

                        <div class="card-body">

                            <div class="table-responsive">

                                <table id="attendes" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">

                                    <thead>

                                        <tr>

                                            <th></th>

                                            <th>Name</th>

                                            <th>Position</th>

                                            <th>Industry</th>

                                            <th>Country</th>
                                            <th>Action</th>


                                        </tr>

                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<script type="text/javascript">

    $(document).ready(function () {

        oTable = $('#attendes').dataTable({

            "aaSorting": [[1, "asc"]],

            "serverSide": true,

            "fixedHeader": true,

            "responsive": false,

            "autoWidth" : false,

            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],

            "iDisplayLength": 10,

            'bProcessing': true, 'bServerSide': true,"bDestroy": true,"bRetrieve":true,

            'sAjaxSource': "<?=site_url('admin/attendes/getAttende/')?>",

            'fnServerData': function (sSource, aoData, fnCallback) {

                aoData.push({

                    "name": "<?=$this->security->get_csrf_token_name()?>",

                    "value": "<?=$this->security->get_csrf_hash()?>"

                },

                {

                    "name": "sColumns",

                    "value": "",

                });



                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});

            },

            "columnDefs": [{

                "defaultContent": "-",

                "targets": "_all",

            }],

            "aoColumns": [

            {

                "bVisible": false,

            },

            null,

            null,

            null,

            null,
            null,

            ],

            'fnRowCallback': function (nRow, aData, iDisplayIndex) {

                var oSettings = oTable.fnSettings();

                nRow.id = aData[0];

                nRow.className = "attendes_list";

                return nRow;

            },

            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {

            },

            "fnDrawCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {

                $('[data-toggle="popover"]').popover();

                $('[data-toggle="tooltip"]').tooltip();

            }

        });

    });

    $(document).on('click', 'tr td:first-child', function(){

       $('[data-toggle="popover"]').popover();

       $('[data-toggle="tooltip"]').tooltip();

    });
    $('#attendes').on('click', '#dlt_attendee', function(e) {
    e.preventDefault();

    var eventId = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= site_url('admin/attendes/deleteattendee') ?>",
                type: 'POST',
                data: { id: eventId },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status == '1') {
                        Swal.fire({
                            title: 'Deleted!',
                            text: result.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                               
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Failed!',
                            text: result.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                           
                                location.reload();
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                }
            });
        }
    });
});


</script>