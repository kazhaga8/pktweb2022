@extends('webmin.layouts.formbase')
@section('formelement')
<x-webmin.input type="text" name="title" value="{!! isset($menu->title)? $menu->title : '' !!}" required="required" />
<x-webmin.radio name="menu_position" value="{!! isset($menu->menu_position)? $menu->menu_position : '' !!}"  required="required" :items="['main','right']" />
<x-webmin.radio name="menu_type" value="{!! isset($menu->menu_type)? $menu->menu_type : '' !!}" required="required" :items="['internal','anchor','external']" />
<x-webmin.radio name="menu_display" value="{!! isset($menu->menu_display)? $menu->menu_display : '' !!}" required="required" :items="['visible','hidden']" />
<x-webmin.input type="text" name="link" value="{!! isset($menu->link)? $menu->link : '' !!}" required="required" />
<x-webmin.select2 name="id_menu" placeholder="{{ __('form.select_id_menu') }}" value="{!! isset($menu->id_menu)? $menu->id_menu : '' !!}" :items="$parent" />
<x-webmin.input-file name="banner_img" type="1" value="{!! isset($menu->banner_img)? $menu->banner_img : '' !!}" required="required" />

@endsection
@section('javascript')
<script>
	$('#grouplink').hide();
	$('input[name=link]').removeAttr('required');
	$('#groupid_menu').hide();
	function triggerParent(_this){
		if (_this !== '' && $('input[name=menu_type]:checked').val() !== 'anchor') {
				$('#groupbanner_img').show();
				$('input[name=banner_img]').attr('required', 'required');
			} else {
				$('#groupbanner_img').hide();
				$('input[name=banner_img]').removeAttr('required');
			}
	}
	function menuFormInput(_this){
		if (_this === 'internal' || _this === 'anchor') {
				$('#grouplink').hide();
				$('input[name=link]').removeAttr('required');
				$('#groupid_menu').show();
				$('#groupbanner_img').hide();
				$('input[name=banner_img]').removeAttr('required');
				if (_this === 'anchor') {
					$('select[name=id_menu]').attr('required', 'required');
				} else {
					$('select[name=id_menu]').removeAttr('required');
				}
			} else {
				$('#grouplink').show();
				$('input[name=link]').attr('required', 'required');
				$('#groupid_menu').hide();
				$('select[name=id_menu]').removeAttr('required').val('').trigger('change');
			}
	}
	$(document).ready(function() {
		triggerParent("{{ isset($menu->banner_img)? $menu->banner_img : '' }}");
		<?php if(isset($menu->id)): ?>
			menuFormInput("{!! isset($menu->menu_type)? $menu->menu_type : '' !!}");
		<?php endif; ?>

		$('input[name=menu_type]').change(function() {
			$('select[name=id_menu]').val('').trigger('change');
			menuFormInput($(this).val());
		});
		$('select[name=id_menu]').change(function() {
			triggerParent($(this).val());
		});
	});
</script>
@endsection()
