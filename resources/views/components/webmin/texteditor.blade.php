<div class="form-group" id="group{{ $name }}">
    <label for="{{ $name }}">{{ isset($label) && $label !== "" ? $label : __('form.'.$name) }} {{ (isset($required) && $required=="required")?"*":"" }} :</label>
    <textarea
        class="texteditor"
        id="{{ $name }}"
        name="{{ $name }}"
    >{{ $value }}</textarea>
</div>