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
                data: 'parent_menu',
                name: 'parent_menu',
                title: 'Parent Menu'
            },
            {
                data: 'title',
                name: 'title',
                title: 'Menu'
            },
            {
                data: 'menu_type',
                name: 'menu_type',
                title: 'Menu Type'
            },
            {
                data: 'menu_position',
                name: 'menu_position',
                title: 'Menu Position'
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