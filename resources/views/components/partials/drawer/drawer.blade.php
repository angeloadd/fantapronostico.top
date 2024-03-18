<div class="flex w-full justify-center items-center">
    <div class="drawer text-neutral bg-accent w-[80%] rounded-mdxl p-2">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle"/>
        <div class="drawer-content flex flex-col items-center justify-center">
            <!-- Navbar -->
            <div class="w-full navbar bg-base-300 rounded-mdxl">
                <div class="flex-none lg:hidden">
                    <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                <header class="navbar-start px-4">
                    <a href="{{route('home')}}" class="flex items-center justify-center">
                        <svg
                            id="logo"
                            class="w-6 fill-neutral"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 224 352"
                        >
                            <path
                                d="
M56.800804,214.111481
	C46.350883,196.040085 37.403053,177.764801 31.596796,157.939987
	C21.087227,122.056244 31.986931,84.864677 60.647041,61.052799
	C98.596970,29.522602 158.855301,37.028263 188.177261,76.734886
	C209.175537,105.169922 210.177872,135.748642 199.582672,168.195435
	C193.095078,188.063110 182.053726,205.485977 172.008621,223.465820
	C154.880890,254.123001 137.492462,284.634583 120.187172,315.192413
	C119.392403,316.595795 119.016808,318.350525 116.263428,319.652557
	C96.522461,284.619385 76.748039,249.526871 56.800804,214.111481
M112.657356,65.204437
	C101.239822,65.704445 90.654274,69.100212 81.305359,75.518372
	C63.109180,88.010315 52.421192,105.051781 51.267002,127.511559
	C50.457840,143.257324 54.875183,157.939911 61.539604,171.784012
	C77.426239,204.785553 96.519142,236.068771 114.298683,268.055725
	C114.962624,269.250214 115.390343,270.952545 117.547050,271.109711
	C118.291519,269.953186 119.154922,268.751465 119.876480,267.469879
	C129.348587,250.645538 138.965591,233.899887 148.210968,216.951599
	C157.285767,200.315994 168.253159,184.647873 174.820435,166.718216
	C180.752075,150.523880 185.029449,134.106720 181.211182,116.520454
	C174.657806,86.336761 145.658386,62.796021 112.657356,65.204437
z"/>
                            <path
                                d="
M153.417175,88.517250
	C166.267059,99.620628 172.868851,113.624695 173.100327,129.976654
	C173.443954,154.250931 159.899094,175.363205 136.034821,183.795334
	C105.638710,194.535416 74.066185,178.924515 63.666843,148.537384
	C52.375927,115.545052 75.531929,79.222862 109.924934,75.575211
	C126.212898,73.847740 140.506699,78.046028 153.417175,88.517250
M93.377823,121.099113
	C99.650528,125.653320 104.649780,123.209846 109.223915,118.250580
	C109.895531,117.522408 110.731102,116.944626 111.496170,116.303642
	C114.756264,113.572235 116.460655,101.853912 113.526848,98.950111
	C109.884964,95.345467 105.658226,92.327660 101.645432,89.104523
	C100.587219,88.254547 99.500549,88.747948 98.384247,89.259415
	C92.556602,91.929527 87.441315,95.544540 83.309479,100.473541
	C82.475113,101.468880 80.995338,102.584526 81.594719,103.877861
	C84.452614,110.044586 83.983704,118.463791 93.377823,121.099113
M159.519119,147.993439
	C164.874664,136.065170 164.167618,133.622894 153.313416,126.692657
	C152.054810,125.889069 150.736511,125.179535 149.464920,124.395531
	C148.574677,123.846649 147.698380,123.560341 146.650421,123.990685
	C139.634888,126.871567 131.883713,128.911377 131.349091,138.647552
	C131.251526,140.424805 130.463135,142.183350 129.868484,143.907364
	C129.466919,145.071579 129.299057,146.145798 129.967529,147.245071
	C134.458374,154.629990 140.833221,157.156021 149.564011,156.927002
	C156.025314,156.757553 156.998596,152.574265 159.519119,147.993439
M146.586426,118.097580
	C154.541977,101.792824 155.860260,102.585205 141.125900,92.319679
	C139.372940,91.098381 137.336792,90.279877 135.418365,89.301239
	C134.373825,88.768379 133.187683,88.129524 132.178802,89.113037
	C126.507454,94.641747 117.616150,98.127182 119.967903,108.762642
	C120.523766,111.276459 119.798958,113.960205 122.127541,116.090508
	C131.552841,124.713287 132.038544,124.841415 143.669449,119.442215
	C144.420822,119.093407 145.200073,118.804657 146.586426,118.097580
