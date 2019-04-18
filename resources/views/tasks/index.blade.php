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
                        <a href="{{ route('tasks@create') }}" class="btn btn-success">New Task</a>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Tasks</h4>
                            </div>
                            <div class="card-body">
                                @if($list->isEmpty())
                                    No record
                                @else
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Title</th>
                                                    <th>Contact</th>
                                                    <th>Type</th>
                                                    <th>Value</th>
                                                    <th class="text-center text-nowrap">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list as $item)
                                                <tr data-title="{{ $item->title }}" data-id="{{ $item->id }}" data-action="{{ route('tasks@destroy', ['id' => $item->id]) }}">
                                                    <td>
                                                        {{ $item->id }}
                                                    </td>
                                                    <td>
                                                        {{ $item->title }}
                                                    </td>
                                                    <td>
                                                        @if($item->contact)
                                                        {{ $item->contact->name }}
                                                        @else
                                                        -
                                                        @endif
                                                    </td>
                                                    <td class="{{ task_color($item) }}">
                                                        {{ ucfirst($item->type) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($item->value, 2, ',', '.') }} / {{ number_format($item->remaining(), 2, ',', '.') }}
                                                    </td>
                                                    <td class="text-center text-nowrap td-actions">
                                                        <a rel="tooltip" href="{{ route('tasks@show', ['id' => $item->id])  }}" class="btn btn-white btn-link btn-sm" data-original-title="View Task">
                                                            <i class="material-icons">visibility</i>
                                                        </a>
                                                        <a rel="tooltip" href="{{ route('tasks@edit', ['id' => $item->id])  }}" class="btn btn-white btn-link btn-sm" data-original-title="Edit Task">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                        <button type="button" rel="tooltip" title="" class="btn btn-white btn-link btn-sm action-remove" data-original-title="Remove Task">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
                    <h5 class="modal-title">Delete Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are your sure that you want to remove <strong class="inner-body"></strong>?</p>
                </div>
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
    let name = container.attr('data-title');
    let action = container.attr('data-action');

    $('#delete-modal').find('.inner-body').html(name)
    $('#delete-modal').find('form').attr('action', action);

    $('#delete-modal').modal('show');
  });
</script>
</body>
</html>