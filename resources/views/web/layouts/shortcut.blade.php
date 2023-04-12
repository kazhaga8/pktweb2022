<!-- ======= Shorcut Menu ======= -->
<div class="box-shorcut-menu">
  <i class="ri-phone-lock-fill trigger-shorcut-menu"></i>
  <div class="shorcut-menu">
    <ul class="link">
      @if(count($nav_shortcut))
      @foreach($nav_shortcut as $item)
      <li>{!! $item->icon !!}<a href="{{ $item->href }}" target="_blank">{{ $item->title }}</a></li>
      @endforeach
      @endif
    </ul>
    <hr class="text-white" />
    <ul class="info">
      {!! html_entity_decode(config('app.content_shortcut_'.request()->route()->parameters['locale'])) !!}
    </ul>
  </div>
</div><!-- End Shorcut Menu -->
