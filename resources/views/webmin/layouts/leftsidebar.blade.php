<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
            <div class="sidebar-inner slimscrollleft">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <ul>

                        <li><a href="{{ route('dashboard') }}" class="waves-effect"><i class="mdi mdi-bulletin-board"></i><span> Dashboard </span></a></li>

                        <li class="menu-title m-t-20">Page Management</li>
                        @can('menu-list')
                        <li><a href="{{ route('menus.index') }}" class="waves-effect"><i class="mdi mdi-menu"></i><span> Menus </span></a></li>
                        @endcan
                        @can('page-list')
                        <li><a href="{{ route('pages.index') }}" class="waves-effect"><i class="mdi mdi-google-pages"></i><span> Pages </span></a></li>
                        @endcan

                        <li class="menu-title m-t-20">User Management</li>
                        @can('role-list')
                        <li><a href="{{ route('roles.index') }}" class="waves-effect"><i class="mdi mdi-account-key"></i><span> Roles </span></a></li>
                        @endcan
                        @can('user-list')
                        <li><a href="{{ route('users.index') }}" class="waves-effect"><i class="mdi mdi-account-multiple"></i><span> Users </span></a></li>
                        @endcan

                        <li class="menu-title  m-t-20">Master Data</li>
                        @can('slider-list')
                        <li><a href="{{ route('sliders.index') }}" class="waves-effect"><i class=" mdi mdi-burst-mode"></i><span> Slider </span></a></li>
                        @endcan
                        @can('sliders-bottom-list')
                        <li><a href="{{ route('sliders-bottom.index') }}" class="waves-effect"><i class=" mdi mdi-burst-mode"></i><span> Slider  Bottom </span></a></li>
                        @endcan
                        @can('news-category-list')
                        <li><a href="{{ route('news-category.index') }}" class="waves-effect"><i class=" mdi mdi-newspaper"></i><span> News Category </span></a></li>
                        @endcan
                        @can('news-list')
                        <li><a href="{{ route('news.index') }}" class="waves-effect"><i class=" mdi mdi-newspaper"></i><span> News </span></a></li>
                        @endcan
                        @can('certificate-list')
                        <li><a href="{{ route('certificates.index') }}" class="waves-effect"><i class=" mdi mdi-certificate"></i><span> Certificate </span></a></li>
                        @endcan
                        @can('timeline-list')
                        <li><a href="{{ route('timelines.index') }}" class="waves-effect"><i class=" mdi mdi-altimeter"></i><span> Timeline </span></a></li>
                        @endcan
                        @can('management-list')
                        <li><a href="{{ route('managements.index') }}" class="waves-effect"><i class=" mdi mdi-account-network"></i><span> Management </span></a></li>
                        @endcan
                        @can('gallery-list')
                        <li><a href="{{ route('galleries.index') }}" class="waves-effect"><i class=" mdi mdi-folder-multiple-image"></i><span> Gallery </span></a></li>
                        @endcan
                        @can('product-list')
                        <li><a href="{{ route('products.index') }}" class="waves-effect"><i class=" mdi mdi-shopping"></i><span> Product </span></a></li>
                        @endcan
                        @can('contact-list')
                        <li><a href="{{ route('contacts.index') }}" class="waves-effect"><i class=" mdi mdi-contact-mail"></i><span> Contact </span></a></li>
                        @endcan
                        @can('contact-us-list')
                        <li><a href="{{ route('contact-us.index') }}" class="waves-effect"><i class=" mdi mdi-contact-mail"></i><span> Contact Us </span></a></li>
                        @endcan
                        @can('contact-us-to-list')
                        <li><a href="{{ route('contact-us-to.index') }}" class="waves-effect"><i class=" mdi mdi-contact-mail"></i><span> Contact Us Email </span></a></li>
                        @endcan
                        @can('shortcut-list')
                        <li><a href="{{ route('shortcuts.index') }}" class="waves-effect"><i class="mdi mdi-link-variant"></i><span> Shortcuts </span></a></li>
                        @endcan
                        @can('config-list')
                        <li><a href="{{ route('configs.index') }}" class="waves-effect"><i class=" mdi mdi-settings"></i><span> Config </span></a></li>
                        @endcan

                        <li class="menu-title  m-t-20">Program</li>
                        @can('program-tjsl-list')
                        <li><a href="{{ route('program-tjsl.index') }}" class="waves-effect"><i class=" mdi mdi-plus-network"></i><span> Program TJSL </span></a></li>
                        @endcan
                        @can('program-empowerment-list')
                        <li><a href="{{ route('program-empowerment.index') }}" class="waves-effect"><i class=" mdi mdi-plus-network"></i><span> Pemberdayaan </span></a></li>
                        @endcan

                        <li class="menu-title  m-t-20">E Book</li>
                        @can('sustainability-report-list')
                        <li><a href="{{ route('sustainability-report.index') }}" class="waves-effect"><i class=" mdi mdi-book-plus"></i><span> Sustainability Report </span></a></li>
                        @endcan
                        @can('annual-report-list')
                        <li><a href="{{ route('annual-report.index') }}" class="waves-effect"><i class=" mdi mdi-book-multiple-variant"></i><span> Annual Report </span></a></li>
                        @endcan
                        @can('financial-statements-list')
                        <li><a href="{{ route('financial-statements.index') }}" class="waves-effect"><i class=" mdi mdi-file-document"></i><span> Financial Statements </span></a></li>
                        @endcan
                        <li><a href="{{ route('e-magazine.index') }}" class="waves-effect"><i class=" mdi mdi-book-open"></i><span> E-Magazine </span></a></li>

                        <li class="menu-title m-t-20"></li>
                        <li><a href="{{ route('files.index') }}" class="waves-effect"><i class="mdi mdi-file-tree"></i><span> File Manager </span></a></li>

                        {{-- <li class="menu-title m-t-20"></li>
                        <li>
                        <a  class="waves-effect" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="ti-power-off m-r-5"></i>
                                <span>
                                {{ __('Logout') }}
                                </span>
                            </a>

                            <form id="btn-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li> --}}
                    </ul>
                </div>
                <!-- Sidebar -->
                <div class="clearfix"></div>

                <div class="help-box">
                    {{-- <h5 class="text-muted m-t-0">For Help ?</h5> --}}
                    {{-- <p class=""><span class="text-custom">Email:</span> <br /> support@pktweb.co.id</p> --}}
                    {{-- <p class="m-b-0"><span class="text-custom">Call:</span> <br /> 031 1111111</p> --}}
                    <p class="m-b-0"><span class="text-custom">Manual Book:</span> <br /> <a href="{{asset('/public/manual/Manual_Book_Pengunaan_Aplikasi.pdf')}}">Download</a></p>
                </div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->
