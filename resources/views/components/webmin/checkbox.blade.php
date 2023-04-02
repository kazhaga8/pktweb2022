<div class="form-group" id="group{{ $name ?? 'name' }}">
    <label>{{ $label ? $label : __('form.'.$name) }} {{ (isset($required))?"*":"" }} :</label>
    @foreach ($items as $item)
    <div class="checkbox checkbox-primary">
        <input
            type="checkbox"
            name="{{$name}}[]"
            id="{{$name}}{{$item}}"
            value="{{$item}}"
            {{ (isset($required) && $required == "required")?"required":"" }}
            {{ in_array($item, $value) ? "checked" : "" }}
        >
        <label for="{{$name}}{{$item}}"> @lang('form.'.$item) </label>
    </div>
    @endforeach
</div>
