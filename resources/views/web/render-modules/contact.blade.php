<section class="product">
  <div class="container" data-aos="fade-up">
    <div class="row content">
      <div class="col-lg-12 pt-4 pt-lg-0">
        <div class="w-100 text-white bg-transparent">
          <select class="form-select bg-transparent text-white" id="select-branch">
            @foreach($contact as $item)
            <option value="{{ str_slug($item->title) }}">{{ $item->title }}</option>
            @endforeach
          </select>
        </div>
        @foreach($contact as $item)
        <div class="hide-contact {{ str_slug($item->title) }}">
          <div class="row content d-flex align-items-center {{ str_slug($item->title) }}">
            <div class="col-lg-6">
              {!! $item->content !!}
            </div>
            <div class="col-lg-6">
              <img src="{{ url('public').$item->image }}" alt="{{ $item->title }}" />
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
<section class="p-0">
  @foreach($contact as $item)
  <div class="hide-contact {{ str_slug($item->title) }}">
    {!! $item->maps !!}
  </div>
  @endforeach
</section>
<section id="form">
  <div class="container" data-aos="fade-up">
    <div class="row content">
      <div class="col-lg-3">
        <p class="section-title">{{ __('web.contact-us') }}</p>
      </div>
      <div class="col-lg-9 pt-4 pt-lg-0">
        <form method="post" action="{{ route('send-contact') }}" enctype="multipart/form-data">
          @if (session('success_submit_contact'))
          <div class="mb-3">
            <label class="text-success">{{ session('success_submit_contact') }}</label>
          </div>
          @endif
          @csrf
          <div class="mb-3">
            <label for="input-subject" class="form-label">{{ __('web.subject') }}</label><label class="text-danger">&nbsp;*</label>
            <input name="subject" type="text" class="form-control" id="input-subject" placeholder="{{ __('web.write-placeholder', ['field' => __('web.subject')]) }}" value="{{ old('subject') }}">
            @error('subject')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-destination" class="form-label">{{ __('web.necessity') }}</label><label class="text-danger">&nbsp;*</label>
            <input type="hidden" name="to">
            <select class="form-select" name="tujuan">
              <option selected value="">{{ __('web.select-necessity') }}</option>
              @foreach($mailto as $item)
              <option <?php echo (old('tujuan') == $item->title) ? "selected" : "" ?> value="{{ $item->title }}" data-tujuan="{{ $item->id }}">{{ $item->title }}</option>
              @endforeach
            </select>
            @error('tujuan')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-name" class="form-label">{{ __('web.name') }}</label><label class="text-danger">&nbsp;*</label>
            <input name="name" type="nama" class="form-control" id="input-nama" placeholder="{{ __('web.write-placeholder', ['field' => __('web.name')]) }}" value="{{ old('name') }}">
            @error('name')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-email" class="form-label">{{ __('web.email') }}</label><label class="text-danger">&nbsp;*</label>
            <input name="email" type="email" class="form-control" id="input-email" placeholder="{{ __('web.write-placeholder', ['field' => __('web.email')]) }}" value="{{ old('email') }}">
            @error('email')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-ktp" class="form-label">{{ __('web.id-card') }}</label><label class="text-danger">&nbsp;*</label>
            <input name="ktp" type="ktp" class="form-control" id="input-ktp" placeholder="{{ __('web.write-placeholder', ['field' => __('web.id-card')]) }}" value="{{ old('ktp') }}">
            @error('ktp')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-phone" class="form-label">{{ __('web.phone') }}</label><label class="text-danger">&nbsp;*</label>
            <input name="phone" type="tel" class="form-control" id="input-phone" placeholder="{{ __('web.write-placeholder', ['field' => __('web.phone')]) }}" value="{{ old('phone') }}">
            @error('phone')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-message" class="form-label">{{ __('web.message') }}</label><label class="text-danger">&nbsp;*</label>
            <textarea name="message" class="form-control" placeholder="{{ __('web.write-placeholder', ['field' => __('web.message')]) }}" id="input-message" style="height: 100px">{{ old('message') }}</textarea>
            @error('message')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>

          <div class="mb-3">
            <label for="input-ktp-file" class="form-label">{{ __('web.upload-id-card') }} (Max. 500KB)</label><label class="text-danger">&nbsp;*</label>
            <input name="ktp_file" type="file" class="form-control" id="input-ktp-file">
            @error('ktp_file')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>

          <div class="mb-3">
            <label for="input-captcha" class="form-label">Captcha</label><label class="text-danger">&nbsp;*</label>
            <img src="data:image/jpeg;base64,{{ $captcha }}" alt="gambar" style="display:block;margin-bottom:10px;border-radius:3px;" />
            <input name="captcha" type="text" value="" placeholder="Input Captcha" class="form-control">
            @error('captcha')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <br />
          <br />
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</section>

@push('javascript')

<script>
  $('.hide-contact').hide();
  $('.{{ str_slug(count($contact) ? $contact[0]->title : "") }}').show();
  $('#select-branch').on('change', function() {
    $('.hide-contact').hide();
    $('.'+this.value).show();
  });
    $(document).ready(function() {
        $('select[name="tujuan"]').on('change', function() {
            var value = $(this).find('option:selected').attr('data-tujuan');
            $('input[name="to"]').val(value);
        });
    });
</script>
@endpush
