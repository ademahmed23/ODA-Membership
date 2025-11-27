<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('front/images/logo (1).png') }}" height="30em" width="30em">
                {{-- <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                        <path d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z" id="path-3"></path>
                        <path d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z" id="path-4"></path>
                        <path d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z" id="path-5"></path>
                    </defs>
                    <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                            <g id="Icon" transform="translate(27.000000, 15.000000)">
                                <g id="Mask" transform="translate(0.000000, 8.000000)">
                                    <mask id="mask-2" fill="white">
                                        <use xlink:href="#path-1"></use>
                                    </mask>
                                    <use fill="#696cff" xlink:href="#path-1"></use>
                                    <g id="Path-3" mask="url(#mask-2)">
                                        <use fill="#696cff" xlink:href="#path-3"></use>
                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                    </g>
                                    <g id="Path-4" mask="url(#mask-2)">
                                        <use fill="#696cff" xlink:href="#path-4"></use>
                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                    </g>
                                </g>
                                <g id="Triangle" transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                    <use fill="#696cff" xlink:href="#path-5"></use>
                                    <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg> --}}
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">ODA</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('admin') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        @can('user-list')
            <li class="menu-item {{ Request::is('users') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">Users</div>
                </a>
            </li>
        @endcan
        @can('role-list')
            <li class="menu-item {{ Request::is('roles') ? 'active' : '' }}">
                <a href="{{ route('roles.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-plus"></i>
                    <div data-i18n="Analytics">Roles</div>
                </a>
            </li>
        @endcan
        @can('news-list')
            <li class="menu-item {{ Request::is('news') ? 'active' : '' }}">
                <a href="{{ route('news.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-news"></i>
                    <div data-i18n="Analytics">News</div>
                </a>
            </li>
        @endcan
        @can('announcement-list')
            <li class="menu-item {{ Request::is('announcement') ? 'active' : '' }}">
                <a href="{{ route('announcement.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-microphone"></i>
                    <div data-i18n="Analytics">Announcements</div>
                </a>
            </li>
        @endcan
        @can('honorable-list')
            <li class="menu-item {{ Request::is('honorable') ? 'active' : '' }}">
                <a href="{{ route('honorable.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-medal"></i>
                    <div data-i18n="Analytics">Honorable</div>
                </a>
            </li>
        @endcan
        {{-- @can('organization-list') --}}

        {{-- @endcan --}}
        @can('abroad-list')
            <li class="menu-item {{ Request::is('abroad') ? 'active' : '' }}">
                <a href="{{ route('abroad.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-medal"></i>
                    <div data-i18n="Analytics">Abroad</div>
                </a>
            </li>
        @endcan
        @can('regional-list')
            <li class="menu-item {{ Request::is('regional') ? 'active' : '' }}">
                <a href="{{ route('regional.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-medal"></i>
                    <div data-i18n="Analytics">Regional</div>
                </a>
            </li>
        @endcan

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Member Payment</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('zoneMemberPay') ? 'active' : '' }}">
                    <a href="{{ route('zoneMemberPay.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-medal"></i>
                        <div data-i18n="Without menu">Zone Member Pay</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('cityMemberPay') ? 'active' : '' }}">
                    <a href="{{ route('cityMemberPay.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-medal"></i>
                        <div data-i18n="Without menu">City Member Pay</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('regionMemberPay') ? 'active' : '' }}">
                    <a href="{{ route('regionMemberPay.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-medal"></i>
                        <div data-i18n="Without menu">Region Member Pay</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('abroadMemberPay') ? 'active' : '' }}">
                    <a href="{{ route('abroadMemberPay.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-medal"></i>
                        <div data-i18n="Without menu">Abroad Member Pay</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('honorableMemberPay') ? 'active' : '' }}">
                    <a href="{{ route('honorableMemberPay.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-medal"></i>
                        <div data-i18n="Without menu">Honorable Member Pay</div>
                    </a>
                </li>


            </ul>
        </li>


        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Organizations</div>
            </a>

            <ul class="menu-sub">
                @can('arsii-list')
                    <li class="menu-item  {{ Request::is('arsii') ? 'active' : '' }}">
                        <a href="{{ route('arsii.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Arsii</div>
                        </a>
                    </li>
                @endcan

                @can('arsii_lixaa-list')
                    <li class="menu-item  {{ Request::is('arsii_lixaa') ? 'active' : '' }}">
                        <a href="{{ route('arsii_lixaa.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Arsii Lixaa</div>
                        </a>
                    </li>
                @endcan

                @can('baalee-list')
                    <li class="menu-item  {{ Request::is('baalee') ? 'active' : '' }}">
                        <a href="{{ route('baalee.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Baalee</div>
                        </a>
                    </li>
                @endcan
                @can('baalee_bahaa-list')
                    <li class="menu-item  {{ Request::is('baalee_bahaa') ? 'active' : '' }}">
                        <a href="{{ route('baalee_bahaa.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Baalee Bahaa</div>
                        </a>
                    </li>
                @endcan


                
                @can('booranaa-list')
                    <li class="menu-item  {{ Request::is('booranaa') ? 'active' : '' }}">
                        <a href="{{ route('booranaa.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Booranaa</div>
                        </a>
                    </li>
                @endcan

                 @can('buunnoo-list')
                    <li class="menu-item  {{ Request::is('buunnoo') ? 'active' : '' }}">
                        <a href="{{ route('buunnoo.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Buunnoo Beddellee</div>
                        </a>
                    </li>
                @endcan

                  @can('finfinnee-list')
                    <li class="menu-item  {{ Request::is('finfinnee') ? 'active' : '' }}">
                        <a href="{{ route('finfinnee.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Finfinnee</div>
                        </a>
                    </li>
                @endcan

                 @can('gujii-list')
                    <li class="menu-item  {{ Request::is('gujii') ? 'active' : '' }}">
                        <a href="{{ route('gujii.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Gujii</div>
                        </a>
                    </li>
                @endcan
                



                
                
                @can('gujii_lixaa-list')
                    <li class="menu-item  {{ Request::is('gujii_lixaa') ? 'active' : '' }}">
                        <a href="{{ route('gujii_lixaa.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Gujii Lixaa</div>
                        </a>
                    </li>
                @endcan
                 @can('h_bahaa-list')
                    <li class="menu-item  {{ Request::is('h_bahaa') ? 'active' : '' }}">
                        <a href="{{ route('h_bahaa.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Harargee Bahaa</div>
                        </a>
                    </li>
                @endcan
                 @can('h_lixaa-list')
                    <li class="menu-item  {{ Request::is('h_lixaa') ? 'active' : '' }}">
                        <a href="{{ route('h_lixaa.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Harargee Lixaa</div>
                        </a>
                    </li>
                @endcan


                @can('hoorroo-list')
                    <li class="menu-item  {{ Request::is('hoorroo') ? 'active' : '' }}">
                        <a href="{{ route('hoorroo.index') }}" class="menu-link">
                            <div data-i18n="Without menu">H/G/Wallaggaa</div>
                        </a>
                    </li>
                @endcan


                 @can('iluu-list')
                    <li class="menu-item  {{ Request::is('iluu') ? 'active' : '' }}">
                        <a href="{{ route('iluu.index') }}" class="menu-link">
                            <div data-i18n="Without menu">I/A/Booraa</div>
                        </a>
                    </li>
                @endcan


                @can('jimmaa-list')
                    <li class="menu-item  {{ Request::is('jimmaa') ? 'active' : '' }}">
                        <a href="{{ route('jimmaa.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Jimmaa</div>
                        </a>
                    </li>
                @endcan
                {{-- Add more organizations here as needed --}}
            </ul>
        </li>













        <!-- Layouts -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Zones</div>
            </a>

            <ul class="menu-sub">
                @can('zone1-list')
                    <li class="menu-item  {{ Request::is('zone1') ? 'active' : '' }}">
                        <a href="{{ route('zone1.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Arsii</div>
                        </a>
                    </li>
                @endcan
                @can('zone2-list')
                    <li class="menu-item  {{ Request::is('zone2') ? 'active' : '' }}">
                        <a href="{{ route('zone2.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Arsii-Lixaa</div>
                        </a>
                    </li>
                @endcan
                @can('zone3-list')
                    <li class="menu-item  {{ Request::is('zone3') ? 'active' : '' }}">
                        <a href="{{ route('zone3.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Baalee</div>
                        </a>
                    </li>
                @endcan
                @can('zone4-list')
                    <li class="menu-item  {{ Request::is('zone4') ? 'active' : '' }}">
                        <a href="{{ route('zone4.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Baalee-Bahaa</div>
                        </a>
                    </li>
                @endcan
                @can('zone5-list')
                    <li class="menu-item  {{ Request::is('zone5') ? 'active' : '' }}">
                        <a href="{{ route('zone5.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Booranaa</div>
                        </a>
                    </li>
                @endcan
                @can('zone6-list')
                    <li class="menu-item  {{ Request::is('zone6') ? 'active' : '' }}">
                        <a href="{{ route('zone6.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Bunno- Baddalle</div>
                        </a>
                    </li>
                @endcan
                @can('zone7-list')
                    <li class="menu-item  {{ Request::is('zone7') ? 'active' : '' }}">
                        <a href="{{ route('zone7.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Finfinnee</div>
                        </a>
                    </li>
                @endcan
                @can('zone8-list')
                    <li class="menu-item  {{ Request::is('zone8') ? 'active' : '' }}">
                        <a href="{{ route('zone8.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Gujii</div>
                        </a>
                    </li>
                @endcan
                @can('zone9-list')
                    <li class="menu-item  {{ Request::is('zone9') ? 'active' : '' }}">
                        <a href="{{ route('zone9.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Gujii-Lixaa</div>
                        </a>
                    </li>
                @endcan
                @can('zone10-list')
                    <li class="menu-item  {{ Request::is('zone10') ? 'active' : '' }}">
                        <a href="{{ route('zone10.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Harargee-Bahaa</div>

                        </a>
                    </li>
                @endcan
                @can('zone11-list')
                    <li class="menu-item  {{ Request::is('zone11') ? 'active' : '' }}">
                        <a href="{{ route('zone11.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Harargee-Lixaa</div>
                        </a>
                    </li>
                @endcan
                @can('zone12-list')
                    <li class="menu-item  {{ Request::is('zone12') ? 'active' : '' }}">
                        <a href="{{ route('zone12.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Horroo-Guduruu-Wallaga</div>
                        </a>
                    </li>
                @endcan
                @can('zone13-list')
                    <li class="menu-item  {{ Request::is('zone13') ? 'active' : '' }}">
                        <a href="{{ route('zone13.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Iluu-Abbaa-Booraa</div>
                        </a>
                    </li>
                @endcan
                @can('zone14-list')
                    <li class="menu-item  {{ Request::is('zone14') ? 'active' : '' }}">
                        <a href="{{ route('zone14.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Jimmaa</div>
                        </a>
                    </li>
                @endcan
                @can('zone15-list')
                    <li class="menu-item  {{ Request::is('zone15') ? 'active' : '' }}">
                        <a href="{{ route('zone15.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Qeellam-Wallaga</div>
                        </a>
                    </li>
                @endcan
                @can('zone16-list')
                    <li class="menu-item  {{ Request::is('zone16') ? 'active' : '' }}">
                        <a href="{{ route('zone16.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Shawaa-Bahaa</div>
                        </a>
                    </li>
                @endcan
                @can('zone17-list')
                    <li class="menu-item  {{ Request::is('zone17') ? 'active' : '' }}">
                        <a href="{{ route('zone17.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Shawaa-Kaabaa</div>
                        </a>
                    </li>
                @endcan
                @can('zone18-list')
                    <li class="menu-item  {{ Request::is('zone18') ? 'active' : '' }}">
                        <a href="{{ route('zone18.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Shawaa-Kibbaaa-Lixaa</div>
                        </a>
                    </li>
                @endcan

                @can('zone19-list')
                    <li class="menu-item  {{ Request::is('zone19') ? 'active' : '' }}">
                        <a href="{{ route('zone19.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Shawaa-Lixaa</div>
                        </a>
                    </li>
                @endcan
                @can('zone20-list')
                    <li class="menu-item  {{ Request::is('zone20') ? 'active' : '' }}">
                        <a href="{{ route('zone20.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Wallaga-Bahaa</div>
                        </a>
                    </li>
                @endcan
                @can('zone21-list')
                    <li class="menu-item  {{ Request::is('zone21') ? 'active' : '' }}">
                        <a href="{{ route('zone21.index') }}" class="menu-link">
                            <div data-i18n="Without menu">Wallaga-Lixaa</div>
                        </a>
                    </li>
                @endcan

            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-city"></i>
                <div data-i18n="Layouts">Cities</div>
            </a>
            <ul class="menu-sub">
                @can('city1-list')
                    <li class="menu-item  {{ Request::is('city1') ? 'active' : '' }}">
                        <a href="{{ route('city1.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Adaamaa</div>
                        </a>
                    </li>
                @endcan
                @can('city2-list')
                    <li class="menu-item  {{ Request::is('city2') ? 'active' : '' }}">
                        <a href="{{ route('city2.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Amboo</div>
                        </a>
                    </li>
                @endcan
                @can('city3-list')
                    <li class="menu-item  {{ Request::is('city3') ? 'active' : '' }}">
                        <a href="{{ route('city3.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Asallaa</div>
                        </a>
                    </li>
                @endcan
                @can('city4-list')
                    <li class="menu-item  {{ Request::is('city4') ? 'active' : '' }}">
                        <a href="{{ route('city4.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Baatuu</div>
                        </a>
                    </li>
                @endcan
                @can('city5-list')
                    <li class="menu-item  {{ Request::is('city5') ? 'active' : '' }}">
                        <a href="{{ route('city5.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Bishooftuu</div>
                        </a>
                    </li>
                @endcan
                @can('city6-list')
                    <li class="menu-item  {{ Request::is('city6') ? 'active' : '' }}">
                        <a href="{{ route('city6.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Buraayyuu</div>
                        </a>
                    </li>
                @endcan
                @can('city7-list')
                    <li class="menu-item  {{ Request::is('city7') ? 'active' : '' }}">
                        <a href="{{ route('city7.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Dukam</div>
                        </a>
                    </li>
                @endcan
                @can('city8-list')
                    <li class="menu-item  {{ Request::is('city8') ? 'active' : '' }}">
                        <a href="{{ route('city8.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Finfinnee</div>
                        </a>
                    </li>
                @endcan
                @can('city9-list')
                    <li class="menu-item  {{ Request::is('city9') ? 'active' : '' }}">
                        <a href="{{ route('city9.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Galaan</div>
                        </a>
                    </li>
                @endcan
                @can('city10-list')
                    <li class="menu-item  {{ Request::is('city10') ? 'active' : '' }}">
                        <a href="{{ route('city10.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Hoolotaa</div>
                        </a>
                    </li>
                @endcan
                @can('city11-list')
                    <li class="menu-item  {{ Request::is('city11') ? 'active' : '' }}">
                        <a href="{{ route('city11.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Jimmaa</div>
                        </a>
                    </li>
                @endcan
                @can('city12-list')
                    <li class="menu-item  {{ Request::is('city12') ? 'active' : '' }}">
                        <a href="{{ route('city12.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-L_Xaafoo</div>
                        </a>
                    </li>
                @endcan
                @can('city13-list')
                    <li class="menu-item  {{ Request::is('city13') ? 'active' : '' }}">
                        <a href="{{ route('city13.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Mojoo</div>
                        </a>
                    </li>
                @endcan
                @can('city14-list')
                    <li class="menu-item  {{ Request::is('city14') ? 'active' : '' }}">
                        <a href="{{ route('city14.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Naqamtee</div>
                        </a>
                    </li>
                @endcan
                @can('city15-list')
                    <li class="menu-item  {{ Request::is('city15') ? 'active' : '' }}">
                        <a href="{{ route('city15.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Roobee</div>
                        </a>
                    </li>
                @endcan
                @can('city16-list')
                    <li class="menu-item  {{ Request::is('city16') ? 'active' : '' }}">
                        <a href="{{ route('city16.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Shaashaamannee</div>
                        </a>
                    </li>
                @endcan
                @can('city17-list')
                    <li class="menu-item  {{ Request::is('city17') ? 'active' : '' }}">
                        <a href="{{ route('city17.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Sabbaataa</div>
                        </a>
                    </li>
                @endcan
                @can('city18-list')
                    <li class="menu-item  {{ Request::is('city18') ? 'active' : '' }}">
                        <a href="{{ route('city18.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Sulultaa</div>
                        </a>
                    </li>
                @endcan
                @can('city19-list')
                    <li class="menu-item  {{ Request::is('city19') ? 'active' : '' }}">
                        <a href="{{ route('city19.index') }}" class="menu-link">
                            <div data-i18n="Without menu">B-M-Walisoo</div>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-city"></i>
                <div data-i18n="Layouts">Report</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item  {{ Request::is('zoneMember-index') ? 'active' : '' }}">
                    <a href="{{ route('zoneMember.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Zone Member</div>
                    </a>
                </li>
                <li class="menu-item  {{ Request::is('zoneMemberFee-index') ? 'active' : '' }}">
                    <a href="{{ route('zoneMemberFee.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Zone Member's Fee</div>
                    </a>
                </li>

                <li class="menu-item  {{ Request::is('cityMember-index') ? 'active' : '' }}">
                    <a href="{{ route('cityMember.index') }}" class="menu-link">
                        <div data-i18n="Without menu">City Member</div>
                    </a>
                </li>
                <li class="menu-item  {{ Request::is('cityMemberFee-index') ? 'active' : '' }}">
                    <a href="{{ route('cityMemberFee.index') }}" class="menu-link">
                        <div data-i18n="Without menu">City Member's Fee</div>
                    </a>
                </li>

                <li class="menu-item  {{ Request::is('regionMember-index') ? 'active' : '' }}">
                    <a href="{{ route('regionMember.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Regional Member</div>
                    </a>
                </li>
                <li class="menu-item  {{ Request::is('regionMemberFee-index') ? 'active' : '' }}">
                    <a href="{{ route('regionMemberFee.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Regional Member's Fee</div>
                    </a>
                </li>



            </ul>
        </li>
    </ul>
</aside>
