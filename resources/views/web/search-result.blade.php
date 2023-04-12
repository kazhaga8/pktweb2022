@if (count($data))
    @foreach($data as $key => $value)
    <li class="pl-1 text-grey fs-6 fw-lighter lh-md mb-4" style="border-bottom: 1px solid black">
        <h5><a style="color: black" href="{{ $value->href }}" target="_blank">{!! $value->title !!}</a></h5>
        <p class="pl-1 text-grey fs-6 fw-lighter lh-md">{!! $value->content !!}</p>
    </li>
    @endforeach
@endif
