<div class="form-group" id="group{{ $name }}">
  <label for="{{ $name }}">{{ $label ? $label : __('form.'.$name) }} {{ (isset($imagesize) && $imagesize != "")?"(".$imagesize.")":"" }} {{ (isset($required) && $required == "required")?"*":"" }} :</label>
  <input
    class="form-control @error($name) parsley-error @enderror"
    name="{{ $name }}" id="{{ $name }}"
    type="{{ $type }}" 
    value="{{ $value }}" 
    {{ (isset($required) && $required == "required")?"required":"" }} 
    {{ (isset($disabled) && $disabled == "disabled")?"disabled":"" }}
  >
    @error($name)
      <ul class="parsley-errors-list filled">
          <li class="parsley-required">{{ $message }}</li>
      </ul>
    @enderror
</div>