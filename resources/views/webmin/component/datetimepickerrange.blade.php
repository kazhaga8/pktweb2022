<div class="form-group" id="group{{ $name ?? 'name' }}">
    <label for="{{ $name ?? 'name' }}">@lang('form.'.$name) {{ (isset($required) && $required==true)?"*":"" }} :</label>
    <div>
        <div class="input-group">
            <input type="text" class="form-control input-daterange-datepicker datetimepickerrange" placeholder="dd/mm/yyyy - dd/mm/yyyy"  name="{{ $name ?? 'name' }}" id="{{ $name ?? 'name' }}" value="{{ $value }}" {{ (isset($required))?"required":"" }}>
            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
        </div><!-- input-group -->
        
    </div>
</div>