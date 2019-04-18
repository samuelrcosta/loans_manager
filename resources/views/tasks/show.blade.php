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
                            <div class="card-header {{ $data->type == 'debt' ? 'card-header-danger':'card-header-success' }}">
                                <h4 class="card-title">{{ $data->title }}</h4><small>{{ ucfirst($data->type) }}</small>
                                <p class="card-category">Task created on {{ $data->created_at }}</p>
                            </div>
                            <div class="card-body">
                                <p><strong>Contact: </strong>{{ $data->contact ? $data->contact->name:' - ' }}</p>
                                <p><strong>Status: </strong>{{ $data->status == 1 ? 'Active':'Inactive' }}</p>
                                <p><strong>Original Value: </strong>R$ {{ number_format($data->value, 2, ',', '.') }}</p>
                                <p><strong>Remaining Value: </strong>R$ {{ number_format($data->remaining(), 2, ',', '.') }}</p>
                                <p style="white-space: pre-wrap; word-wrap: break-word;"><strong>Comments: </strong><br>{{ $data->comments }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <a href="{{ route('entries@create', ['task_id' => $data->id]) }}" class="btn btn-success">New Entry</a>
                        <a href="{{ route('alerts@create').'?task_id='.$data->id }}" class="btn btn-success">New Alert</a>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title">Entries</h4>
                            </div>
                            <div class="card-body">
                                @if($data->entries->isNotEmpty())
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead class=" text-primary">
                                            <tr>
                                                <th>ID</th>
                                                <th class="text-center" width="30%">Value</th>
                                                <th class="text-center" width="30%">Date</th>
                                                <th class="text-center text-nowrap">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data->entries as $entry)
                                                    <tr
                                                    data-type="Entry"
                                                    data-value="{{ $entry->type ? ' + ':' - ' }} R$ {{ number_format($entry->value, 2, ',', '.') }}" data-name="{{ $entry->id }}"
                                                    data-action="{{ route('entries@destroy', ['id' => $entry->id, 'task_id' => $data->id]) }}"
                                                    >
                                                        <td>{{ $entry->id }}</td>
                                                        <td class="text-center {{ entry_color($entry) }}">{{ $entry->type ? ' + ':' - ' }} R$ {{ number_format($entry->value, 2, ',', '.') }}</td>
                                                        <td class="text-center">{{ $entry->created_at }}</td>
                                                        <td class="text-center text-nowrap">
                                                            <a rel="tooltip" href="{{ route('entries@edit', ['task_id' => $data->id, 'id' => $entry->id])  }}" class="btn btn-white btn-link btn-sm" data-original-title="Edit Entry">
                                                                <i class="material-icons">edit</i>
                                                            </a>
                                                            <button type="button" rel="tooltip" title="" class="btn btn-white btn-link btn-sm action-remove" data-original-title="Remove Entry">
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                No Records
                                @endif
                            </div>
                        </div>
                    </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary">
                                    <h4 class="card-title">Alerts</h4>
                                </div>
                                <div class="card-body">
                                    @if($data->alerts->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead class=" text-primary">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Title</th>
                                                    <th class="text-nowrap">Date</th>
                                                    <th class="text-center text-nowrap">Repeat</th>
                                                    <th class="text-center text-nowrap">Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data->alerts as $alert)
                                                    <tr
                                                            data-name="{{ $alert->title }}"
                                                            data-type="Alert"
                                                            data-action="{{ route('alerts@destroy', ['id' => $alert->id]) }}"
                                                    >
                                                        <td>{{ $alert->id }}</td>
                                                        <td>{{ $alert->title }}</td>
                                                        <td class="text-nowrap">{{ $alert->date }}</td>
                                                        <td class="text-center text-nowrap">{{ $alert->repeats ? 'Yes':'No'}}{{ $alert->repeats ? ' ('.$alert->repeat_day.')':'' }}</td>
                                                        <td class="text-center text-nowrap">
                                                            <a rel="tooltip" href="{{ route('alerts@edit', ['id' => $alert->id, 'task_id' => $data->id]) }}" class="btn btn-white btn-link btn-sm" data-original-title="Edit Alert">
                                                                <i class="material-icons">edit</i>
                                                            </a>
                                                            <button type="button" rel="tooltip" title="" class="btn btn-white btn-link btn-sm action-remove" data-original-title="Remove Alert">
                                                                <i class="material-icons">close</i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        No Records
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        @include('includes/footer')
    </div>
</div>
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="">
            <div class="modal-content">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete <span></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
@include('includes/js')
<script>
  $(document).on('click', '.action-remove', function(){
    let container = $(this).parent().parent();
    let name = container.attr('data-name');
    let action = container.attr('data-action');
    let type = container.attr('data-type');

    let msg = '';
    if(type == 'Entry'){
      let value = container.attr('data-value');
      msg = '<p>Are your sure that you want to remove the Entry: <br><strong class="inner-body">ID: ' + name + '<br>Value: ' + value +'</strong></p>';
    }else{
      msg = '<p>Are your sure that you want to remove <strong class="inner-body">' + name +'</strong></p>';
    }

    $('#delete-modal').find('.modal-title span').html(type);
    $('#delete-modal').find('.modal-body').html(msg);
    $('#delete-modal').find('form').attr('action', action);

    $('#delete-modal').modal('show');
  });
</script>
</body>
</html>