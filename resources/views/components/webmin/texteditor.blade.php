<div class="form-group" id="group{{ $name }}">
    <label for="{{ $name }}">@lang('form.'.$name) {{ (isset($required) && $required=="required")?"*":"" }} :</label>
    <textarea
        class="texteditor"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required=="required"?"required":"" }}
    >{{ $value }}</textarea>
</div>