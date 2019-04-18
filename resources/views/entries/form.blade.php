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
                                    <h4 class="card-title">Modify a Entry</h4>
                                    <p class="card-category">Edit a task entry</p>
                                @else
                                    <h4 class="card-title">New Entry</h4>
                                    <p class="card-category">Register a new entry to your task</p>
                                @endif
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ isset($data->id) ? route('entries@update', ['task_id' => $task->id, 'id' => $data->id]):route('entries@store', ['task_id' => $task->id]) }}">
                                    @csrf

                                    @if(isset($data->id))
                                        @method('PUT')
                                    @endif

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="task">Task</label>
                                                <input type="text" class="form-control" disabled value="{{ $task->title }}">
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
                                                <label class="bmd-label-floating" for="type">Type</label>
                                                <select name="type" class="form-control {{ $errors->has('type') ? 'is-invalid':'' }}">
                                                    <option value="0" {{ (isset($data->type) && '0' == $data->type) ? 'selected':'' }}>Negative</option>
                                                    <option value="1" {{ (isset($data->type) && '1' == $data->type) ? 'selected':'' }}>Positive</option>
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