@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Profile</h3>
                </div>
                @include('partials.session-msgs')
                <form method="POST" action="{{ route('updateProfile', Auth::user()->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        @if($errors->has('profile_photo'))
                        <div class="alert alert-danger alert-dismissible alert-fade fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="profilePhoto">Profile Photo</label>
                            <div class="text-left">
                                <img class="image profile-user-img img-fluid img-circle"
                                    src="{{ $user->profile_photo ? asset('images/users/'.$user->profile_photo) : asset('images/avatar.png')}}"
                                    alt="TestImage" width="100" />
                                
                                <a id="upload_profile_photo" class="btn btn-primary update_photo" data-toggle="modal"
                                data-target="#modal-xl">Upload Photo</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="hidden" name="id" id="userId" value="{{ $user->id }}" />
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Enter Name"
                                value="{{ $user->name }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder=""
                                value="{{$user->email}}" disabled>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->
        
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        @include('settings.modals.update-thumb-modal')
    </section>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" defer></script>
<script defer>
window.addEventListener('load', function() {
    var $modal = $('#modal');
    var image = document.getElementById('image');
    var cropper;

    $("#upload_profile_photo").on('click', function(e){
        e.preventDefault();
        $('#newThumb').click();
    })
    $("#newThumb").on('change', function(e){
        var files = e.target.files;
        var done = function (url) {
            image.src = url;
            $('#modal').modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: 1 / 1,
            autoCropArea: 0,
            minContainerWidth: 160,
            minContainerHeight: 160,
            viewMode: 3,
            preview: '.preview',
            crop: function crop(event) {
                $("#lg_x1").val(event.detail.x);
                $("#lg_y1").val(event.detail.y);
                $("#lg_h").val(event.detail.height);
                $("#lg_w").val(event.detail.width);
                $("#image").on("dragend.cropper", function () {
                    $("#image").cropper("setData", {
                        width: 160,
                        height: 160
                    });
                });
            }
        });
    }).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
    });
});
</script>
@endsection