M104.497971,145.301468
	C103.738922,142.939713 102.641983,140.628067 102.282837,138.206985
	C101.104431,130.263214 95.696442,126.887825 88.734665,124.892433
	C84.884567,123.788902 72.021042,131.216278 71.447113,135.031738
	C71.398476,135.355103 71.397690,135.702713 71.458817,136.023010
	C72.672729,142.383987 74.170120,148.638962 77.697533,154.220337
	C78.782524,155.937119 80.183517,156.425278 82.173203,156.714966
	C92.071487,158.156174 99.123924,154.007492 104.497971,145.301468
M129.288422,154.213455
	C125.288010,147.960648 118.978241,149.287201 113.089935,149.319809
	C109.885406,149.337555 100.874756,155.962646 100.784752,158.997574
	C100.641190,163.838165 102.643326,168.406845 104.256706,172.907425
	C105.307617,175.838928 108.643410,175.624008 111.139908,176.196182
	C115.060371,177.094727 119.082367,176.954987 123.043701,176.279205
	C126.652870,175.663483 130.516785,175.299210 131.221207,170.501175
	C132.010544,165.124832 136.643143,159.410080 129.288422,154.213455
M126.099838,141.667175
	C127.171158,138.179520 128.338135,134.717606 129.285690,131.196640
	C130.155502,127.964630 119.933098,117.854210 116.755966,118.706657
	C116.449203,118.788963 116.194351,119.052597 115.904770,119.212845
	C105.930191,124.732765 104.351158,128.595642 107.799301,139.049576
	C109.878189,145.352264 120.944870,147.411987 126.099838,141.667175
z"/>
                        </svg>
                        <h2 class="text-2xl font-bold">Fantapronostico</h2>
                    </a>
                </header>
                <div class="hidden lg:flex navbar-center">
                    <ul class="menu menu-horizontal">
                        <!-- Navbar menu content here -->
                        <li><a>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z"/>
                                </svg>
                                Pronostico</a></li>
                        <li><a>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605"/>
                                </svg>
                                Classifica</a></li>
                        <li><a>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/>
                                </svg>
                                Vincente</a></li>
                        <li><a>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0"/>
                                </svg>
                                Albo D'Oro</a></li>

                    </ul>
                </div>
                <div class="hidden lg:flex navbar-end text-neutral">
                    <ul class="menu menu-horizontal space-x-2">
                        <!-- Navbar menu content here -->
                        @auth
                            <li>

                                <details>
                                    <summary>
                                        {{Auth::user()->name}}
                                    </summary>
                                    <ul class="p-2 w-40 rounded bg-base-300 text-neutral">
                                        <li>
                                            <form action="{{route('api.logout')}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </details>
                            </li>
                        @else
                            <a href="{{route('register')}}" class="btn btn-accent hover:bg-base-300 hover:text-accent">Register</a>
                            <a href="{{route('login')}}" class="btn btn-accent hover:bg-base-300 hover:text-accent">Login</a>
                        @endauth
                    </ul>
                </div>
            </div>
            <!-- Page content here -->
            <div class="text-neutral grid grid-cols-3 grid-row-span-12-12">
                {{$slot}}
            </div>
        </div>
        <div class="drawer-side">
            <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu p-8 w-80 min-h-full bg-accent">
                <!-- Sidebar content here -->
                <li class="text-lg py-3"><a>⚽️ Pronostico</a></li>
                <li class="text-lg py-3"><a>📈 Classifica</a></li>
                <li class="text-lg py-3"><a>🏆 Vincente</a></li>
                <li class="text-lg py-3"><a>👑 Albo D'Oro</a></li>
                <div class="divider"></div>
                @auth
                    <li>
                        <details>
                            <summary>
                                {{Auth::user()->name}}
                            </summary>
                            <ul class="p-2 bg-base-100 rounded-t-none">
                                <li><a>Link 1</a></li>
                                <li><a>Link 2</a></li>
                            </ul>
                        </details>
                    </li>
                @else
                    <li class="text-lg py-3"><a>Login</a></li>
                    <li class="text-lg py-3"><a>Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</div>
