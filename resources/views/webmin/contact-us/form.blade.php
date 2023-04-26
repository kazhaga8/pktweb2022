@extends('webmin.layouts.formbase')
@section('formelement')
<div class="form-group">
  <label>{{ __('form.subject') }}  :</label>
  <p>{!! isset($contact_us->subject)? $contact_us->subject : '' !!}</p>
</div>
<div class="form-group">
  <label>{{ __('form.name') }}  :</label>
  <p>{!! isset($contact_us->name)? $contact_us->name : '' !!}</p>
</div>
<div class="form-group">
  <label>{{ __('form.email') }}  :</label>
  <p>{!! isset($contact_us->email)? $contact_us->email : '' !!}</p>
</div>
<div class="form-group">
  <label>{{ __('form.phone') }}  :</label>
  <p>{!! isset($contact_us->phone)? $contact_us->phone : '' !!}</p>
</div>
<div class="form-group">
  <label>{{ __('form.message') }}  :</label>
  <p>{!! isset($contact_us->message)? $contact_us->message : '' !!}</p>
</div>
<div class="form-group">
  <label>KTP  :</label>
  <p>{!! isset($contact_us->ktp)? $contact_us->ktp : '' !!}</p>
  <img src="{{ isset($contact_us->ktp_file)? url('public').'/'.$contact_us->ktp_file : '' }}" width="300" />
</div>
@endsection
@push('javascript')
<script>
    $(document).ready(function() {
        $('button[type="submit"]').remove();
    });
</script>
@endpush
