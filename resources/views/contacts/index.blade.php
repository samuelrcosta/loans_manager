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
						<a href="{{ route('contacts@create') }}" class="btn btn-success">New Contact</a>
					</div>
					<div class="col-md-12">
						<div class="card">
							<div class="card-header card-header-primary">
								<h4 class="card-title ">Contacts</h4>
							</div>
							<div class="card-body">
								@if($list->isEmpty())
									No record
								@else
									<div class="table-responsive">
										<table class="table">
											<thead class=" text-primary">
											<tr><th>
													ID
												</th>
												<th>
													Nickname
												</th>
												<th>
													Name
												</th>
												<th>
													Phone
												</th>
												<th class="text-center">
													Actions
												</th>
											</tr></thead>
											<tbody>
											@foreach($list as $item)
												<tr data-name="{{ $item->name }}" data-id="{{ $item->id }}" data-action="{{ route('contacts@destroy', ['id' => $item->id]) }}">
													<td>
														{{ $item->id }}
													</td>
													<td>
														{{ $item->nickname }}
													</td>
													<td>
														{{ $item->name }}
													</td>
													<td>
														{{ $item->phone }} {{ !empty($item->phone_2) ? $item->phone_2:'' }}
													</td>
													<td class="text-center td-actions">
														<a rel="tooltip" href="{{ route('contacts@edit', ['id' => $item->id])  }}" class="btn btn-white btn-link btn-sm" data-original-title="Edit Contact">
															<i class="material-icons">edit</i>
														</a>
														<button type="button" rel="tooltip" title="" class="btn btn-white btn-link btn-sm action-remove" data-original-title="Remove Contact">
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
					<h5 class="modal-title">Delete Contact</h5>
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
		let name = container.attr('data-name');
		let action = container.attr('data-action');

		$('#delete-modal').find('.inner-body').html(name)
		$('#delete-modal').find('form').attr('action', action);

		$('#delete-modal').modal('show');
	});
</script>
</body>
</html>