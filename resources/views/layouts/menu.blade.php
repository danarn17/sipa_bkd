<li class="side-menus {{ Request::is('dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('dashboard') }}">
        <i class=" fas fa-building"></i><span>Dashboard</span>
    </a>
</li>
<li class="menu-header">Data</li>
<li class="side-menus {{ Request::is('pencairan.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('pencairan.index') }}">
        <i class="fas fa-history"></i><span>Pencairan</span>
    </a>
</li>
<li class="side-menus {{ Request::is('penyerapan.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('penyerapan.index') }}">
        <i class="fas fa-credit-card"></i><span>Penyerapan</span>
    </a>
</li>
<li class="side-menus {{ Request::is('subkeg.*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('subkeg.index') }}">
        <i class="fas fa-tasks"></i><span>Sub Kegiatan</span>
    </a>
</li>
<li class="side-menus {{ Request::is('rekening') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('rekening.index') }}">
        <i class="fas fa-money-bill"></i><span>Rekening</span>
    </a>
</li>
<li class="side-menus {{ Request::is('anggaran') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('anggaran.index') }}">
        <i class=" fas fa-dollar-sign"></i><span>Anggaran</span>
    </a>
</li>
{{-- <li class="side-menus {{ Request::is('childsubkegiatan') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('childsubkegiatan.index') }}">
        <i class=" fas fa-egg"></i><span>Sub Sub Kegiatan</span>
    </a>
</li> --}}
