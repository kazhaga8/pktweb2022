@extends('webmin.layouts.datatables')

@push('datatbInit')
<script>
    const dataTbInit = new dataTbConfig({
        column: [
            {
                data: 'lang',
                name: 'lang',
                title: 'Lang',
                search: { value: 'en', regex: true },
            },
            {
                data: 'menu',
                name: 'menu',
                title: 'Menu',
                orderable: false
            },
            {
                data: 'title',
                name: 'title',
                title: 'Page'
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
