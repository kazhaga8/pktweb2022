<div class="form-group" id="group{{ $name ?? 'name' }}">
    <label for="{{ $name ?? 'name' }}">@lang('form.'.$name) {{ (isset($required))?"*":"" }} :</label>
    <textarea id="{{ $name ?? 'name' }}" class="form-control" name="{{ $name ?? 'name' }}"></textarea>
</div>