<div class="form-group" id="group{{ $name }}">
    <label for="group{{ $name }}">@lang('form.'.$name) {{ (isset($required) && $required == "required")?"*":"" }} :</label>
    @foreach ($items as $item)
    <div class="radio radio-primary">
        <input
            type="radio"
            name="{{ $name }}"
            id="{{ $name }}{{ $item }}"
            value="{{ $item }}"
            {{ (isset($required) && $required == "true")?"required":"" }}
            {{ ($value == $item)?'checked':'' }}
        >
        <label for="{{$name}}{{$item}}">
            @lang('form.'.$item)
        </label>
    </div>
    @endforeach
</div>
