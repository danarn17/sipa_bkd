<li class="side-menus {{ Request::is('dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dashboard') }}">
        <i class=" fas fa-building"></i><span>Dashboard</span>
    </a>
</li>
<li class="menu-header">Data Data</li>
<li class="side-menus {{ Request::is('rekening') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('rekening.index') }}">
        <i class=" fas fa-egg"></i><span>Rekening</span>
    </a>
</li>
<li class="side-menus {{ Request::is('childsubkegiatan') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('childsubkegiatan.index') }}">
        <i class=" fas fa-egg"></i><span>Sub Sub Kegiatan</span>
    </a>
</li>
<li class="side-menus {{ Request::is('subkeg.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('subkeg.index') }}">
        <i class=" fas fa-paint-brush"></i><span>Sub Kegiatan</span>
    </a>
</li>
