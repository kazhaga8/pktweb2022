@extends('webmin.layouts.formbase')
@section('formelement')

<x-webmin.select2 name="product" label="{{ __('form.product') }}" placeholder="{{ __('form.select_product') }}" value="{!! isset($product->product)? $product->product : '' !!}"  required="required" :items="$product_options" />
<x-webmin.input type="text" name="variant" value="{!! isset($product->variant)? $product->variant : '' !!}" required="required" />
<x-webmin.input-file name="image" label="{{ __('form.image') }}" type="2" value="{{ isset($product->image)? $product->image : '' }}" />
@endsection
