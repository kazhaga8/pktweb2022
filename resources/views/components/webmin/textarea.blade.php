<div class="form-group" id="group{{ $name ?? 'name' }}">
    <label for="{{ $name ?? 'name' }}">@lang('form.'.$name) {{ $required?"*":"" }} :</label>
    <textarea
        class="form-control"
        id="{{ $name ?? 'name' }}"
        name="{{ $name ?? 'name' }}"
        {{ $required?"required":"" }} 
        {{ $disabled?"disabled":"" }}
    >{!! $value ? $value : '' !!}</textarea>
    @error($name)
      <ul class="parsley-errors-list filled">
          <li class="parsley-required">{{ $message }}</li>
      </ul>
    @enderror
</div>