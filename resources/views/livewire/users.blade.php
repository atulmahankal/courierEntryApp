{{-- https://www.youtube.com/watch?v=HtoUB1rNV6w&t=298s --}}

{{-- @extends('layouts.app') --}}
@section('title', 'Users')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="#">Home</a></li>
	<li class="breadcrumb-item active">Users</li>
@endsection

@section('style')
<style>
.form-inline .custom-file-label {
	display: unset;
}
</style>
@endsection

@section('script')
{{-- <script src="{{ asset('vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script> --}}
<script>
$(document).ready(function() {
	$('.custom-file-input').on('change',function(){
		files = $(this)[0].files;
		name = '';
		for(var i = 0; i < files.length; i++){
			name += '\"' + files[i].name + '\"' + (i != files.length-1 ? ", " : "");
		}
		$(".custom-file-label").html(name);
	});

	window.addEventListener('toast', event => {
		$(document).Toasts('create', {
			title: event.detail.title,
			body: event.detail.message,
			class: 'bg-info',
			autohide: true,
			delay: 5000,
		})
	});
});

window.addEventListener('close-model', event => {
	$('.modal').modal('hide');
});
window.addEventListener('open-model', event => {
	{{-- $('#Modal').modal('show'); --}}
});
</script>
@endsection

@section('sticky-top')
@endsection

<div>
	@if(session()->has('message'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
		<p class="mb-0">{{ session('message') }}</p>
	</div>
	@endif
	<div class="card">
		<div class="card-header clearfix bg-gradient-light mt-3">
			<div class="row justify-content-between">
				<div class="col">
					<form id="importUsers" action="/import-users" method="post" enctype="multipart/form-data">
						@csrf
						<div class="input-group input-group-sm" style="width:300px;">
							<div class="custom-file">
								<label class="custom-file-label" for="import">Choose file</label>
								<input type="file" class="custom-file-input" name="import_file" required>
							</div>
							<div class="input-group-append">
								<button type="submit" class="input-group-text">Import</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-auto form-inline">
					@if ($checked)
					<div class="dropdown input-group-btn px-1">
						<button class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">with checked ({{ count($checked) }})</button>
						<div class="dropdown-menu">
							<a href="javascript:" class="dropdown-item" type="button" onclick="confirm('Are you sure want to Delete these Records?') || event.stopImmediatePropagation()" wire:click="deleteChecked()">
								Delete
							</a>
							<a href="javascript:" class="dropdown-item" type="button" onclick="confirm('Are you sure want to Export these Records?') || event.stopImmediatePropagation()" wire:click="exportChecked()">
								Export
							</a>
						</div>
					</div>
					@endif
					<button type="button" class="btn btn-primary btn-sm px-1" data-toggle="modal" data-target="#formModal">
						<i class="fas fa-plus"></i> Add
					</button>
				</div>
				@if($selectPage)
				<div class="col-12 mt-3 text-right">
						@if(count($checked) == $records->total())
						<small>You have selected All <u>{{ count($checked) }}</u> items.
						@else
						<small>You have selected only <u>{{ count($checked) }}</u> items, Do you want to Select All <u>{{ $records->total() }}</u>?
						<a href="javascript:" class="ml-2" wire:click="selectAll">Select All</a>
						@endif
					</small>
				</div>
				@endif
			</div>
		</div>
		<div class="card-body">
			<div class="row justify-content-between">
				<div class="col-auto form-inline">
					Show <select wire:model="pagination" class="form-control form-control-sm mx-1">
						<option>15</option>
						<option>50</option>
						<option>100</option>
					</select> records.
				</div>
				<div class="col text-center">
					@php
					$startFrom = ($records->currentpage()-1) * $records->perpage();
					$upTo = $startFrom + $records->perpage();
					@endphp
					Showing {{ $startFrom + 1 }} to {{ ($upTo > $records->total()) ? $records->total() : $upTo }} of {{ $records->total() }} records
					@if($records->total() < $total)
					(filtered from {{ $total }} total entries)
					@endif
				</div>
				<div class="col-auto">
				<input type="search" class="form-control form-control-sm float-left mx-2" style="width: 300px;" wire:model.debounce.1000ms="search" placeholder="Search by Name, Email ..." />
			</div>

			<div class="table-responsive">
				<table class="mt-3 table table-sm table-bordered table-striped table-hover">
					<thead>
						<tr class="bg-gradient-dark text-center">
							<th><input type="checkbox" wire:model="selectPage" /></th>
							<th>#</th>
							<th class="text-truncate" role="button" wire:click="sort('name')">Name
								<span class=" float-right">
								@if($sortColumn != 'name')
									<i class="fas fa-sort"></i></i>
								@elseif($sortOrder == 'asc')
									<i class="fas fa-sort-up"></i></th>
								@elseif($sortOrder == 'desc')
									<i class="fas fa-sort-down"></i></th>
								@endif
								</span>
							</th>
							<th class="text-truncate" role="button" wire:click="sort('email')">E-mail
								<span class=" float-right">
								@if($sortColumn != 'email')
									<i class="fas fa-sort"></i></i>
								@elseif($sortOrder == 'asc')
									<i class="fas fa-sort-up"></i></th>
								@elseif($sortOrder == 'desc')
									<i class="fas fa-sort-down"></i></th>
								@endif
								</span>
							</th>
							<th>Action</th>
						</tr>
						<tr class="bg-gradient-light text-center">
							<th></th>
							<th></th>
							<th><input type="search" class="form-control form-control-sm" wire:model.debounce.1000ms="filterName" placeholder="Search..." /></th>
							<th><input type="search" class="form-control form-control-sm" wire:model.debounce.1000ms="filterEmail" placeholder="Search..." /></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@forelse ($records as $record)
							<tr class="@if ($this->isChecked($record->id)) table-primary @endif">
								<td class="px-3" style="width:1px; white-space:nowrap;"><input type="checkbox" value="{{ $record->id }}" wire:model="checked" 
								></td>
								<td class="text-right" style="width:1px; white-space:nowrap;">{{ ($records->currentpage()-1) * $records->perpage() + $loop->index + 1 }}</td>
								<td>{{ $record->name }}</td>
								<td>{{ $record->email }}</td>
								<td class="px-3 justify-content-center" style="width:1px; white-space:nowrap;">
									<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#formModal" 
										wire:click.prevent="showModal({{ $record }},'update')" @if(auth()->user()->id == $record->id) disabled @endif>
										<i class="fas fa-edit"></i> Edit
									</button>
									<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" 
										wire:click.prevent="showModal({{ $record }},'delete')" @if(auth()->user()->id == $record->id) disabled @endif>
										<i class="fas fa-trash"></i> Delete
									</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="4">
									No record found.
								</td>
							</tr>
						@endforelse
					</tbody>
					{{-- <tfoot>
						<tr>
							<th class="text-truncate"><input type="search" class="form-control" /></th>
							<th class="text-truncate"><input type="search" class="form-control" /></th>
							<th class="text-truncate"><select class="form-control"><option></option></select></th>
							<th></th>
						</tr>
					</tfoot> --}}
				</table>
			</div>
		</div>
		<div class="card-footer justify-content-center">
			{{ $records->links() }}
			</div>
		</div>
	</div>

	<!-- formModal -->
	<div wire:ignore.self class="modal fade" id="formModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
			<form class="modal-content" wire:submit.prevent="submit">
				<div class="modal-header">
					<h5 class="modal-title" id="formModalLabel">@if($action == 'update') Update @else Add @endif User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label for="name" class="col-sm-2 col-form-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control @error('item.name') is-invalid @enderror" id="name" wire:model.lazy="item.name">
							@error('item.name') <span class="text-danger">{{ $message }}</span> @enderror
						</div>
					</div>
					<div class="form-group row">
						<label for="email" class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-10">
							<input type="email" class="form-control @error('item.email') is-invalid @enderror" id="email" wire:model.lazy="item.email">
							@error('item.email') <span class="text-danger">{{ $message }}</span> @enderror
						</div>
					</div>
					@if($action == 'add')
					<div class="form-group row">
						<label for="password" class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
							<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" wire:model.lazy="password" autocomplete="new password">
							@error('password') <span class="text-danger">{{ $message }}</span> @enderror
						</div>
					</div>
					@endif
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close" wire:click="closeModal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
	
	<!-- deleteModal -->
	<div wire:ignore.self class="modal fade" id="deleteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
			<form class="modal-content" wire:submit.prevent="deleteModal({{ $item }})">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h6>Do you realy want to delete record for <u>{{ $item->name ?? '' }}</u>?</h6>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close" wire:click="closeModal">Close</button>
					<button type="submit" class="btn btn-danger">Yes! Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>