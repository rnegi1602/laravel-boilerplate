@extends('layouts.main')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-default">
                   <div class="card-header">
                        <h3 class="card-title">Change Password</h3>
                    </div>
                    <form method="POST" action="{{ route('updatePwd', Auth::user()->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="currentPassword">Current Password</label>
                                <input type="password" class="form-control {{ $errors->has('current_password') ? ' is-invalid' : null }}" id="currentPassword" placeholder="Password" name="current_password">
                                @error('current_password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" class="form-control {{ $errors->has('new_password') ? ' is-invalid' : null }}" id="newPassword" placeholder="Password" name="new_password">
                                @error('new_password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm New Password</label>
                                <input type="password" class="form-control {{ $errors->has('confirm_new_password') ? ' is-invalid' : null }}" id="confirmNewPassword" placeholder="Password" name="confirm_new_password">
                                @error('confirm_new_password')
                                    <span class="error invalid-feedback">{{ $message }}</span>
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
        </section>
    </div>
@endsection