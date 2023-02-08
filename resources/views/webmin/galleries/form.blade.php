@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input type="number" name="year" value="{!! isset($gallery->year)? $gallery->year : '' !!}" required="required" />
<x-webmin.radio name="type" value="{!! isset($gallery->type)? $gallery->type : '' !!}"  required="required" :items="['image','video']" />
<x-webmin.input type="text" name="title" value="{!! isset($gallery->title)? $gallery->title : '' !!}" required="required" />
<x-webmin.input-file name="image" label="{{ __('form.image') }}" type="2" value="{{ isset($gallery->media)? $gallery->media : '' }}" />
<x-webmin.input type="text" name="video" placeholder="exp: https://youtu.be/Y5pcZcLFi4c or Y5pcZcLFi4c" value="{!! isset($gallery->media)? $gallery->media : '' !!}" />
<iframe id="embedvideo" width="560" height="315" src="https://www.youtube.com/embed/" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
@endsection

@section('javascript')
<script>
	$('#groupimage').hide();
	$('input[name=image]').removeAttr('required');
	$('#groupvideo').hide();
	$('#embedvideo').hide();
	$('input[name=video]').removeAttr('required');
	function triggerType(_this){
		if (_this !== '' && $('input[name=type]:checked').val() === 'image') {
				$('#groupimage').show();
				$('input[name=image]').attr('required', 'required');
				$('#groupvideo').hide();
				$('#embedvideo').hide();
				$('input[name=video]').removeAttr('required');
			} 
    if (_this !== '' && $('input[name=type]:checked').val() === 'video') {
				$('#groupimage').hide();
				$('input[name=image]').removeAttr('required');
				$('#groupvideo').show();
				$('#embedvideo').show();
				$('input[name=video]').attr('required', 'required');
			}
	}
  function videoChange(_this) {
   const id = _this.replace('https://youtu.be/', '');
   $('#embedvideo').attr('src', 'https://www.youtube.com/embed/'+id);
  }
	$(document).ready(function() {
		triggerType("{{ isset($gallery->type)? $gallery->type : '' }}");
    videoChange("{{ isset($gallery->media)? $gallery->media : '' }}");
		$('input[name=type]').change(function() {
			triggerType($(this).val());
		});
    $('input[name=video]').change(function() {
      videoChange($(this).val());
    });
	});
</script>
@endsection