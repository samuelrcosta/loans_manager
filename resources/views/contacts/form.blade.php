<!DOCTYPE html>
<html lang="en">

@include('includes/header')

<body class="dark-edition">
<div class="wrapper ">
    @include('includes/menu')
    <div class="main-panel">
        @include('includes/navbar')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @if (session('responseSuccess'))
                        <div class="col-lg-12 col-md-12">
                            <div class="alert alert-success" role="alert">
                                {!! session('responseSuccess') !!}
                            </div>
                        </div>
                    @endif
                    @if (session('responseError'))
                        <div class="col-lg-12 col-md-12">
                            <div class="alert alert-danger">
                                {!! session('responseError') !!}
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                @if(isset($data->id))
                                <h4 class="card-title">Modify a Contact</h4>
                                <p class="card-category">Edit a contact from your wallet</p>
                                @else
                                <h4 class="card-title">New Contact</h4>
                                <p class="card-category">Register a new contact to your wallet</p>
                            @endif
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ isset($data->id) ? route('contacts@update', ['id' => $data->id]):route('contacts@store') }}">
                                    @csrf

                                    @if(isset($data->id))
                                        @method('PUT')
                                    @endif

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="name">Name</label>
                                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" maxlength="150" value="{{ isset($data->name) ? $data->name:'' }}">
                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="nickname">Nickname</label>
                                                <input type="text" name="nickname" class="form-control {{ $errors->has('nickname') ? 'is-invalid':'' }}" maxlength="100" value="{{ isset($data->nickname) ? $data->nickname:'' }}">
                                                @if ($errors->has('nickname'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('nickname') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="email">E-mail</label>
                                                <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" maxlength="150" value="{{ isset($data->email) ? $data->email:'' }}">
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="phone">First Phone</label>
                                                <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid':'' }}" maxlength="45" value="{{ isset($data->phone) ? $data->phone:'' }}">
                                                @if ($errors->has('phone'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('phone') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="phone_2">Second Phone</label>
                                                <input type="text" name="phone_2" class="form-control {{ $errors->has('phone_2') ? 'is-invalid':'' }}" maxlength="45" value="{{ isset($data->phone_2) ? $data->phone_2:'' }}">
                                                @if ($errors->has('phone_2'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('phone_2') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-group bmd-form-group">
                                                    <label class="bmd-label-floating" for="comments">Comments</label>
                                                    <textarea class="form-control {{ $errors->has('comments') ? 'is-invalid':'' }}" name="comments" rows="5">{{ isset($data->comments) ? $data->comments:'' }}</textarea>
                                                    @if ($errors->has('comments'))
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('comments') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes/footer')
    </div>
</div>
@include('includes/js')
</body>
</html>