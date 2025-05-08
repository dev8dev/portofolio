<div class="col-12 grid-margin stretch-card">
    <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Input Data - Testimonial</h4>
                        <div class="table-responsive">
                        <div align="right"><a class="btn btn-dark btn-rounded btn-fw" href="{{route('testimonial.create')}}"><i class="icon icon-plus mr-2"></i>Input Data</a></div>
                        </div>
                            <hr>
                            <div class="table-responsive">
                                <table id="t_testimonial" class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <tr bgcolor="#c7c6c1">
                                            <th width="100"><b>Image</th>
                                            <th width="200"><b>Nama Alumni</th>  
                                            <th width="100"><b>Status</th>
                                            <th width="300"><b>Description</th>
                                            <th width="100"><b>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                
            </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#t_testimonial').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            responsive: true, // <-- penting!
            autoWidth: false,
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "dom": "<'row mb-2'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start dt-toolbar'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">",
            ajax: "{{ route('testimonial.index') }}",
            columns: [
                {
                    data: 'image_path',
                    name: 'image_path',
                    render: function(data) {
                    return data ? '<img src="public/images/'+data+'" width="100">' : 'No Image';
                    }
                },
                {
                    data: 'nama_alumni',
                    name: 'nama_alumni'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'description',
                    name: 'description',
                    render: function(data) {
                    return data ? data.substring(0, 100) + '...' : '';
                }
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });

     
        $(document).on('click', '.deleteForm', function() {
        var id = $(this).data('id');
        var $row = $(this).closest('tr');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'testimonial/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                            Swal.fire({
                                title: 'Memproses...',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            
                            // Hapus row atau reload datatable
                            $row.fadeOut(300, function() {
                                $(this).remove();
                            });
                            
                            // Atau jika pakai server-side:
                            // $('#dataTable').DataTable().ajax.reload(null, false);
                        },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON?.message || 'Terjadi kesalahan',
                            'error'
                        );
                    }
                });
            }
        });
    });

        // Print functionality
        // $('#printTable').on('click', function () {
        //     var tableContent = $('#t_activity').clone();
        //     var newWindow = window.open('', '', 'height=600,width=800');
        //     newWindow.document.write('<html><head><title>Print Data</title>');
        //     newWindow.document.write('<style>table {width: 100%; border-collapse: collapse;} table, th, td {border: 1px solid black;} th, td {padding: 10px; text-align: left;}</style>');
        //     newWindow.document.write('</head><body>');
        //     newWindow.document.write('<h3>Data Program</h3>');
        //     newWindow.document.write(tableContent[0].outerHTML);
        //     newWindow.document.write('</body></html>');
        //     newWindow.document.close();
        //     newWindow.print();
        // });
    });
</script>