@if(strpos($__env->yieldContent('content'),'type="file"'))
@prepend('css')
<!-- Jquery filer css -->
<link href="{{ url('public') }}/plugins/jquery.filer/css/jquery.filer.css" rel="stylesheet" />
<link href="{{ url('public') }}/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet" />
@endprepend
@prepend('js')
<!-- Jquery filer js -->
<script src="{{ url('public') }}/plugins/jquery.filer/js/jquery.filer.min.js"></script>
@endprepend
@prepend('javascript')
<!-- Jquery filer init -->
<script src="{{ url('public') }}/assets/pages/jquery.fileuploads.init.js"></script>
@endprepend
@endif


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
<script src="{{ url('public') }}/assets/pages/jquery.form-datepickers.init.js"></script>
@endprepend
@endif

@if(strpos($__env->yieldContent('content'),'texteditor'))
@prepend('css')
@endprepend
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
                external_filemanager_path: "{{ url('public') }}/plugins/responsivefilemanager/filemanager/",
                filemanager_title: "Responsive Filemanager",
                external_plugins: {
                    "responsivefilemanager": "{{ url('public') }}/plugins/tinymce/plugins/responsivefilemanager/plugin.min.js",
                    "filemanager": "{{ url('public') }}/plugins/responsivefilemanager/filemanager/plugin.min.js"
                },
                templates: [{
                    title: "Home - About",
                    url: "{{ url('public') }}/assets/templates/home-about.html",
                    // description: "For Home"
                },{
                    title: "Home - Product",
                    url: "{{ url('public') }}/assets/templates/home-product.html",
                },{
                    title: "Home - Investor",
                    url: "{{ url('public') }}/assets/templates/home-investor.html",
                }],
                content_css: [
                    // "{{ url('public') }}/assets/web/vendor/aos/aos.css",
                    "{{ url('public') }}/assets/web/vendor/bootstrap/css/bootstrap.min.css",
                    "{{ url('public') }}/assets/web/vendor/glightbox/css/glightbox.min.css",
                    "{{ url('public') }}/assets/web/vendor/remixicon/remixicon.css",
                    "{{ url('public') }}/assets/web/vendor/swiper/swiper-bundle.min.css",
                    "https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css",
                    "https://cdn.jsdelivr.net/jquery.slick/1.5.0/slick-theme.css",
                    "{{ url('public') }}/assets/web/css/style.css"
                ],
                setup: function(ed) {
                    ed.on('init', function() {
                        // var head = ed.dom.select('head')[0]
                        // ed.dom.add(head, 'link', {
                        //     src: "{{ url('public') }}/assets/web/vendor/aos/aos.css",
                        //     type: 'text/css',
                        //     rel: 'stylesheet'
                        // });
                        var body = ed.dom.select('body')[0]
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
                            src: "{{ url('public') }}/assets/web/js/main.js",
                            type: 'text/javascript'
                        });
                    })
                }
            });
        }
    });
</script>
@endprepend
@endif


@prepend('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endprepend
@prepend('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endprepend
@prepend('javascript')
<script>
    $('.iframe-btn').fancybox({
        width: '100%',
        maxWidth: 960,
        'height': 600,
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
            .filter(function(v){return v!==''});
        if (url) {
            var ul = document.createElement("ul");
            ul.className = "list-unstyled"
            $("#display-"+field_id).html(ul);
            fileName.map(item => {
                var li = document.createElement("li");
                if (/\.(jpg|gif|png)$/.test(item)) {
                    li.innerHTML = '<img class="img-thumbnail" src="' + item + '" />';
                } else if (/\.(pdf)$/.test(item)) {
                    const files = item.split('/').slice(-1)[0] 
                    li.innerHTML = '<a target="_blank" href="{{ route('ebook.index') }}/'+files+'"> '+files+' </a>';
                } else {
                    li.innerHTML = '<span> '+item+' </span>';
                }
                ul.appendChild(li);
            });
            $('#' + field_id).val(url.replace("{{ url('public') }}", ""));
        }
    }
</script>
@endprepend