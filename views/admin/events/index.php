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
                            <a href="<?=base_url('admin/events/import/');?>" class="btn btn-primary waves-effect waves-light btn-lg"></i>Import</a>
                        </div>
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
                                <table id="event" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Title</th>
                                            <th>Organizer</th>
                                            <th>Location</th> 
                                             <th>Date</th> 
                                             <th>Time</th>
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
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="true">
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Event</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="post">
                <input type="hidden" id="eventId" name="id">
                <div class="form-group">
                        <label for="eventTitle">Title</label>
                        <input type="text" class="form-control" id="eventTitle" name="title">
                    </div>
                    <!-- Add other fields as needed -->
                    <div class="form-group">
                        <label for="eventOrganizer">Organizer</label>
                        <input type="text" class="form-control" id="eventOrganizer" name="organizer">
                    </div>
                    <div class="form-group">
                        <label for="eventLocation">Location</label>
                        <input type="text" class="form-control" id="eventLocation" name="location">
                    </div>
                    <div class="form-group">
                        <label for="eventLink">Link</label>
                        <input type="text" class="form-control" id="eventLink" name="link">
                    </div>
                    <div class="form-group">
                        <label for="eventPrice">Price</label>
                        <input type="text" class="form-control" id="eventPrice" name="price">
                    </div>
                    <div class="form-group">
                        <label for="eventDay">Day</label>
                        <input type="text" class="form-control" id="eventDay" name="day">
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Date</label>
                        <input type="text" class="form-control" id="eventDate" name="date">
                    </div>
                    <div class="form-group">
                        <label for="eventTime">Time</label>
                        <input type="text" class="form-control" id="eventTime" name="time">
                    </div>
                    <button type="button" id="update_btn" class="btn btn-primary mt-3">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        oTable = $('#event').dataTable({
            "aaSorting": [[1, "asc"]],
            "serverSide": true,
            "fixedHeader": true,
            "responsive": false,
            "autoWidth" : false,
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": 10,
            'bProcessing': true, 'bServerSide': true,"bDestroy": true,"bRetrieve":true,
            'sAjaxSource': "<?=site_url('admin/events/getEvents/')?>",
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

    $('#event').on('click', '#delete', function(e) {
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
                url: "<?= site_url('admin/events/deleteEvent') ?>",
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
                                // Refresh the page when user clicks 'OK'
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
                                // Refresh the page when user clicks 'OK'
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
    
  
    $('#event').on('click', '#edit', function(e) {
    e.preventDefault();
            var eventId = $(this).data('id');
             $.ajax({
                url: '<?=site_url('admin/events/getEventById')?>', 
                type: 'POST',
                data: { id: eventId },
                success: function(data) {
                    var data = typeof data === 'string' ? JSON.parse(data) : data;
                    $('#eventId').val(data.id);
                    $('#eventTitle').val(data.Title);
                    $('#eventOrganizer').val(data.Organizer);
                    $('#eventLocation').val(data.Location);
                    $('#eventLink').val(data.Link);
                    $('#eventPrice').val(data.Price ? data.Price : '');
                    $('#eventDay').val(data.Day);
                    $('#eventDate').val(data.Date);
                    $('#eventTime').val(data.Time);

                    // Show the modal
                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
            }   
            });
        });
        $('#update_btn').on('click', function() {
           
            var formData = new FormData($('#editForm')[0]);
                     
               $.ajax({
                    url: "<?= base_url('admin/events/updateEvent')?>", 
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var result = JSON.parse(response);
                      
                        if (result.status == '1') {
                            Swal.fire({
                                title: 'Update!',
                                text: result.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reload the page when user clicks 'OK'
                                    location.reload();
                                }
                            });
                            $('#editModal').modal('hide');
                            
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
            });

</script>
