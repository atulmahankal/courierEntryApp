@extends('layouts.app')

@section('title', 'Users')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Users</li>
@endsection

@section('plugins-style')
<link rel="stylesheet" href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
@endsection

@section('plugins-script')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('vendor/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('vendor/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('vendor/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('vendor/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
@endsection

@section('script')
<script>
  $("#datatable")
    .DataTable({
      paging: true
      , lengthChange: true
      , searching: true
      , ordering: true
      , info: true
      , autoWidth: true
      , responsive: true
      , columnDefs: [
        { orderable: false, targets: [0] }
      ]
      , order: [[1, 'asc']]
      , buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
    , })
    .buttons()
    .container()
    .appendTo("#datatable_wrapper .col-md-6:eq(0)");

</script>
@endsection

@section('control-sidebar')
<aside class="control-sidebar control-sidebar-dark">
</aside>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="card">
          <form class="m-2" method="POST" action="{{ $record->id ? url('users/'.$record->id) : url('users') }}">
            {!! csrf_field() !!}

            <div class="row">
              <div class="form-group col-md-4{{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="control-label" for="name">Name</label>
                <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name', $record->name) }}" required>

                @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group col-md-4{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="control-label" for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email', $record->email) }}" required>

                @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group col-md-2{{ $errors->has('role') ? ' has-error' : '' }}">
                <label class="control-label" for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                  <option value="0" {{ old('role', $record->isAdmin) == '0' ? 'selected' : '' }}>User</option>
                  <option value="1" {{ old('role', $record->isAdmin) == '1' ? 'selected' : '' }}>Administrator</option>
                </select>

                @if ($errors->has('role'))
                <span class="help-block">
                  <strong>{{ $errors->first('role') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group col-md-2 row">
                <button type="submit" name="submit" value="1" class="form-control btn btn-primary">{{ $record->id ? 'Update' : 'Add' }}</button>
                @if ($record->id)
                <br><br>
                <button type="button" onclick="document.location='{{ url('users') }}'" class="form-control btn btn-default">Cancel</button>
                @endif
              </div>
            </div>

          </form>
        </div>
        <div class="card p-2">
          <table id="datatable" class="table table-bordered table-hover" style="width:100%;">
            <thead>
              <tr class="text-center">
                <th class="no-sort" style="width:125px; min-width: 125px;">Action</th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
                <th>Updated</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($records as $row)
              <tr>
                <td class="text-center">
                  <a class="btn btn-sm btn-primary" href="{{ url('users/'.$row->id) }}">Edit</a>
                  <a class="btn btn-sm btn-danger" href="{{ url('users/'.$row->id.'/delete') }}" onclick="return confirm('Are you sure you wish to delete this record?');">Delete</a>
                </td>
                <td class="text-center">{{ $row->id }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->isAdmin ? 'Admin' : 'User' }}</td>
                <td>{{ $row->created_at->format('Y-m-d') }}</td>
                <td>{{ $row->updated_at->format('Y-m-d') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
