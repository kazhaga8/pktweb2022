
@if($dragndrop)
<div class="row">
    <div class="col-sm-12 col-xs-12">
        <h4 class="header-title m-t-0">@lang('form.'.$name)  {{ (isset($required) && $required == true)?"*":"" }}:</h4>
        <div class="p-20">
            <div class="form-group clearfix">
                <div class="col-sm-12 padding-left-0 padding-right-0">
                    <input type="file" name="{{ (isset($name))?$name:'' }}{{ (isset($multiple) && $multiple == true)?[]:'' }}" id="{{ (isset($name))?$name:''}}" class="filedragdrop" {{ (isset($multiple) && $multiple == "true")?'multiple="true"':'' }} extensions="{{implode('|',$allowext)}}">
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row m-t-50">
    <div class="col-xs-12 col-sm-6">
        <h4 class="header-title m-t-0">@lang('form.'.$name)  {{ (isset($required) && $required == true)?"*":"" }}:</h4>
        <div class="p-20">
            <div class="form-group clearfix">
                <div class="col-sm-12 padding-left-0 padding-right-0">
                    <input type="file" name="{{ (isset($name))?$name:'' }}{{ (isset($multiple) && $multiple == true)?[]:'' }}" id="{{ (isset($name))?$name:''}}" class="fileupload" {{ (isset($multiple) && $multiple == "true")?'multiple="true"':'' }} extensions="{{implode('|',$allowext)}}">
                    
                </div>
            </div>

        </div>
    </div>
</div>
@endif

