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
                data: 'title',
                name: 'title',
                title: 'Title'
            },
            {
                data: 'media',
                name: 'media',
                title: 'Media'
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
            targets: 4,
            render: function(cellvalue, data, rowdata) {
                if (rowdata.type === "image") {
                    const public = "{{ url('public') }}";
                    const image = '<div class="form-group">' +
                        '<img class="img-thumbnail" src="' + public + '/' + cellvalue.replace('../../', '') + '" />' +
                        '</div>';
                    return image;
                } else if (rowdata.type === "video") {
                    const image = '<div class="form-group">' +
                        '<a href="https://youtu.be/' + cellvalue + '" target="_blank">Video</a>' +
                        '</div>';
                    return image;
                } else {
                    return '';
                }
            }
        }],
    });
</script>
@endpush