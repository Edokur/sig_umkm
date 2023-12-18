@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
</nav>

{{-- <div class="card shadow mb-4">
    <div class="card-body">
        <div class="section-body">
            <h2 class="section-title">Hi, {{ auth()->user()->name }}</h2>
            <p class="section-lead">Change information about yourself on this page.</p>
    
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <form action="/profile/update" method="POST" id="ProfileForm" name="ProfileForm" class="form-horizontal" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" name="id" id="idProfile" value="{{ auth()->user()->id }}">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="name" id="nameProfile" value="{{ auth()->user()->name }}" required="">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="username" id="usernameProfile" value="{{ auth()->user()->email }}" required="" disabled>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary" id="saveProfile">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card">
                        <form action="/profile/changepassword" method="post">
                            <div class="card-header">
                                <h4 class="text-secondary">Ubah Password</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="idUser" id="idUser" value="{{ auth()->user()->id }}">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Password Lama</label>
                                        <input type="text" name="passwordLamaUser" id="passwordLamaUser" class="form-control " required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>Password Baru</label>
                                        <input type="text" name="passwordBaruUser" id="passwordBaruUser" class="form-control" required="">
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Konfirmasi Password Baru</label>
                                        <input type="text" name="konfirmasiPasswordUser" id="konfirmasiPasswordUser" class="form-control"required="">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-secondary" type="reset">Reset</button>
                                <button class="btn btn-primary" type="submit" id="changepassword">Perbarui Password</button>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Profile</div>
            </div>
            <form>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="username" id="usernameProfile" value="{{ auth()->user()->name }}" required="" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="username" id="usernameProfile" value="{{ auth()->user()->email }}" required="" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Ubah Password</div>
            </div>
            <form action="{{ route('changepassword') }}" method="POST">
                @csrf
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ session('info') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-error alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="row">
                        <input type="hidden" name="idUser" id="idUser" value="{{ auth()->user()->id }}">
                        <div class="form-group col-md-6 col-12">
                            <label>Password Lama</label>

                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control @error('oldPassword') is-invalid @enderror" name="oldPassword" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true" onMouseOver="this.style.cursor='pointer'"></i></span>
                                </div>
                            </div>
                            <!-- error message untuk title -->
                            @error('oldPassword')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label>Password Baru</label>

                            <div class="input-group" id="show_hide_passwordnew">
                                <input type="password" class="form-control @error('newPassword') is-invalid @enderror" name="newPassword" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true" onMouseOver="this.style.cursor='pointer'"></i></span>
                                </div>
                            </div>
                            <!-- error message untuk title -->
                            @error('newPassword')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Konfirmasi Password Baru</label>

                            <div class="input-group" id="show_hide_passwordconfirm">
                                <input type="password" class="form-control @error('confirmPassword') is-invalid @enderror" name="confirmPassword" required>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true" onMouseOver="this.style.cursor='pointer'"></i></span>
                                </div>
                            </div>
                            <!-- error message untuk title -->
                            @error('confirmPassword')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-danger" type="reset" >Reset</button>
                    <button type="submit" class="btn btn-primary">Perbarui Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#show_hide_password span").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_password input').attr("type") == "text"){
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass( "fa-eye-slash" );
                    $('#show_hide_password i').removeClass( "fa-eye" );
                }else if($('#show_hide_password input').attr("type") == "password"){
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass( "fa-eye-slash" );
                    $('#show_hide_password i').addClass( "fa-eye" );
                }
            });

            $("#show_hide_passwordnew span").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_passwordnew input').attr("type") == "text"){
                    $('#show_hide_passwordnew input').attr('type', 'password');
                    $('#show_hide_passwordnew i').addClass( "fa-eye-slash" );
                    $('#show_hide_passwordnew i').removeClass( "fa-eye" );
                }else if($('#show_hide_passwordnew input').attr("type") == "password"){
                    $('#show_hide_passwordnew input').attr('type', 'text');
                    $('#show_hide_passwordnew i').removeClass( "fa-eye-slash" );
                    $('#show_hide_passwordnew i').addClass( "fa-eye" );
                }
            });

            $("#show_hide_passwordconfirm span").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_passwordconfirm input').attr("type") == "text"){
                    $('#show_hide_passwordconfirm input').attr('type', 'password');
                    $('#show_hide_passwordconfirm i').addClass( "fa-eye-slash" );
                    $('#show_hide_passwordconfirm i').removeClass( "fa-eye" );
                }else if($('#show_hide_passwordconfirm input').attr("type") == "password"){
                    $('#show_hide_passwordconfirm input').attr('type', 'text');
                    $('#show_hide_passwordconfirm i').removeClass( "fa-eye-slash" );
                    $('#show_hide_passwordconfirm i').addClass( "fa-eye" );
                }
            });
        });
    </script>   
@endpush