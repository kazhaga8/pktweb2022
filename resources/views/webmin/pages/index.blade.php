@extends('webmin.layouts.datatables')

@push('datatbInit')
<script>
    const dataTbInit = new dataTbConfig({
        column: [{
                data: 'title',
                name: 'title',
                title: 'Page'
            },
            {
                data: 'lang',
                name: 'lang',
                title: 'Lang'
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
        ]
    });
</script>
@endpush