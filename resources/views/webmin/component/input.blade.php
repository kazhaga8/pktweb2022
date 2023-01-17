<div class="form-group" id="group{{ $name ?? 'name' }}">
    <label for="{{ $name ?? 'name' }}">@lang('form.'.$name) {{ (isset($imagesize) && $imagesize != "")?"(".$imagesize.")":"" }} {{ (isset($required) && $required == true)?"*":"" }} :</label>
    <input type="{{ $type ?? 'text' }}" class="form-control @error($name) parsley-error @enderror" name="{{ $name ?? 'name' }}" id="{{ $name ?? 'name' }}" value="{{ $value }}" {{ (isset($required) && $required == true)?"required":"" }} {{ (isset($disabled) && $disabled == true)?"disabled":"" }}>
    @error($name)
        <ul class="parsley-errors-list filled">
            <li class="parsley-required">{{ $message }}</li>
        </ul>
    @enderror
</div>