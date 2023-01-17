@extends('webmin.layouts.base')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="table-detail mail-right">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
<link href="{{ url('public') }}/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('js')
<script src="{{ url('public') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ url('public') }}/plugins/datatables/dataTables.bootstrap.js"></script>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {

        var listdatatb = $('#listdatatb').DataTable({
            processing: true,
            serverSide: true,
            dom: "<'row col-md-12' <'col-sm-2 col-md-6'l> <'col-sm-2 col-md-6'f> >" +
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
            ajax: '{{ $page['page'] }}/json',
            columns: [{
                    data: 'id',
                    name: 'id',
                    title: 'No'
                },
                {
                    data: 'name',
                    name: 'name',
                    title: 'Name'
                },
                {
                    data: 'username',
                    name: 'username',
                    title: 'Username'
                },
                {
                    data: 'email',
                    name: 'email',
                    title: 'Email'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    title: 'Created At'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                    title: 'Updated At'
                },
                {
                    data: 'id',
                    name: 'id',
                    title: 'Action'
                }
            ],
            order: [],
            fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {},
            columnDefs: [{
                     orderable: false,
                    searchable: false,
                    className: 'select-checkbox',
                    targets: 0,
                    // render: function(cellvalue, data, rowdata) {
                    //     var checkbox = '<div class="checkbox checkbox-primary m-r-15 m-l-5">' +
                    //         '<input id="checkbox' + cellvalue + '" type="checkbox" >' +
                    //         '<label for="checkbox' + cellvalue + '"></label>' +
                    //         '</div>';
                    //     return checkbox;
                    // }
                },
                {
                    orderable: false,
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
                            '<li><a href="{{ route($page['page'].'.index') }}/' + cellvalue + '/edit" class="table-action-btn"><i class="fa fa-pencil"></i> Edit</a></li>' +
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
                }
            ],
            initComplete: function(settings, json) {
                
            },
            drawCallback: function(setting) {
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
            }
        });
        $('.refresh-btn').click(function(e) {
            listdatatb.ajax.reload();
        });
        $('.add-btn').click(function() {
            window.location.href = $(this).attr('href');
        });
    });
</script>
@endsection