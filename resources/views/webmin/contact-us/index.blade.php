@extends('webmin.layouts.datatables')

@push('datatbInit')
<script>
    const dataTbInit = new dataTbConfig({
        column: [
            {
                data: 'subject',
                name: 'subject',
                title: 'Subject'
            },
            {
                data: 'name',
                name: 'name',
                title: 'Name'
            },
            {
                data: 'email',
                name: 'email',
                title: 'Email'
            },
            {
                data: 'message',
                name: 'message',
                title: 'Message'
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
        reorder: true
    });
</script>
@endpush
