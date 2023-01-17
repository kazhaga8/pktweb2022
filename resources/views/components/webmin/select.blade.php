<div class="form-group" id="group{{ $name }}" >
    <label for="{{ $name }}">@lang('form.'.$name) {{ $required?"*":"" }} :</label>
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        class="form-control"
        {{ $required?"required":"" }}
    >
        <option value="">Choose...</option>
        @foreach ($items as $item)
        <option value="{{$item}}">@lang('form.'.$item)</option>
        @endforeach
    </select>
</div>