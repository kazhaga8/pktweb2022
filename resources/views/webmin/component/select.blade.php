<div class="form-group" id="group{{ $name ?? 'name' }}" >
    <label for="{{ $name ?? 'name' }}">@lang('form.'.$name) {{ (isset($required))?"*":"" }} :</label>
    <select id="{{ $name ?? 'name' }}" class="form-control" {{ (isset($required))?"required":"" }}>
        <option value="">Choose..</option>
        @foreach ($items as $item)
        <option value="{{$item}}">@lang('form.'.$item)</option>
        @endforeach
    </select>
</div>