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
                data: 'year',
                name: 'year',
                title: 'Year'
            },
            {
                data: 'category',
                name: 'category',
                title: 'Category'
            },
            {
                data: 'title',
                name: 'title',
                title: 'Title'
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
                return cellvalue ? cellvalue.replace(/\b[a-z]/g, (x) => x.toUpperCase()) : "";
            }
        }],
    });
</script>
@endpush
