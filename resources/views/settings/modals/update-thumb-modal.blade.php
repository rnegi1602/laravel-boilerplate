<!-- Update User Thumb Modal -->
<div class="modal hide fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8" id="thumbnail-container">
                            <img id="image" src="{{ asset('images/logo.png') }}">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form class="form-horizontal" method="POST" action="{{ route('updateThumb', $user->id) }}"
                    enctype="multipart/form-data" id="thumb-form">
                    {{ csrf_field() }}
                    @method('PATCH')
                    <input type="hidden" id="lg_x1" name="lg_x1" value="0">
                    <input type="hidden" id="lg_y1" name="lg_y1" value="0">
                    <input type="hidden" id="lg_w" name="lg_w" value="0">
                    <input type="hidden" id="lg_h" name="lg_h" value="0">
                    <input type="file" name="profile_photo" id="newThumb" class="form-control" style="display: none;"
                        accept='image/*'>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="crop">Crop</button>
                </form>
            </div>
        </div>
    </div>
</div>