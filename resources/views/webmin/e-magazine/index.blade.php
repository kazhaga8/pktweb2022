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
                title: 'Edition'
            },
            {
                data: 'image',
                name: 'image',
                title: 'Image'
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
            orderable: false,
            targets: 3,
            render: function(cellvalue, data, rowdata) {
                const public = "{{ url('public') }}";
                const image = '<div class="form-group">' +
                    '<img class="img-thumbnail" src="' + public + '/' + cellvalue.replace('../../', '') + '" />' +
                    '</div>';
                return image;
            }
        }],
        reorder: true
    });
</script>
@endpush
