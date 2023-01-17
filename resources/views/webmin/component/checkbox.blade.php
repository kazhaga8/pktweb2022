<div class="form-group" id="group{{ $name ?? 'name' }}">
    <label>@lang('form.'.$name) {{ (isset($required))?"*":"" }} :</label>
    @foreach ($items as $item)
    <div class="checkbox checkbox-pink">
        <input type="checkbox" name="{{$name}}[]" id="{{$name}}{{$item}}" value="{{$item}}" {{ (isset($required))?"required":"" }}>
        <label for="{{$name}}{{$item}}"> @lang('form.'.$item) </label>
    </div>
    @endforeach
</div>