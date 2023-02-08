@if(strpos($__env->yieldContent('content'),'select2'))
@prepend('css')
<!-- Jquery select2 css -->
<link href="{{ url('public') }}/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endprepend
@prepend('js')
<!-- Jquery select2 js -->
<script src="{{ url('public') }}/plugins/select2/js/select2.min.js"></script>
@endprepend
@prepend('javascript')
<!-- Jquery select2 init -->
<script type="text/javascript">
    $(".select2").select2({
        allowClear: true,
        placeholder: function() {
            $(this).data('placeholder');
        }
    }).on('change', function() {
        if ($(".select2").find('.select2-selection__clear')[0]) {
            $(".select2").find('.select2-selection__arrow').css("visibility", "hidden");
        } else {
            $(".select2").find('.select2-selection__arrow').css("visibility", "visible");
        }
    });
</script>
@endprepend
@endif

@if(strpos($__env->yieldContent('content'),'datepicker') || strpos($__env->yieldContent('content'),'datepickerrange') || strpos($__env->yieldContent('content'),'datetimepickerrange'))
@prepend('css')
<!-- Jquery datepicker css -->
<link href="{{ url('public') }}/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="{{ url('public') }}/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@endprepend
@prepend('js')
<!-- Jquery datepicker js -->
<script src="{{ url('public') }}/plugins/moment/moment.js"></script>
<script src="{{ url('public') }}/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="{{ url('public') }}/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
@endprepend
@prepend('javascript')
<!-- Jquery datepicker init -->
<script src="{{ url('public') }}/plugins/jquery/jquery.form-datepickers.init.js"></script>
@endprepend
@endif

