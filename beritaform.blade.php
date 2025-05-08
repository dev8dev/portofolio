<div class="">
    <div id="lorem-left" class="tab-pane fade show active accordion-item" role="tabpanel">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs  " data-bs-toggle="tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="{{route('berita.index')}}" onclick="table_link()" id="btnTabTable" class="nav-link " data-bs-toggle="tab" aria-selected="true" role="tab">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-border-all" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"></path>
                                <path d="M4 12l16 0"></path>
                                <path d="M12 4l0 16"></path>
                            </svg> Tabel Data </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#dataForm" id="btnTabForm" class="nav-link active" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ad-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M11.933 5h-6.933v16h13v-8"></path>
                                <path d="M14 17h-5"></path>
                                <path d="M9 13h5v-4h-5z"></path>
                                <path d="M15 5v-2"></path>
                                <path d="M18 6l2 -2"></path>
                                <path d="M19 9h2"></path>
                            </svg>
                            Form</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane " id="dataTabel" role="tabpanel">
                    </div>                        
                        <div class="tab-pane active show " id="dataForm" role="tabpanel">      
                                <form class="form-sample" id="id_form" action="" method="POST">
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="judul" class="form-control" placeholder="Judul" Value = "@if($t_berita!=''){{$t_berita->judul}}@endif">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Terbit</label>
                                        <input type="date" name="tgl_terbit" class="form-control" placeholder="tgl terbit" Value = "@if($t_berita!=''){{$t_berita->tgl_terbit}}@endif">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Image Upload</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control file-upload-info" name="image" type="file" id="image">
                                                        @if(!empty($t_berita) && !empty($t_berita->image_path))
                                                            <input type="hidden" name="image_path" value="{{ $t_berita->image_path }}">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Current Image</label>
                                                    <div class="col-sm-9">
                                                        @if(!empty($t_berita) && !empty($t_berita->image_path))
                                                            <img src="{{ asset('public/images/' . $t_berita->image_path) }}" alt="Current Image" class="img-thumbnail" width="200px">
                                                        @else
                                                            <p>No image available</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea rows="3" class="form-control" name="description" id="editor"> @if($t_berita!=''){{$t_berita->description}}@endif</textarea><br>
                                        <input type="hidden" id="txtPrimarykey" name="id" class="form-control" value="@if($t_berita !='') {{$t_berita->id}}@endif">
                                        <input type="hidden" id="action" class="form-control">
                                        <div style="float:right;">
                                            <a href="{{route('berita.index')}}" class="btn btn-inverse-danger btn-fw btn-icon-text" id="btnCancel" onclick="actCancel()"><i class="mdi mdi-reload btn-icon-prepend"></i>&nbsp;Cancel</a>
                                            <button type="submit" class="btn btn-inverse-info btn-fw btn-icon-text" id="savedata"><i class="mdi mdi-file-check btn-icon-prepend"></i> &nbsp;Save</button>
                                        </div>
                                    </div>
                                    
                                </form>                 
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    let editor;
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(newEditor => {
            editor = newEditor;
        })
            .catch(error => {
                console.error(error);
            });

</script>

<script type='text/javascript'>
    function table_link() {
        window.location.replace('{{route("berita.store")}}');
    }
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#savedata').click(function(e) {
            e.preventDefault();
            var $submitBtn = $(this);
            $submitBtn.html('<i class="mdi mdi-loading mdi-spin"></i> Processing...');
            $submitBtn.prop('disabled', true);

            let formData = new FormData($('#id_form')[0]);
            formData.append('description', editor.getData());

            $.ajax({
                type: 'POST',
                url: '{{ route("berita.store") }}',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Data saved successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = '{{ route("berita.index") }}';
                    });
                },
                error: function(xhr) {
                    $submitBtn.html('<i class="mdi mdi-file-check btn-icon-prepend"></i> Save');
                    $submitBtn.prop('disabled', false);
                    
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    
                    if (errors) {
                        errorMessage = '<ul>';
                        $.each(errors, function(key, value) {
                            errorMessage += '<li>' + value + '</li>';
                        });
                        errorMessage += '</ul>';
                    } else {
                        errorMessage = xhr.responseJSON.message || 'An error occurred';
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        html: errorMessage
                    });
                }
            });
        });
    });
</script>