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
        <p class="section-title">HUBUNGI KAMI</p>
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
            <label for="input-subject" class="form-label">Subjek</label><label class="text-danger">&nbsp;*</label>
            <input name="subject" type="text" class="form-control" id="input-subject" placeholder="Subject Pesan" value="{{ old('subject') }}">
            @error('subject')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-destination" class="form-label">Tujuan</label><label class="text-danger">&nbsp;*</label>
            <select class="form-select" name="tujuan">
              <option selected value="">Pilih Tujuan</option>
              <option <?php echo (old('tujuan') == "Website") ? "selected" : "" ?> value="Website">Website</option>
              <option <?php echo (old('tujuan') == "Ketenagakerjaan") ? "selected" : "" ?> value="Ketenagakerjaan">Ketenagakerjaan</option>
              <option <?php echo (old('tujuan') == "IT") ? "selected" : "" ?> value="IT">IT</option>
              <option <?php echo (old('tujuan') == "GCG / Kode Etik") ? "selected" : "" ?> value="GCG / Kode Etik">GCG / Kode Etik</option>
              <option <?php echo (old('tujuan') == "TJSL") ? "selected" : "" ?> value="TJSL">TJSL</option>
              <option <?php echo (old('tujuan') == "Produk") ? "selected" : "" ?> value="Produk">Produk</option>
              <option <?php echo (old('tujuan') == "Keluhan Pelanggan") ? "selected" : "" ?> value="Keluhan Pelanggan">Keluhan Pelanggan</option>
            </select>
            @error('tujuan')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-name" class="form-label">Nama</label><label class="text-danger">&nbsp;*</label>
            <input name="name" type="nama" class="form-control" id="input-nama" placeholder="Tulis Nama Anda" value="{{ old('name') }}">
            @error('name')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-email" class="form-label">Email</label><label class="text-danger">&nbsp;*</label>
            <input name="email" type="email" class="form-control" id="input-email" placeholder="Tulis Email Anda" value="{{ old('email') }}">
            @error('email')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-ktp" class="form-label">No KTP</label><label class="text-danger">&nbsp;*</label>
            <input name="ktp" type="ktp" class="form-control" id="input-ktp" placeholder="Tulis No KTP Anda" value="{{ old('ktp') }}">
            @error('ktp')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-phone" class="form-label">No HP</label><label class="text-danger">&nbsp;*</label>
            <input name="phone" type="tel" class="form-control" id="input-phone" placeholder="Tulis Nomor HP Anda" value="{{ old('phone') }}">
            @error('phone')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>
          <div class="mb-3">
            <label for="input-message" class="form-label">Pesan</label><label class="text-danger">&nbsp;*</label>
            <textarea name="message" class="form-control" placeholder="Isi Pesan" id="input-message" style="height: 100px">{{ old('message') }}</textarea>
            @error('message')
            <label class="text-danger">{{ $message }}</label>
            @enderror
          </div>

          <div class="mb-3">
            <label for="input-ktp-file" class="form-label">Upload KTP (Max. 500KB)</label><label class="text-danger">&nbsp;*</label>
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
</script>
@endpush