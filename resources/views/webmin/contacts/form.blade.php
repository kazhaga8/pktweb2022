@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input type="text" name="title" value="{!! isset($contact->title)? $contact->title : '' !!}" required="required" />
<x-webmin.input-file name="image" label="{{ __('form.image') }}" type="2" value="{{ isset($contact->image)? $contact->image : '' }}" />
<x-webmin.texteditor name="content" label="{{ __('form.address') }}" value="{!! isset($contact->content)? $contact->content : '' !!}" equired="required" />
<x-webmin.textarea name="maps" value="{!! isset($contact->maps)? $contact->maps : '' !!}" required="required" />
<div id="iframe-maps"></div>
@endsection
@section('javascript')
<script>
	$('textarea[name=maps]').change(function() {
		const maps = $(this).val();
		if (
			~maps.indexOf("https://www.google.com/maps/embed") &&
			~maps.indexOf("<iframe") &&
			~maps.indexOf("</iframe>")
			) {
      $("#iframe-maps").html(maps);
		} else {
      $("#iframe-maps").html('');
		}
	});
	$('textarea[name=maps]').trigger('change')
</script>
@endsection