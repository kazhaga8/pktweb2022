<div class="form-group" id="group{{ $name ?? 'name' }}" >
    <label for="{{ $name ?? 'name' }}">@lang('form.'.$name) {{ (isset($required))?"*":"" }} :</label>
    <select data-placeholder="{{ (isset($placeholder))?$placeholder:"" }}" id="{{ $name ?? 'name' }}" name="{{ $name ?? 'name' }}{{ (isset($multiple))?'[]"':'' }}" class="form-control select2" {{ (isset($required))?"required":"" }}  {{ (isset($multiple))?'multiple="multiple"':'' }}>
        <option value="">Choose...</option>
        @foreach ($items as $key => $val)
            <option value="{{(isset($val->id)?$val->id:'')}}" {{ (isset($value) && !empty($value) && preg_match("/".$val->id."/i",$value)?'selected':'') }}>{{(isset($val->name)?$val->name:'')}}</option>
        @endforeach
    </select>
</div>