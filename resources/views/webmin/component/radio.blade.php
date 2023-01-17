<div class="form-group" id="group{{ $name ?? 'name' }}">
    <label>@lang('form.'.$name) {{ (isset($required))?"*":"" }} :</label>
    @foreach ($items as $item)
    <div class="radio">
        <input type="radio" name="{{$name}}" id="{{$name}}{{$item}}" value="{{$item}}" {{ (isset($required))?"required":"" }} {{ ($value == $item)?'checked':'' }}>
        <label for="{{$name}}{{$item}}">
            @lang('form.'.$item)
        </label>
    </div>
    @endforeach
</div>