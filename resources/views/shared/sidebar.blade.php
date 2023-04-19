<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        @if (auth()->user()->profile_photo)
                            <img src="{{ url('/storage') . auth()->user()->profile_photo }}" alt=""
                                style="width: 80px" class="rounded bg-white">
                        @else
                            <img class="rounded bg-white" src="{{ url('/img/user_placeholder.png') }}" alt=""
                                width="80px">
                        @endif


                        <span class="block m-t-xs font-bold">{{ auth()->user()->name }}</span>
                        <span class="text-muted text-xs block">menu <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">

                        <li>
                            <a class="dropdown-item" type="button" href="{{ route('profile') }}">
                                Mi perfil
                            </a>
                        </li>

                        @impersonating
                            <li>
                                <a class="dropdown-item" type="button" href="{{ route('impersonate.leave') }}">
                                    Salir del modo fantasma
                                </a>
                            </li>
                        @endImpersonating

                        @if (!session('impersonated_by'))
                            <li>
                                <a class="dropdown-item" type="button" onclick="$('#logout_form').submit()">Logout</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="logo-element">

                    @if (auth()->user()->profile_photo)
                        <img src="{{ url('/storage') . auth()->user()->profile_photo }}" alt=""
                            style="width: 80%" class="rounded bg-white">
                    @else
                        <img class="rounded bg-white" src="{{ url('/img/user_placeholder.png') }}" alt=""
                            style="width: 80%">
                    @endif

                </div>
            </li>

            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge-high"></i> <span
                        class="nav-label">{{ __('modules.dashboard') }}</span></a>
            </li>

            @hasrole('super-admin')

                <li class="{{ request()->is('customers*') ? 'active' : '' }}">
                    <a href="{{ route('customers.index') }}"><i class="fa-solid fa-user-tie"></i> <span
                            class="nav-label">{{ __('modules.customers') }}</span></a>
                </li>

                <li class="{{ request()->is('modules*') ? 'active' : '' }}">
                    <a href="{{ route('modules.index') }}"><i class="fa-solid fa-puzzle-piece"></i> <span
                            class="nav-label">{{ __('modules.modules') }}</span></a>
                </li>

                <li class="{{ request()->is('blog*') ? 'active' : '' }}">
                    <a href="{{ route('blog.index') }}"><i class="fa-solid fa-blog"></i> <span
                            class="nav-label">{{ __('modules.blog') }}</span></a>
                </li>

                <li class="{{ request()->is('sga*') ? 'active' : '' }}">
                    <a href="{{ route('sga.index') }}">
                        <i class="fa fa-cubes" aria-hidden="true"></i>
                        <span class="nav-label">{{ __('modules.sga') }}</span>
                    </a>
                </li>
            @else
                @hasrole('customer-manager')

                    @if (request()->is('branches*') || request()->is('departaments*') || request()->is('users*'))
                        <li class="active">

                            <a href="#" aria-expanded="true">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                                <span class="nav-label">{{ __('modules.configuration') }}</span>
                                <span class="fa arrow"></span>
                            </a>

                            <ul class="nav nav-second-level collapse in" aria-expanded="true" style="">

                                <li class="{{ request()->is('branches*') ? 'active' : '' }}">
                                    <a href="{{ route('branches.index') }}">
                                        <i class="fa-solid fa-building"></i>
                                        {{ __('modules.branches') }}
                                    </a>
                                </li>


                                <li class="{{ request()->is('departaments*') ? 'active' : '' }}">
                                    <a href="{{ route('departaments.index') }}">

                                        <i class="fa-solid fa-diagram-predecessor"></i>
                                        {{ __('modules.departaments') }}
                                    </a>
                                </li>


                                <li class="{{ request()->is('users*') ? 'active' : '' }}">
                                    <a href="{{ route('users.index') }}">
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                        {{ __('modules.users') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li>

                            <a href="#" aria-expanded="false">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                                <span class="nav-label">{{ __('modules.configuration') }}</span>
                                <span class="fa arrow"></span>
                            </a>

                            <ul class="nav nav-second-level collapse" aria-expanded="false" style="">

                                <li class="{{ request()->is('branches*') ? 'active' : '' }}">
                                    <a href="{{ route('branches.index') }}">
                                        <i class="fa-solid fa-building"></i>
                                        {{ __('modules.branches') }}
                                    </a>
                                </li>


                                <li class="{{ request()->is('departaments*') ? 'active' : '' }}">
                                    <a href="{{ route('departaments.index') }}">

                                        <i class="fa-solid fa-diagram-predecessor"></i>
                                        {{ __('modules.departaments') }}
                                    </a>
                                </li>


                                <li class="{{ request()->is('users*') ? 'active' : '' }}">
                                    <a href="{{ route('users.index') }}">
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                        {{ __('modules.users') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                @endhasrole

            @endhasrole

            @unlessrole('super-admin')
                @can('read Teams')
                    <li class="{{ request()->is('teams*') ? 'active' : '' }}">
                        <a href="{{ route('teams.index') }}">
                            <i class="fas fa-user-friends    "></i>
                            <span class="nav-label">{{ __('modules.teams') }}</span>
                            <span id="notifications_teams" class="animated fadeIn label bg-primary float-right d-none">
                            </span>
                        </a>
                    </li>
                @endcan

                @can('read Ods')
                    <li class="{{ request()->is('ods*') ? 'active' : '' }}">
                        <a href="{{ route('ods.index') }}">
                            <i class="fa fa-bullseye" aria-hidden="true"></i>
                            <span class="nav-label">{{ __('modules.ods') }}</span>
                        </a>
                    </li>
                @endcan

                @can('read Tareas')
                    <li class="{{ request()->is('tasks*') ? 'active' : '' }}">
                        <a href="{{ route('tasks.index') }}">
                            <i class="fa-solid fa-list-check"></i>
                            <span class="nav-label">{{ __('modules.tasks') }}</span>
                        </a>
                    </li>
                @endcan

                @can('read Vigilancia Ambiental')
                    <li class="{{ request()->is('vao*') ? 'active' : '' }}">
                        <a href="{{ route('vao.index') }}">
                            <i class="fa-solid fa-helmet-safety"></i>
                            <span class="nav-label">{{ __('modules.vao') }}</span>
                        </a>
                    </li>
                @endcan

                @can('read SGA')
                    <li class="{{ request()->is('sga*') ? 'active' : '' }}">
                        <a href="{{ route('sga.index') }}">
                            <i class="fa fa-cubes" aria-hidden="true"></i>
                            <span class="nav-label">{{ __('modules.sga') }}</span>
                        </a>
                    </li>
                @endcan


                <li>
                    <a href="https://vigilanciaambiental.com" target="_blank">

                        <i class="fa-solid fa-helmet-safety"></i>
                        <span class="nav-label">{{ __('modules.vao') }}</span>

                    </a>
                </li>

                <li>
                    <a href="https://account.calculatuhuelladecarbono.com" target="_blank">

                        <i class="fa-solid fa-shoe-prints"></i>
                        <span class="nav-label">Huella de carbono</span>
                    </a>
                </li>
            @endunlessrole


        </ul>

    </div>
</nav>
