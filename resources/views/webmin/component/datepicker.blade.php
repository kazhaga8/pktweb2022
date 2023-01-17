<div class="form-group" id="group{{ $name ?? 'name' }}">
    <label for="{{ $name ?? 'name' }}">@lang('form.'.$name) {{ (isset($required) && $required == true)?"*":"" }} :</label>
    <div>
        <div class="input-group">
            <input type="text" class="form-control datepickers" placeholder="dd/mm/yyyy"  name="{{ $name ?? 'name' }}" id="{{ $name ?? 'name' }}" value="{{ (isset($value))?date('d/m/Y',strtotime($value)):'' }}" {{ (isset($required) && $required == true)?"required":"" }}>
            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
        </div><!-- input-group -->
    </div>
</div>