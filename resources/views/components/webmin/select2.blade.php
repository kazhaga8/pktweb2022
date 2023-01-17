<div class="form-group" id="group{{ $name }}" >
    <label for="{{ $name }}">{{ $label ? $label : __('form.'.$name) }} {{ $required?"*":"" }} :</label>
    <select
        name="{{ $name }}{{ $multiple?'[]':'' }}"
        id="{{ $name }}"
        data-placeholder="{{ $placeholder }}"
        class="form-control select2"
        {{ $required?'required':'' }}
        {{ $multiple?'multiple="multiple"':'' }}
    >
        <option value="">Choose...</option>
        @foreach ($items as $key => $val)
            <option
                value="{{(isset($val->id)?$val->id:'')}}"
                {{ (isset($value) && !empty($value) && preg_match('/'.$val->id.'/i',$value)?'selected':'') }}
            >{{(isset($val->name)?$val->name:'')}}</option>
        @endforeach
    </select>
</div>

@push('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name={{ $name }}]').val('{{ $value }}').trigger('change');
    });
</script>
@endpush