<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="<?php echo e(asset('front/images/logo (1).png')); ?>" height="30em" width="30em">
                
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
        <li class="menu-item <?php echo e(Request::is('admin') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('dashboard')); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
         <li class="menu-item <?php echo e(Request::is('dashboard2') ? 'active' : ''); ?>">
            <a href="<?php echo e(route('dashboard2.index')); ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard-2</div>
            </a>
        </li>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user-list')): ?>
            <li class="menu-item <?php echo e(Request::is('users') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('users.index')); ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Analytics">Users</div>
                </a>
            </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role-list')): ?>
            <li class="menu-item <?php echo e(Request::is('roles') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('roles.index')); ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-plus"></i>
                    <div data-i18n="Analytics">Roles</div>
                </a>
            </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('news-list')): ?>
            <li class="menu-item <?php echo e(Request::is('news') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('news.index')); ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-news"></i>
                    <div data-i18n="Analytics">News</div>
                </a>
            </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('announcement-list')): ?>
            <li class="menu-item <?php echo e(Request::is('announcement') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('announcement.index')); ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-microphone"></i>
                    <div data-i18n="Analytics">Announcements</div>
                </a>
            </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('honorable-list')): ?>
            <li class="menu-item <?php echo e(Request::is('honorable') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('honorable.index')); ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-medal"></i>
                    <div data-i18n="Analytics">Honorable</div>
                </a>
            </li>
        <?php endif; ?>
        

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('abroad-list')): ?>
            <li class="menu-item <?php echo e(Request::is('abroad') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('abroad.index')); ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-medal"></i>
                    <div data-i18n="Analytics">Abroad</div>
                </a>
            </li>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('regional-list')): ?>
            <li class="menu-item <?php echo e(Request::is('regional') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('regional.index')); ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-medal"></i>
                    <div data-i18n="Analytics">Regional</div>
                </a>
            </li>
        <?php endif; ?>

                    <li class="menu-item <?php echo e(Request::is('project') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('project.index')); ?>" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-medal"></i>
                    <div data-i18n="Analytics">Projects</div>
                </a>
            </li>

        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Member Payment</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item <?php echo e(Request::is('zoneMemberPay') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('zoneMemberPay.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-medal"></i>
                        <div data-i18n="Without menu">Zone Member Pay</div>
                    </a>
                </li>
                <li class="menu-item <?php echo e(Request::is('cityMemberPay') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('cityMemberPay.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-medal"></i>
                        <div data-i18n="Without menu">City Member Pay</div>
                    </a>
                </li>
                <li class="menu-item <?php echo e(Request::is('regionMemberPay') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('regionMemberPay.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-medal"></i>
                        <div data-i18n="Without menu">Region Member Pay</div>
                    </a>
                </li>
                <li class="menu-item <?php echo e(Request::is('abroadMemberPay') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('abroadMemberPay.index')); ?>" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-medal"></i>
                        <div data-i18n="Without menu">Abroad Member Pay</div>
                    </a>
                </li>
                <li class="menu-item <?php echo e(Request::is('honorableMemberPay') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('honorableMemberPay.index')); ?>" class="menu-link">
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
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('arsii-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('arsii') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('arsii.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Arsii</div>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('arsii_lixaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('arsii_lixaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('arsii_lixaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Arsii Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('baalee-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('baalee') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('baalee.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Baalee</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('baalee_bahaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('baalee_bahaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('baalee_bahaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Baalee Bahaa</div>
                        </a>
                    </li>
                <?php endif; ?>


                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('booranaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('booranaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('booranaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Booranaa</div>
                        </a>
                    </li>
                <?php endif; ?>

                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('buunnoo-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('buunnoo') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('buunnoo.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Buunnoo Beddellee</div>
                        </a>
                    </li>
                <?php endif; ?>

                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('finfinnee-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('finfinnee') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('finfinnee.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Finfinnee</div>
                        </a>
                    </li>
                <?php endif; ?>

                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gujii-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('gujii') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('gujii.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Gujii</div>
                        </a>
                    </li>
                <?php endif; ?>
                



                
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('gujii_lixaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('gujii_lixaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('gujii_lixaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Gujii Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('h_bahaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('h_bahaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('h_bahaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Harargee Bahaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('h_lixaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('h_lixaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('h_lixaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Harargee Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('hoorroo-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('hoorroo') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('hoorroo.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">H/G/Wallaggaa</div>
                        </a>
                    </li>
                <?php endif; ?>


                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('iluu-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('iluu') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('iluu.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">I/A/Booraa</div>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('jimmaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('jimmaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('jimmaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Jimmaa</div>
                        </a>
                    </li>
                <?php endif; ?>

                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('qeellam-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('qeellam') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('qeellam.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Qeellam Wallaggaa</div>
                        </a>
                    </li>
                <?php endif; ?>

                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sh_bahaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('sh_bahaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('sh_bahaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Shawaa Bahaa</div>
                        </a>
                    </li>
                <?php endif; ?>

                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sh_kaabaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('sh_kaabaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('sh_kaabaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Shawaa Kaabaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sh_k_lixaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('sh_k_lixaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('sh_k_lixaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Sh/K/Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>

                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sh_lixaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('sh_lixaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('sh_lixaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Shawaa Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('w_bahaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('w_bahaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('w_bahaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Wallagga Bahaa</div>
                        </a>
                    </li>
                <?php endif; ?>

                  <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('w_lixaa-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('w_lixaa') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('w_lixaa.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Wallagga Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                
                
            </ul>
        </li>













        <!-- Layouts -->
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Zones</div>
            </a>

            <ul class="menu-sub">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone1-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone1') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone1.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Arsii</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone2-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone2') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone2.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Arsii-Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone3-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone3') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone3.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Baalee</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone4-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone4') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone4.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Baalee-Bahaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone5-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone5') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone5.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Booranaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone6-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone6') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone6.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Bunno- Baddalle</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone7-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone7') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone7.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Finfinnee</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone8-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone8') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone8.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Gujii</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone9-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone9') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone9.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Gujii-Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone10-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone10') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone10.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Harargee-Bahaa</div>

                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone11-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone11') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone11.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Harargee-Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone12-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone12') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone12.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Horroo-Guduruu-Wallaga</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone13-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone13') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone13.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Iluu-Abbaa-Booraa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone14-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone14') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone14.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Jimmaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone15-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone15') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone15.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Qeellam-Wallaga</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone16-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone16') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone16.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Shawaa-Bahaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone17-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone17') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone17.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Shawaa-Kaabaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone18-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone18') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone18.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Shawaa-Kibbaaa-Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone19-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone19') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone19.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Shawaa-Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone20-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone20') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone20.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Wallaga-Bahaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zone21-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('zone21') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('zone21.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">Wallaga-Lixaa</div>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-city"></i>
                <div data-i18n="Layouts">Cities</div>
            </a>
            <ul class="menu-sub">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city1-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city1') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city1.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Adaamaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city2-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city2') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city2.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Amboo</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city3-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city3') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city3.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Asallaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city4-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city4') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city4.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Baatuu</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city5-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city5') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city5.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Bishooftuu</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city6-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city6') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city6.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Buraayyuu</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city7-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city7') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city7.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Dukam</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city8-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city8') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city8.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Finfinnee</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city9-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city9') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city9.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Galaan</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city10-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city10') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city10.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Hoolotaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city11-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city11') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city11.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Jimmaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city12-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city12') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city12.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-L_Xaafoo</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city13-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city13') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city13.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Mojoo</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city14-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city14') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city14.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Naqamtee</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city15-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city15') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city15.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Roobee</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city16-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city16') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city16.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Shaashaamannee</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city17-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city17') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city17.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Sabbaataa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city18-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city18') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city18.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Sulultaa</div>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('city19-list')): ?>
                    <li class="menu-item  <?php echo e(Request::is('city19') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('city19.index')); ?>" class="menu-link">
                            <div data-i18n="Without menu">B-M-Walisoo</div>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-city"></i>
                <div data-i18n="Layouts">Report</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item  <?php echo e(Request::is('zoneMember-index') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('zoneMember.index')); ?>" class="menu-link">
                        <div data-i18n="Without menu">Zone Member</div>
                    </a>
                </li>
                <li class="menu-item  <?php echo e(Request::is('zoneMemberFee-index') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('zoneMemberFee.index')); ?>" class="menu-link">
                        <div data-i18n="Without menu">Zone Member's Fee</div>
                    </a>
                </li>

                <li class="menu-item  <?php echo e(Request::is('cityMember-index') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('cityMember.index')); ?>" class="menu-link">
                        <div data-i18n="Without menu">City Member</div>
                    </a>
                </li>
                <li class="menu-item  <?php echo e(Request::is('cityMemberFee-index') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('cityMemberFee.index')); ?>" class="menu-link">
                        <div data-i18n="Without menu">City Member's Fee</div>
                    </a>
                </li>

                <li class="menu-item  <?php echo e(Request::is('regionMember-index') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('regionMember.index')); ?>" class="menu-link">
                        <div data-i18n="Without menu">Regional Member</div>
                    </a>
                </li>
                <li class="menu-item  <?php echo e(Request::is('regionMemberFee-index') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('regionMemberFee.index')); ?>" class="menu-link">
                        <div data-i18n="Without menu">Regional Member's Fee</div>
                    </a>
                </li>



            </ul>
        </li>
    </ul>
</aside>
<?php /**PATH C:\Users\ODA-IT\Documents\GitHub\ODA-Membership\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>