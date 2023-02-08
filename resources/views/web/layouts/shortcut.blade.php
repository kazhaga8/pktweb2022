
    <!-- ======= Shorcut Menu ======= -->
    <div class="box-shorcut-menu">
      <i class="ri-phone-lock-fill trigger-shorcut-menu"></i>
      <div class="shorcut-menu">
        <ul class="link">
          <li><i class="ri-notification-4-fill"></i><a href="http://www.pktbersih.com/" target="_blank">Whistleblowing System</a></li>
          <li><i class="ri-file-list-3-fill"></i><a href="https://eproc.pupuk-indonesia.com/" target="_blank">E-Procurement</a></li>
          <li><i class="ri-mail-fill"></i><a href="#" target="_blank">Pengaduan Pemasaran</a></li>
          <li><i class="ri-bookmark-fill"></i><a href="#" target="_blank">E-Media</a></li>
          <li><i class="ri-star-fill"></i><a href="http://pupuk-indonesia.com/" target="_blank">Pupuk Indonesia</a></li>
          <li><i class="ri-clipboard-fill"></i><a href="https://customer.pupukkaltim.com/" target="_blank">Pendaftaran Customer</a></li>
          <li><i class="ri-shirt-fill"></i><a href="https://internship.pupukkaltim.com/" target="_blank">Program Internship</a></li>
          <li><i class="ri-reactjs-line"></i><a href="https://grc.pupukkaltim.com/" target="_blank">Portal GRC</a></li>
          <li><i class="ri-feedback-fill"></i><a href="https://elhkpn.kpk.go.id/portal/user/pengumuman_lhkpn/VERWVFpGZHhlVU5TUml0VVJGbDBZMlJOTmt4NVYzbHJkR3hRVnpkR2FURjJWM2NyZDJWWE1WQm5Oa3hIVjI1eGNERkNhRWRDY1ZkcFlsb3pPVzR6T1E9PQ==" target="_blank">E-Announcement LHKPN</a></li>
        </ul>
        <hr class="text-white" />
        <ul class="info">
          {!! html_entity_decode($config['content_shortcut_'.request()->route()->parameters['locale']]) !!}
        </ul>
      </div>
    </div><!-- End Shorcut Menu -->