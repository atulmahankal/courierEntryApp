@extends('layouts.app')

@section('title', 'Profile')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Profile</li>
@endsection

@section('style')
@endsection

@section('script')
<script>
  // $('body').addClass('login-page');

</script>
@endsection

@section('control-sidebar')
<aside class="control-sidebar control-sidebar-dark">
</aside>
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="card card-primary card-outline sticky-top">
          <div class="card-body box-profile row">
            <div class="text-center col-6 col-md-12 row">
              {{-- <img src="http://ci.bizipac.local/assets/img/user1-128x128.jpg" alt="User Avatar" class="img-size-60 mr-3 img-circle col-12"> --}}

              <img class="img-size-50 mr-3 col-12 profile-user-img img-fluid img-circle" src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" alt="{{ Auth::user()->name }}" class="img-circle elevation-2">

              {{-- <a href="#" class="col-auto mx-auto">
                <i class="fa fa-image"></i>
              </a>
              <a href="#" class="col-auto mx-auto">
                <i class="fa fa-ban"></i>
              </a> --}}
            </div>

            <div class="col-6 col-md-12 mt-2 mb-3">
              <p><b>Name:</b><br />{{ auth()->user()->name }}</p>
              <p><b>Email:</b><br >{{ auth()->user()->email }}</p>
            </div>
          </div>

        </div>
      </div>

      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link active" href="#updatePassword" data-toggle="tab">
                  Update Password
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#personal_information" data-toggle="tab">
                  personal information
                </a>
              </li>
              {{-- <li class="nav-item">
								<a class="nav-link" href="#tfa" data-toggle="tab">
									Two Factor Authentication
								</a>
							</li> --}}
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="updatePassword">

                <form method='post' action="{{ route('user-password.update') }}" class="timeline-inverse">
                  @csrf @method('put')
                  <div class="form-group">
                    <label for="current_password">Current password:</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter Current password">
                    @if ($errors->has('current_password'))
                    <span class="text-danger">
                      <strong>{{ $errors->first('current_password') }}</strong>
                    </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password">
                    @if ($errors->has('password'))
                    <span class="text-danger">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm Password">
                    @if ($errors->has('password_confirmation'))
                    <span class="text-danger">
                      <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                    @endif
                  </div>
                  <button type="submit" class="btn btn-primary float-right">Save</button>
                </form>
              </div>

              <div class="tab-pane" id="personal_information">
                <form  method='post' action="{{ route('user-profile-information.update') }}" >
                  @csrf @method('put')
                  <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ auth()->user()->name }}">
                    @if ($errors->has('password'))
                    <span class="text-danger">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ auth()->user()->email }}">
                    @if ($errors->has('password'))
                    <span class="text-danger">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">Save</button>
                </form>
              </div>

              {{-- <div class="tab-pane" id="tfa">
								<h5><b>Two Factor Authentication</b></h5>
								Add additional security to your account using two factor authentication.
								<div class="card mt-3" id="enable2fa">
									<div class="card-header font-weight-bold p-2">
										You have not enabled two factor authentication.
									</div>
									<div class="card-body">
										When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.
										<a href="#" class="btn btn-primary float-right mt-3 px-5" data-toggle="modal" data-target="#modal-lg">Enable</a>
									</div>
									<div class="modal fade" id="modal-lg">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Confirm Password</h4>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													For your security, please confirm your password to continue.
													<div class="form-group mt-2">
														<input type="password" class="form-control" id="password" placeholder="Enter password">
													</div>
												</div>
												<div class="modal-footer justify-content-between">
													<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
													<button type="button" class="btn btn-primary">Confirm</button>
												</div>
											</div>

										</div>
									</div>
								</div>

								<div class="card mt-3" id="confirm2fa">
									<div class="card-header font-weight-bold p-2">
										Finish enabling two factor authentication.
									</div>
									<div class="card-body">
										When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.
										<br>
										<b>To finish enabling two factor authentication, scan the following QR code using your phone's authenticator application or enter the setup key and provide the generated OTP code.
										</b>
										<br>
										<div style="height:200px;" class="border">QR code</div>
										<div class="font-weight-bold p-2">Setup Key: GPJZB2IPIRS7BAI4</div>
										<form></form>
										<div class="form-group">
											<label for="Phone_No">Phone No:</label>
											<input type="number" class="form-control" id="Phone_No" placeholder="Enter Phone No">
										</div>
										<div class="float-right">
											<a href="#" class="btn btn-primary mt-3 px-3">Enable</a>
											<a href="#" class="btn btn-secondary mt-3 px-3">cancel</a>
										</div>
										</form>
									</div>
								</div>

								<div class="card mt-3" id="disable2fa">
									<div class="card-header font-weight-bold p-2">
										You have enabled two factor authentication.
									</div>
									<div class="card-body">
										When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.
										<div style="height:200px;" class="border">Recovery code</div>
										<div class="float-right">
											<a href="#" class="btn btn-secondary mt-3 px-3">Show Reovery Code</a>
											<a href="#" class="btn btn-primary mt-3 px-3">Disable</a>
										</div>
									</div>
								</div>
							</div> --}}

            </div>
          </div>

        </div>

      </div>

    </div>

  </div>
</section>
@endsection
