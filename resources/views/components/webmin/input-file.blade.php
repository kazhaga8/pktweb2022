<div class="row" id="group{{ $name }}">
    <div class="col-xs-12 col-sm-6">
        <label for="{{ $name ?? 'name' }}">@lang('form.'.$name) {{ $required == "required"?"*":"" }} :</label>
        <div class="form-group clearfix">
            <a href="{{ url('public') }}/plugins/responsivefilemanager/filemanager/dialog.php?type=0&field_id={{ $name }}" class="btn btn-primary iframe-btn m-b-10" type="button">Open Filemanager</a>
            <div id="display-{{ $name }}"></div>
            <input
                type="hidden"
                name="{{ (isset($name))?$name:'' }}{{ ($multiple == true)?[]:'' }}"
                id="{{ (isset($name))?$name:''}}"
                value="{{ $value?url('public').$value:''}}"
                {{ ($multiple == "true")?'multiple="true"':'' }}
                extensions="{{implode('|',$allowext)}}"
            >
        </div>
    </div>
</div>
@push('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        responsive_filemanager_callback('{{ $name }}')
    });
</script>
@endpush