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
                        <a href="{{ route('alerts@create') }}" class="btn btn-success">New Alert</a>
                        <button data-action="{{ route('alerts@storeSubscription') }}" class="btn btn-success ml-2 push-button"><i class="material-icons">notifications</i> Enable Notifications</button>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-warning">
                                <h4 class="card-title">Alerts</h4>
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
                                                <th class="text-center text-nowrap">Status</th>
                                                <th>Title</th>
                                                <th>Task</th>
                                                <th class="text-center text-nowrap">Repeat</th>
                                                <th class="text-center text-nowrap">Date</th>
                                                <th class="text-center text-nowrap">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($list as $item)
                                                <tr data-title="{{ $item->title }}" data-id="{{ $item->id }}" data-action="{{ route('alerts@destroy', ['id' => $item->id]) }}" data-token="{{ csrf_token() }}">
                                                    <td>
                                                        {{ $item->id }}
                                                    </td>
                                                    <td class="text-center" data-action="/alerts/{{ $item->id }}/editStatus">
                                                        @if($item->status)
                                                            <i class="material-icons status-change pointer text-success" data-value="0" title="Click to inactivate">check</i>
                                                        @else
                                                            <i class="material-icons status-change pointer text-danger" data-value="1" title="Click to activate">not_interested</i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $item->title }}
                                                    </td>
                                                    <td>
                                                        @if($item->task)
                                                            <a href="{{ route('tasks@show', ['id' => $item->task->id]) }}">{{ $item->task->title }}</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-center text-nowrap">
                                                        {{ $item->repeats ? 'Yes':'No'}}{{ $item->repeats ? ' ('.$item->repeat_day.')':'' }}
                                                    </td>
                                                    <td class="text-center text-nowrap">
                                                        {{ $item->date }}
                                                    </td>
                                                    <td class="text-center text-nowrap td-actions">
                                                        <a rel="tooltip" href="{{ route('alerts@edit', ['id' => $item->id])  }}" class="btn btn-white btn-link btn-sm" data-original-title="Edit Alert">
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
                    <h5 class="modal-title">Delete Alert</h5>
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

  $(document).on('click', '.status-change', function(){
    let value = $(this).attr('data-value');
    let action = $(this).parent().attr('data-action');
    let token = $(this).parent().parent().attr('data-token');

    $.ajax({
      url: action,
      type: 'post',
      data: {status: value, _token: token}
    }).done(function(){
      window.location.reload();
    }).fail(function(){
      alert("Error on status update.");
    });
  });

  const pushButton = document.querySelector('.push-button');

  let isSubscribed = false;
  let swRegistration = null;

  function initialiseUI() {
    pushButton.addEventListener('click', function() {
      pushButton.disabled = true;
      if (isSubscribed) {
        unsubscribeUser();
      } else {
        subscribeUser();
      }
    });

    // Set the initial subscription value
    swRegistration.pushManager.getSubscription()
      .then(function(subscription) {
        isSubscribed = !(subscription === null);

        //updateSubscriptionOnServer(subscription);

        if (isSubscribed) {
          console.log('User IS subscribed.');
        } else {
          console.log('User is NOT subscribed.');
        }

        updateBtn();
      });
  }

  function updateBtn() {
    if (Notification.permission === 'denied') {
      $(pushButton).html('<i class="material-icons">notifications</i> Notifications Blocked.');
      pushButton.disabled = true;
      updateSubscriptionOnServer(null);
      return;
    }

    if (isSubscribed) {
      $(pushButton).html('<i class="material-icons">notifications</i> Disable Notifications');
    } else {
      $(pushButton).html('<i class="material-icons">notifications</i> Enable Notifications');
    }

    pushButton.disabled = false;
  }

  navigator.serviceWorker.register('{{ asset("js/serviceWorker.js") }}')
    .then(function(swReg) {
      console.log('Service Worker is registered', swReg);

      swRegistration = swReg;
      initialiseUI();
    });

  function subscribeUser() {
    const applicationServerKey = urlB64ToUint8Array(PUSH_PUBLIC_KEY);
    swRegistration.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: applicationServerKey
    })
      .then(function(subscription) {
        console.log('User is subscribed:', subscription);

        updateSubscriptionOnServer(subscription);

        isSubscribed = true;

        updateBtn();
      })
      .catch(function(err) {
        console.log('Failed to subscribe the user: ', err);
        updateBtn();
      });
  }

  function unsubscribeUser() {
    swRegistration.pushManager.getSubscription()
      .then(function(subscription) {
        if (subscription) {
          return subscription.unsubscribe();
        }
      })
      .catch(function(error) {
        console.log('Error unsubscribing', error);
      })
      .then(function() {
        updateSubscriptionOnServer(null);

        console.log('User is unsubscribed.');
        isSubscribed = false;

        updateBtn();
      });
  }

  function updateSubscriptionOnServer(subscription) {
    let action = $(pushButton).attr('data-action');

    if (subscription) { // Add or update subscription
        let data = JSON.stringify(subscription);
        $.ajax({
            url: action,
            type: 'post',
            data: {data: data, fingerprint: localStorage.getItem('fingerprint')}
        }).done(function(data){
            console.log(data);
        }).fail(function(){
            alert("Error on subscribe.");
        });
    } else {
      // Remove subscription
      $.ajax({
        url: action,
        type: 'delete',
        data: {fingerprint: localStorage.getItem('fingerprint')}
      }).done(function(data){
        console.log(data);
      }).fail(function(response){
        let status = response.status;
        if(status == 500){
          alert("Error on unsubscribe.");
        }
      });
    }
  }
</script>
</body>
</html>