<div id="sidebar-menu">
    <ul class="metismenu list-unstyled" id="side-menu">
        @foreach (\App\Helpers\Menu::generateUserMenu(Auth::user()->role_id) as $menu)
        @if (isset($menu['submenus']))
        <li><a href="javascript: void(0);" class="has-arrow"><i
                    data-feather="{{ $menu['icon'] }}"></i><span>{{ $menu['title'] }}</span></a>
            <ul class="sub-menu" aria-expanded="false">
                @foreach ($menu['submenus'] as $submenu)
                <li><a href="{{ url($submenu['slug']) }}"><span>{{ $submenu['title'] }}</span></a></li>
                @endforeach
            </ul>
        </li>
        @else
        <li>
            <a href="{{ url($menu['slug']) }}"><i
                    data-feather="{{ $menu['icon'] }}"></i><span>{{ $menu['title'] }}</span></a>
        </li>
        @endif
        @endforeach
    </ul>
    <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5">
        <div class="card-body">
            <div class="mt-4">
                <h5 class="alertcard-title font-size-16">10120764</h5>
                <p class="font-size-13">Fajar Buana Hidayat</p>
            </div>
        </div>
    </div>
</div>
