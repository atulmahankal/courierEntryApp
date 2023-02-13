@extends('layouts.app')

@section('title', 'Courier')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">courier</li>
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
  $(function() {
    $("#datatable").DataTable({
      paging: true
      , lengthChange: true
      , searching: true
      , ordering: true
      , info: true
      , autoWidth: true
      , responsive: true
      , columnDefs: [{
        orderable: false
        , targets: [0]
      }]
      , order: [
        [1, 'asc']
      ]
      , buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
    })
    .buttons()
    .container()
    .appendTo("#datatable_wrapper .col-md-6:eq(0)");
  });

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
          <form class="m-2" method="POST" action="{{ $record->id ? url('courier/'.$record->id) : url('courier') }}">
            {!! csrf_field() !!}

            <div class="row">
              <div class="form-group col-md-4{{ $errors->has('date') ? ' has-error' : '' }}">
                <label class="control-label" for="date">Date</label>
                <input type="date" class="form-control" name="date" placeholder="date" value="{{ old('date',date('Y-m-d', strtotime($record->date))) }}" required>

                @if ($errors->has('direction'))
                <span class="help-block">
                  <strong>{{ $errors->first('direction') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group col-md-4{{ $errors->has('direction') ? ' has-error' : '' }}">
                <label class="control-label" for="direction">Direction</label>
                <input type="type" class="form-control" name="direction" placeholder="direction" value="{{ old('direction', $record->direction) }}" required>

                @if ($errors->has('direction'))
                <span class="help-block">
                  <strong>{{ $errors->first('direction') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group col-md-4{{ $errors->has('type') ? ' has-error' : '' }}">
                <label class="control-label" for="type">Type</label>
                <input type="text" class="form-control" name="type" placeholder="type" value="{{ old('type', $record->type) }}" required>

                @if ($errors->has('type'))
                <span class="help-block">
                  <strong>{{ $errors->first('type') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group col-md-4{{ $errors->has('party') ? ' has-error' : '' }}">
                <label class="control-label" for="party">Party</label>
                <input type="type" class="form-control" name="party" placeholder="party" value="{{ old('party', $record->party) }}" required>

                @if ($errors->has('party'))
                <span class="help-block">
                  <strong>{{ $errors->first('party') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group col-md-4{{ $errors->has('courier_name') ? ' has-error' : '' }}">
                <label class="control-label" for="courier_name">Courier Name</label>
                <input type="type" class="form-control" name="courier_name" placeholder="Courier Name" value="{{ old('courier_name', $record->courier_name) }}" required>

                @if ($errors->has('courier_name'))
                <span class="help-block">
                  <strong>{{ $errors->first('courier_name') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group col-md-4{{ $errors->has('courier_contact') ? ' has-error' : '' }}">
                <label class="control-label" for="courier_contact">Courier Contact</label>
                <input type="type" class="form-control" name="courier_contact" placeholder="Courier Contact" value="{{ old('courier_contact', $record->courier_contact) }}" required>

                @if ($errors->has('courier_contact'))
                <span class="help-block">
                  <strong>{{ $errors->first('courier_contact') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group col-md-4{{ $errors->has('person_name') ? ' has-error' : '' }}">
                <label class="control-label" for="person_name">Person Name</label>
                <input type="type" class="form-control" name="person_name" placeholder="Person Name" value="{{ old('person_name', $record->person_name) }}" required>

                @if ($errors->has('person_name'))
                <span class="help-block">
                  <strong>{{ $errors->first('person_name') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group col-md-4{{ $errors->has('person_contact') ? ' has-error' : '' }}">
                <label class="control-label" for="person_contact">Person Contact</label>
                <input type="type" class="form-control" name="person_contact" placeholder="Person Contact" value="{{ old('person_contact', $record->person_contact) }}" required>

                @if ($errors->has('person_contact'))
                <span class="help-block">
                  <strong>{{ $errors->first('person_contact') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group col-md-2 row">
                <button type="submit" name="submit" value="1" class="form-control btn btn-primary">{{ $record->id ? 'Update' : 'Add' }}</button>
                @if ($record->id)
                <br><br>
                <button type="button" onclick="document.location='{{ url('courier') }}'" class="form-control btn btn-default">Cancel</button>
                @endif
              </div>
            </div>

          </form>
        </div>
        <div class="card p-2">
          <table id="datatable" class="table table-bordered table-hover" style="width:100%;">
            <thead>
              <tr>
                <th class="no-sort" style="width:125px; min-width: 125px;">Action</th>
                <th class="text-center">ID</th>
                <th>Date</th>
                <th>Direction</th>
                <th>Type</th>
                <th>Party</th>
                <th>Courier Name</th>
                <th>Courier Contact</th>
                <th>Person Name</th>
                <th>Person Contact</th>
              </tr>
            </thead>

            <tbody>
              @foreach ($records as $row)
              <tr>
                <td class="text-center">
                  <a class="btn btn-sm btn-primary" href="{{ url('courier/'.$row->id) }}">Edit</a>
                  <a class="btn btn-sm btn-danger" href="{{ url('courier/'.$row->id.'/delete') }}" onclick="return confirm('Are you sure you wish to delete this record?');">Delete</a>
                </td>
                <td class="text-center">{{ $row->id }}</td>
                <td>{{ date('d M Y', strtotime($row->date)) }}</td>
                <td>{{ $row->direction }}</td>
                <td>{{ $row->type }}</td>
                <td>{{ $row->party }}</td>
                <td>{{ $row->courier_name }}</td>
                <td>{{ $row->courier_contact }}</td>
                <td>{{ $row->person_name }}</td>
                <td>{{ $row->person_contact }}</td>
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
