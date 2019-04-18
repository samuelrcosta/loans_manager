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
                                    <h4 class="card-title">Modify a Task</h4>
                                    <p class="card-category">Edit a existent task</p>
                                @else
                                    <h4 class="card-title">New Task</h4>
                                    <p class="card-category">Register a new task</p>
                                @endif
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ isset($data->id) ? route('tasks@update', ['id' => $data->id]):route('tasks@store') }}">
                                    @csrf

                                    @if(isset($data->id))
                                        @method('PUT')
                                    @endif

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="contact">Contact</label>
                                                <select name="contact" class="form-control {{ $errors->has('contact') ? 'is-invalid':'' }}">
                                                    <option value="">---</option>
                                                    @foreach($contacts as $contact)
                                                    <option value="{{ $contact->id }}" {{ (isset($data->contact_id) && $contact->id == $data->contact_id) ? 'selected':'' }}>{{ $contact->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('contact'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('contact') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="type">Type</label>
                                                <select name="type" class="form-control {{ $errors->has('type') ? 'is-invalid':'' }}">
                                                    <option value="income" {{ (isset($data->type) && 'income' == $data->type) ? 'selected':'' }}>Income</option>
                                                    <option value="debt" {{ (isset($data->type) && 'debt' == $data->type) ? 'selected':'' }}>Debt</option>
                                                </select>
                                                @if ($errors->has('type'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('type') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="title">Title</label>
                                                <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid':'' }}" maxlength="255" value="{{ isset($data->title) ? $data->title:'' }}">
                                                @if ($errors->has('title'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('title') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="value">Value</label>
                                                <input type="text" name="value" class="form-control currency-format {{ $errors->has('value') ? 'is-invalid':'' }}" value="{{ isset($data->value) ? number_format($data->value, 2, ',', '.'):'' }}">
                                                @if ($errors->has('value'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('value') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="status">Status</label>
                                                <select name="status" class="form-control {{ $errors->has('status') ? 'is-invalid':'' }}">
                                                    <option value="0" {{ (isset($data->status) && '0' == $data->status) ? 'selected':'' }}>Inactive</option>
                                                    <option value="1" {{ (isset($data->status) && '1' == $data->status) ? 'selected':'' }}>Active</option>
                                                </select>
                                                @if ($errors->has('status'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('status') }}</strong>
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