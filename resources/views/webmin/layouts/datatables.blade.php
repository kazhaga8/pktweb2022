@extends('webmin.layouts.base')

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="card-box table-responsive">
      <div class="table-detail mail-right">
        <div class="row">
          <div class="col-lg-12">
            <div class="btn-toolbar">
              <button type="button" class="btn btn-rounded btn-icons waves-effect waves-inverse refresh-btn"><i class="fa fa-refresh"></i></button>
              @can($page['can'].'-create')
              <button type="button" href="{{ $page['page'] }}/create" class="btn btn-rounded btn-icons waves-effect waves-inverse add-btn"><i class="fa fa-plus"></i></button>
              @endcan
            </div>
          </div>
        </div>
        <table id="listdatatb" class="table table-striped "></table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('css')
<!-- DataTables -->
<link href="{{ url('public') }}/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{{ url('public') }}/plugins/datatables/rowReorder.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{{ url('public') }}/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('js')
<script src="{{ url('public') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ url('public') }}/plugins/datatables/dataTables.rowReorder.min.js"></script>
<script src="{{ url('public') }}/plugins/datatables/dataTables.bootstrap.js"></script>
@endsection


@section('javascript')

<script>
  class dataTbConfig {
    constructor({
      column = [],
      columnDefs = [],
      reorder = false
    }) {
      this.column = column;
      this.columnDefs = columnDefs;
      this.reorder = reorder;
    }
  }
</script>
@stack('datatbInit')
<script>
  const columnId = [{
    data: 'id',
    name: 'id',
    title: 'No'
  }];
  const columnAction = [{
    data: 'id',
    name: 'id',
    title: ''
  }];
  const columnAll = columnId.concat(dataTbInit.column, columnAction)

  const columnDefsId = [{
    orderable: false,
    searchable: false,
    className: 'select-checkbox' + (dataTbInit.reorder && ' select-reorder'),
    targets: 0,
    render: function(cellvalue, data, rowdata) {
      return '<span data-rowid="'+rowdata.id+'">' + rowdata.DT_RowIndex + '</span>';
    }
  }];
  const columnDefsAction = [{
      orderable: false,
      @can($page['can'].'-edit',$page['can'].'-delete')
      visible: true,
      @endcan
      targets: -1,
      render: function(cellvalue, data, rowdata) {
          var btn = '';
          @canany([$page['can'].'-edit',$page['can'].'-delete'])
          btn = '<div class="btn-group option-listdatatb pull-right">' +
              '<button type="button" class="btn btn-rounded btn-icons dropdown-toggle waves-effect waves-inverse" data-toggle="dropdown" aria-expanded="false">' +
              '<i class="fa fa-ellipsis-v"></i>' +
              '</button>' +
              '<ul class="dropdown-menu  dropdown-menu-right">' +
              @can($page['can'].'-edit')
              '<li><a href="{{ route($page['page'].'.index') }}/' + cellvalue + '" class="table-action-btn"><i class="fa fa-pencil"></i> Edit</a></li>' +
              @endcan
              @can($page['can'].'-delete')
              '<li><a class="table-action-btn action-delete"><i class="fa fa-trash-o"></i> Delete</a>' +
              '<form action="{{ route($page['page'].'.index') }}/' + cellvalue + '" method="POST">@method('DELETE') @csrf </form>' +
              '</li>' +
              @endcan
              '</ul>' +
              '</div>';
          @endcan
          return btn;
      }
    }];
  const columnDefsAll = columnDefsId.concat(dataTbInit.columnDefs, columnDefsAction)

  $(document).ready(function() {
    var listdatatb = $('#listdatatb').DataTable({
      processing: true,
      serverSide: true,
      rowReorder: dataTbInit.reorder && {
        update: false,
      },
      stateSave: true,
    dom: "<'row col-md-12' <'col-sm-2 col-md-6'l> <'col-sm-2 col-md-6 flex-justify-end' <'filter dataTables_filter'>f> >" +
        "<'row' <'col-sm-12 col-md-12' <'nav-table'> > >" +
        "<'row'" +
        "<'col-sm-12'tr>" +
        ">" +
        "<'row'" +
        "<'col-sm-12 col-md-5'i>" +
        "<'col-sm-12 col-md-7'p>" +
        ">",
      select: {
        style: 'multi',
        selector: 'td:first-child'
      },
      ajax: "{{ $page['page'] }}/json",
      columns: columnAll,
      order: [],
      fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {},
      columnDefs: columnDefsAll,
      initComplete: function(settings, json) {
      },
      drawCallback: function(setting) {
        $('.select-reorder').css({'cursor': 'move'});
        $('.action-delete').click(function(e) {
          swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this data!",
              icon: "error",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $(this).siblings('form').trigger('submit');
              }
            });
        });
        $('.option-listdatatb').hover(function() {
          $(this).addClass("open");
        }, function() {
          $(this).removeClass("open");
        });

        const useLangFilter = columnAll.findIndex(x => x.data === 'lang');
        if (useLangFilter) {
            $('.filter').html(
                '<label>Lang: ' +
                '<select id="filter_lang" class="form-control input-sm">' +
                '<option value="">All</option>' +
                '<option value="en">EN</option>' +
                '<option value="id">ID</option>' +
                '</select>' +
                '</label>'
            );
            $('#filter_lang').on('change',function () {
                listdatatb.columns(useLangFilter).search($(this).val()).draw();
            });
            $('#filter_lang').val(listdatatb.columns(useLangFilter).search()[0]);
        }
      }
    });
    $('.refresh-btn').click(function(e) {
      listdatatb.ajax.reload();
    });
    $('.add-btn').click(function() {
      window.location.href = $(this).attr('href');
    });

    listdatatb.on('row-reorder', function ( e, diff, edit ) {
        var ids = new Array();
        for (var i = 1; i < e.target.rows.length; i++) {
            var b =e.target.rows[i].cells[0].innerHTML.split('data-rowid="');
            var b2 = b[1].split('">')
            ids.push(b2[0]);
        }

        listdatatb.ajax.url("{{ $page['page'] }}/json?reorder="+ encodeURIComponent(ids)).load();
    });
  });
</script>
@endsection
