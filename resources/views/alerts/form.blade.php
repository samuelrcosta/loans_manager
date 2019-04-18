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
                            <div class="card-header card-header-warning">
                                @if(isset($data->id))
                                    <h4 class="card-title">Modify a Alert</h4>
                                    <p class="card-category">Edit a existent alert</p>
                                @else
                                    <h4 class="card-title">New Alert</h4>
                                    <p class="card-category">Register a new alert</p>
                                @endif
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ isset($data->id) ? route('alerts@update', ['id' => $data->id]):route('alerts@store') }}">
                                    @csrf

                                    @if(isset($data->id))
                                        @method('PUT')
                                    @endif

                                    <div class="row">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="task">Task</label>
                                                <select name="task" class="form-control {{ $errors->has('task') ? 'is-invalid':'' }}">
                                                    <option value="">---</option>
                                                    @foreach($tasks as $task)
                                                        <option value="{{ $task->id }}" {{ ((isset($task_id) && $task->id == $task_id) || (isset($data->task->id) && $data->task->id == $task->id)) ? 'selected':'' }}>{{ $task->title }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('task'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('task') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="repeats">Repeats?</label>
                                        </div>
                                        <div class="col-md-12" style="margin-bottom: 20px;">
                                            <div class="form-check form-check-radio form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="repeats" value="0" {{ isset($data->repeats) && $data->repeats == 0 ? 'checked':'' }}> No
                                                    <span class="circle">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-radio form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="repeats" value="1" {{ isset($data->repeats) && $data->repeats == 1 ? 'checked':'' }}> Yes
                                                    <span class="circle">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row custom-view-row">
                                        <div class="col-md-4">
                                            <div class="form-group bmd-form-group">
                                                <label class="" for="date">Start Date</label>
                                                <input type="date" name="date" class="form-control {{ $errors->has('date') ? 'is-invalid':'' }}" value="{{ isset($data->date) ? $data->date:date('Y-m-d') }}">
                                                @if ($errors->has('date'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('date') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 container-repeat_day">
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating" for="repeat_day">Repeat Day</label>
                                                <input type="number" name="repeat_day" class="form-control number-format {{ $errors->has('repeat_day') ? 'is-invalid':'' }}" value="{{ isset($data->repeat_day) ? $data->repeat_day:'' }}">
                                                @if ($errors->has('repeat_day'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('repeat_day') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
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
<script>
    $(function(){
      let repeats = $("input[name='repeats']:checked").val();
      if(!repeats){
        $( "input[name='repeats'][value='0']" ).prop("checked", true );
      }

      changeCustomFields();
    });

    $(document).on('change', "input[name='repeats']", function(){
      changeCustomFields();
    });

    function changeCustomFields(){
      let repeats = $("input[name='repeats']:checked").val();

      if(repeats == 1){
        $('label[for="date"]').html("Start Date");
        $('.container-repeat_day').slideDown();
      }else{
        $('label[for="date"]').html("Alert Date");
        $('.container-repeat_day').slideUp();
        $('[name="repeat_day"]').val("");
      }
    }


</script>
</body>
</html>