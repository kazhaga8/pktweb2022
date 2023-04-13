@extends('webmin.layouts.datatables')

@push('datatbInit')
<script>
    const dataTbInit = new dataTbConfig({
        column: [{
                data: 'lang',
                name: 'lang',
                title: 'Lang'
            },
            {
                data: 'title',
                name: 'title',
                title: 'Title'
            },
            {
                data: 'href',
                name: 'href',
                title: 'Url'
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
            }
        ],
        columnDefs: [{
            targets: 3,
            render: function(cellvalue, data, rowdata) {
                return '<div style="max-width: 500px; word-wrap: break-word;" >'+cellvalue+'</div>';
            }
        }],
        reorder: true
    });
</script>
@endpush
