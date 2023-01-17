<div class="form-group" id="group{{ $name ?? 'name' }}">
    <label for="{{ $name ?? 'name' }}">@lang('form.'.$name) {{ (isset($required) && $required==true)?"*":"" }} :</label>
    <textarea class="texteditor" id="{{ $name ?? 'name' }}" name="{{ $name ?? 'name' }}"  {{ (isset($required) && $required==true)?"required":"" }}>{{ (isset($value) && $value==true)?$value:"" }}</textarea>
</div>