@if(strpos($__env->yieldContent('content'),'texteditor'))
@prepend('js')
<!--Wysiwig js-->
<script src="{{ url('public') }}/plugins/tinymce/tinymce.min.js"></script>
@endprepend
@prepend('javascript')
<!-- Jquery select2 init -->
<script>
    $(document).ready(function() {
        if ($(".texteditor").length > 0) {
            tinymce.init({
                selector: "textarea.texteditor",
                theme: "modern",
                height: 300,
                plugins: [
                    "advlist autolink link image filemanager code responsivefilemanager template fullscreen noneditable"
                ],
                toolbar1: '| undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist',
                toolbar2: "| responsivefilemanager | link unlink | image | template fullscreen | code",
                noneditable_noneditable_class: 'as-is-it',
                noneditable_editable_class: 'edit-is-it',
                external_filemanager_path: "{{ url('public') }}/plugins/responsivefilemanager/filemanager/",
                filemanager_title: "Responsive Filemanager",
                external_plugins: {
                    "responsivefilemanager": "{{ url('public') }}/plugins/responsivefilemanager/tinymce/plugins/responsivefilemanager/plugin.min.js",
                    "filemanager": "{{ url('public') }}/plugins/responsivefilemanager/filemanager/plugin.min.js"
                },
                apply_source_formatting : true,
                forced_root_block: false,
                inline_styles: true,
                valid_elements : '*[*]',
                extended_valid_elements : '*[*]',
                valid_child_elements : '*[*]',
                valid_children : '*[*]',
                templates: [{
                    title: "Home - About",
                    url: "{{ url('public') }}/assets/templates/home-about.html",
                    // description: "For Home"
                }, {
                    title: "Home - Product",
                    url: "{{ url('public') }}/assets/templates/home-product.html",
                }, {
                    title: "Home - Investor",
                    url: "{{ url('public') }}/assets/templates/home-investor.html",
                }, {
                    title: "Home - Penghargaan",
                    url: "{{ url('public') }}/assets/templates/home-award.html",
                }, {
                    title: "Home - Info Terbaru",
                    url: "{{ url('public') }}/assets/templates/home-news.html",
                }, {
                    title: "Profil - Riwayat Singkat",
                    url: "{{ url('public') }}/assets/templates/profile-a-brief-history.html",
                }, {
                    title: "Profil - Budaya Perusahaan",
                    url: "{{ url('public') }}/assets/templates/profile-corporate-custure.html",
                }, {
                    title: "Profil - Profil Bisnis",
                    url: "{{ url('public') }}/assets/templates/profile-business-profile.html",
                }, {
                    title: "Profil - Pengembangan Bisnis",
                    url: "{{ url('public') }}/assets/templates/profile-business-development.html",
                }, {
                    title: "Struktur - Struktur Organisasi Perusahaan",
                    url: "{{ url('public') }}/assets/templates/struktur-organisasi.html",
                }, {
                    title: "Struktur - Struktur Kepemilikan Saham",
                    url: "{{ url('public') }}/assets/templates/struktur-kepemilikan.html",
                }, {
                    title: "Struktur - Anak Usaha PKT",
                    url: "{{ url('public') }}/assets/templates/struktur-anper.html",
                }, {
                    title: "Laporan - Keberlanjutan",
                    url: "{{ url('public') }}/assets/templates/laporan-keberlanjutan.html",
                }, {
                    title: "Laporan - Tahunan",
                    url: "{{ url('public') }}/assets/templates/laporan-tahunan.html",
                }, {
                    title: "Laporan - Keuangan",
                    url: "{{ url('public') }}/assets/templates/laporan-keuangan.html",
                }, {
                    title: "Component - Preview & Download",
                    url: "{{ url('public') }}/assets/templates/preview-download.html",
                }, {
                    title: "Component - FOOTER",
                    url: "{{ url('public') }}/assets/templates/footer.html",
                }, {
                    title: "Component - SHORTCUT INFO",
                    url: "{{ url('public') }}/assets/templates/shorcut.html",
                }],
                content_css: [
                    // "{{ url('public') }}/assets/web/vendor/aos/aos.css",
                    "{{ url('public') }}/assets/web/vendor/bootstrap/css/bootstrap.min.css",
                    "{{ url('public') }}/assets/web/vendor/glightbox/css/glightbox.min.css",
                    "{{ url('public') }}/assets/web/vendor/remixicon/remixicon.css",
                    "{{ url('public') }}/assets/web/vendor/swiper/swiper-bundle.min.css",
                    "https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css",
                    "https://cdn.jsdelivr.net/jquery.slick/1.5.0/slick-theme.css",
                    "{{ url('public') }}/assets/web/css/style.css",
                    "{{ url('public') }}/assets/web/css/style-improve.css",
                    "{{ url('public') }}/assets/web/css/style-webmin.css"
                ],
                setup: function(ed) {
                    ed.on('init', function() {
                        var body = ed.dom.select('html')[0]
                        ed.dom.add(body, 'script', {
                            src: "{{ url('public') }}/assets/web/vendor/aos/aos.js",
                            type: 'text/javascript'
                        });
                        ed.dom.add(body, 'script', {
                            src: "{{ url('public') }}/assets/web/vendor/bootstrap/js/bootstrap.bundle.min.js",
                            type: 'text/javascript'
                        });
                        ed.dom.add(body, 'script', {
                            src: "{{ url('public') }}/assets/web/vendor/glightbox/js/glightbox.min.js",
                            type: 'text/javascript'
                        });
                        ed.dom.add(body, 'script', {
                            src: "{{ url('public') }}/assets/web/vendor/isotope-layout/isotope.pkgd.min.js",
                            type: 'text/javascript'
                        });
                        ed.dom.add(body, 'script', {
                            src: "{{ url('public') }}/assets/web/vendor/swiper/swiper-bundle.min.js",
                            type: 'text/javascript'
                        });
                        ed.dom.add(body, 'script', {
                            src: "{{ url('public') }}/assets/web/vendor/waypoints/noframework.waypoints.js",
                            type: 'text/javascript'
                        });
                        ed.dom.add(body, 'script', {
                            src: "https://code.jquery.com/jquery-3.4.1.min.js",
                            type: 'text/javascript'
                        });
                        ed.dom.add(body, 'script', {
                            src: "https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js",
                            type: 'text/javascript'
                        });
                        ed.dom.add(body, 'script', {
                            src: "https://cdn.jsdelivr.net/npm/@panzoom/panzoom/dist/panzoom.min.js",
                            type: 'text/javascript'
                        });
                        ed.dom.add(body, 'script', {
                            src: "{{ url('public') }}/assets/web/js/main.js",
                            type: 'text/javascript'
                        });
                    })
                },
            });
        }
    });
</script>
@endprepend
@endif

@if(strpos($__env->yieldContent('content'),'iframe-btn'))
@prepend('javascript')
<script>
    $('.iframe-btn').fancybox({
        width: '100%',
        maxWidth: 860,
        'height': 500,
        'type': 'iframe',
        'autoScale': false
    });

    function isFileImage(file) {
        const acceptedImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
        return file && $.inArray(file['type'], acceptedImageTypes)
    }

    function responsive_filemanager_callback(field_id) {
        var url = $('#' + field_id).val();
        var fileName = decodeURI(url)
            .replace(/\[|\]|"/g, '')
            .split(',')
            .filter(function(v) {
                return v !== ''
            });
        if (url) {
            var ul = document.createElement("ul");
            ul.className = "list-unstyled"
            $("#display-" + field_id).html(ul);
            fileName.map(item => {
                var li = document.createElement("li");
                if (/\.(jpg|gif|png)$/.test(item)) {
                    li.innerHTML = '<img class="img-thumbnail" src="' + item + '" />';
                } else if (/\.(pdf)$/.test(item)) {
                    const files = item.split('/').slice(-1)[0]
                    const ebook = "{{ route('ebook.index') }}";
                    li.innerHTML = '<a target="_blank" href="' + ebook + '/' + files + '"> ' + files + ' </a>';
                } else {
                    li.innerHTML = '<span> ' + item + ' </span>';
                }
                ul.appendChild(li);
            });
            $('#' + field_id).val(url.replace("{{ url('public') }}", ""));
        }
    }
</script>
@endprepend
@endif