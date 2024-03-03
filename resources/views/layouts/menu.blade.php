@php
$admin = auth()->user()->isAdmin();
$pembimbing = auth()->user()->isPembimbing();
$pic = auth()->user()->isPIC();
$penguji = auth()->user()->isPenguji();
$student = auth()->user()->isStudent();
$superadmin = auth()->user()->isSuperadmin();
$ppm = auth()->user()->isPpm();
@endphp

<style>
    /* .sidebar-minimized .sidebar .nav-dropdown-items .nav-item:hover{
        background: red
    } */

    .sidebar-minimized .sidebar .nav-link.active {
        color: white;
    }

    .sidebar-minimized .sidebar .nav-link.nav-link:hover {
        color: #20a8d8;
        background: #3a4248
    }

    .sidebar-minimized .sidebar .nav-link.nav-link:hover:hover .nav-icon {
        color: #20a8d8;
    }

    .sidebar .nav-link.active {
        color: #20a8d8;
    }

    .sidebar .nav-dropdown.open .nav-link:active {
        color: #20a8d8;
    }

    .sidebar .nav-link.active span {
        color: #20a8d8;
    }

    .sidebar .nav-link.nav-link:hover span {
        color: #20a8d8;
    }

    /* .sidebar .nav-link.active {
        color: #20a8d8;
    } */

    .sidebar .nav-link:hover .nav-icon {
        color: #20a8d8;
    }

    .sidebar .nav-link:hover {
        color: #20a8d8;
        background-color: #3a4248
    }

    .breadcrumb {
        border: none;
        background-color: transparent;
        margin-bottom: 0 rem;
    }

    .list-group-item.active {
        border: none;
        color: #20a8d8;
    }

    .list-group-item.active li {
        border: none;
        color: #20a8d8;
    }

</style>

{{-- <li class="nav-item {{ Request::is('home*') ? 'active' : '' }}">
<a class="nav-link" href="{{ route('home') }}">
    <i class="nav-icon icon-home"></i>
    <span>Beranda</span>
</a>
</li> --}}

{{-- <a href="{{ route('home') }}"
class="bg-dark list-group-item list-group-item-action flex-column align-items-start
{{ Request::is('home*') ? 'active' : '' }}">
<div class="d-flex w-100 justify-content-start align-items-center">
    <i class="nav-icon icon-home"></i>
    <li style="padding:7px 5px 7px 20px; font-weight:bold;">Beranda</li>
</div>
</a> --}}


<li class="nav-item mb-2">
    <a class="nav-link {{ Request::is('home*') ? 'active' : '' }}" href="{{ route('home') }}"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-home"></i>Beranda
    </a>
</li>


@if($student)

<li class="nav-item nav-dropdown mb-2">
    {{-- <a class="nav-link nav-dropdown-toggle {{ Request::is('sidangs*') ? 'active' : '' }} {{ Request::is('slides*') ? 'active' : '' }} {{ Request::is('teams*') ? 'active' : '' }}"
        href="#" style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-user"></i>Mahasiswa
    </a> --}}
    <a class="nav-link nav-dropdown-toggle "
        href="#" style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-user"></i>Mahasiswa
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('sidangs*') ? 'active' : '' }} open" href="{{ route('sidangs.create') }}">
                <i class="nav-icon icon-info ml-1"></i>
                <span>Informasi Pendaftaran</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('slides.index') ? 'active' : '' }}" href="{{ route('slides.index') }}">
                <i class="nav-icon fa fa-folder-o ml-1"></i>
                <span>Materi Presentasi</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('teams.index') ? 'active' : '' }}" href="{{ route('teams.index') }}">
                <i class="nav-icon fa fa-users ml-1"></i>
                <span>Buat Tim</span>
            </a>
        </li>

    </ul>
</li>

{{-- <a href="#submenumhs1" data-toggle="collapse" aria-expanded="false"
    class="bg-dark list-group-item list-group-item-action flex-column align-items-start {{ Request::is('sidangs*') ? 'active' : '' }}
{{ Request::is('slides*') ? 'active' : '' }} {{ Request::is('teams*') ? 'active' : '' }}">
<div class="d-flex w-100 justify-content-start align-items-center">
    <i class="nav-icon icon-user"></i>
    <li style="padding:7px 5px 7px 20px; font-weight:bold;">Mahasiswa</li>
    <i class="nav-icon icon-arrow-right ml-auto"></i>
</div>
</a>

<div id='submenumhs1' class="collapse sidebar-submenu">

    <li class="nav-item  {{ Request::is('sidangs*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sidangs.create') }}">
            <i class="nav-icon icon-plus"></i>
            <span>Pendaftaran</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('slides.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('slides.index') }}">
            <i class="nav-icon icon-cursor"></i>
            <span>Materi Presentasi</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('teams.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('teams.index') }}">
            <i class="nav-icon icon-user"></i>
            <span>Tim</span>
        </a>
    </li>
</div> --}}


<li class="nav-item nav-dropdown mb-2">
    <a class="nav-link nav-dropdown-toggle {{ Request::is('schedule*') ? 'active' : '' }}" href="#"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-list"></i>Jadwal Sidang
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('schedule.mahasiswa') ? 'active' : '' }}"
                href="{{ route('schedule.mahasiswa') }}">
                <i class="nav-icon fa fa-calendar-check-o ml-1"></i>
                <span>Jadwal Sidang</span>
            </a>
        </li>

    </ul>
</li>


{{-- <a href="#submenumhs2" data-toggle="collapse" aria-expanded="false"
    class="bg-dark list-group-item list-group-item-action flex-column align-items-start {{ Request::is('schedule*') ? 'active' : '' }}">
<div class="d-flex w-100 justify-content-start align-items-center">
    <i class="nav-icon icon-list"></i>
    <li style="padding:7px 5px 7px 20px; font-weight:bold;">Jadwal Sidang</li>
    <i class="nav-icon icon-arrow-right ml-auto"></i>
</div>
</a>

<div id='submenumhs2' class="collapse sidebar-submenu">
    <li class="nav-item {{ Request::is('schedule.mahasiswa') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('schedule.mahasiswa') }}">
            <i class="nav-icon icon-list"></i>
            <span>Jadwal Sidang</span>
        </a>
    </li>

</div> --}}



{{--
<a href="#submenumhs3" data-toggle="collapse" aria-expanded="false"
    class="bg-dark list-group-item list-group-item-action flex-column align-items-start {{ Request::is('revision*') ? 'active' : '' }}">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <i class="nav-icon icon-note"></i>
        <li style="padding:7px 5px 7px 20px; font-weight:bold;">Revisi TA</li>
        <i class="nav-icon icon-arrow-right ml-auto"></i>
    </div>
</a>
<div id='submenumhs3' class="collapse sidebar-submenu">
    <li class="nav-item {{ Request::is('revisions.index.mahasiswa') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('revisions.index.mahasiswa') }}">
            <i class="nav-icon icon-note"></i>
            <span>Revisi TA</span>
        </a>
    </li>
</div> --}}

<li class="nav-item nav-dropdown mb-2">
    {{-- <a class="nav-link nav-dropdown-toggle {{ Request::is('revision*') ? 'active' : '' }}" href="#"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-note"></i>Revisi TA
    </a> --}}
    <a class="nav-link nav-dropdown-toggle" href="#"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-note"></i>Revisi TA
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('revisions.index.mahasiswa') ? 'active' : '' }}"
                href="{{ route('revisions.index.mahasiswa') }}">
                <i class="nav-icon fa fa-check-square-o ml-1"></i>
                <span>Revisi TA</span>
            </a>
        </li>
    </ul>
</li>

@endif

@if($pembimbing OR $penguji)

{{-- <a href="#submenudsn1" data-toggle="collapse" aria-expanded="false"
    class="bg-dark list-group-item list-group-item-action flex-column align-items-start {{ Request::is('sidangs*') ? 'active' : '' }} {{ Request::is('schedule*') ? 'active' : '' }}">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <i class="nav-icon icon-list"></i>
        <li style="padding:7px 5px 7px 20px; font-weight:bold;">Pembimbing</li>
        <i class="nav-icon icon-arrow-right ml-auto"></i>
    </div>
</a>
<div id='submenudsn1' class="collapse sidebar-submenu">
    <li class="nav-item {{ Request::is('sidangs.pembimbing') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sidangs.pembimbing') }}">
            <i class="nav-icon icon-list"></i>
            <span>Bimbingan TA</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('schedule.pembimbing') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('schedule.pembimbing') }}">
            <i class="nav-icon icon-calendar"></i>
            <span>Jadwal Sidang Bimbingan</span>
        </a>
    </li>
</div> --}}


<li class="nav-item nav-dropdown mb-2">
    {{-- <a class="nav-link nav-dropdown-toggle {{ Request::is('sidangs*') ? 'active' : '' }} {{ Request::is('schedule*') ? 'active' : '' }}" href="#"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-list"></i>Pembimbing
    </a> --}}
    <a class="nav-link nav-dropdown-toggle" href="#"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon fa fa-book"></i>Pembimbing
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('sidangs.pembimbing') ? 'active' : '' }}"
                href="{{ route('sidangs.pembimbing') }}">
                <i class="nav-icon fa fa-check-square-o ml-1"></i>
                <span>Bimbingan TA</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('schedule.pembimbing') ? 'active' : '' }}"
                href="{{ route('schedule.pembimbing') }}">
                <i class="nav-icon fa fa-calendar-check-o ml-1"></i>
                <span>Jadwal Sidang Bimbingan</span>
            </a>
        </li>
    </ul>
</li>


@endif

@if($penguji)

{{-- <a href="#submenudsn2" data-toggle="collapse" aria-expanded="false"
    class="bg-dark list-group-item list-group-item-action flex-column align-items-start {{ Request::is('schedule*') ? 'active' : '' }}">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <i class="nav-icon icon-calendar"></i>
        <li style="padding:7px 5px 7px 20px; font-weight:bold;">Jadwal Sidang</li>
        <i class="nav-icon icon-arrow-right ml-auto"></i>
    </div>
</a>
<div id='submenudsn2' class="collapse sidebar-submenu">
    <li class="nav-item {{ Request::is('schedule.penguji') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('schedule.penguji') }}">
            <i class="nav-icon icon-calendar"></i>
            <span>Jadwal Sidang Penguji</span>
        </a>
    </li>
</div> --}}


<li class="nav-item nav-dropdown mb-2">
    {{-- <a class="nav-link nav-dropdown-toggle  {{ Request::is('schedule*') ? 'active' : '' }}" href="#"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-calendar"></i>Jadwal Sidang
    </a> --}}
    <a class="nav-link nav-dropdown-toggle" href="#"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon fa fa-hourglass-half"></i>Penguji
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('schedule.penguji') ? 'active' : '' }}"
                href="{{ route('schedule.penguji') }}">
                <i class="nav-icon fa fa-calendar-check-o ml-1"></i>
                <span>Jadwal Sidang Penguji</span>
            </a>
        </li>
    </ul>
</li>



@endif

@if($pic)

{{-- <a href="#submenupic1" data-toggle="collapse" aria-expanded="false"
    class="bg-dark list-group-item list-group-item-action flex-column align-items-start {{ Request::is('sidangs*') ? 'active' : '' }} {{ Request::is('schedules*') ? 'active' : '' }} {{ Request::is('schedule*') ? 'active' : '' }}">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <i class="nav-icon icon-list"></i>
        <li style="padding:7px 5px 7px 20px;font-weight:bold;">PIC TA</li>
        <i class="nav-icon icon-arrow-right ml-auto"></i>
    </div>
</a>
<div id='submenupic1' class="collapse sidebar-submenu">
    <li class="nav-item {{ Request::is('sidangs.pic') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sidangs.pic') }}">
            <i class="nav-icon icon-list"></i>
            <span>Penjadwalan Sidang</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('schedules.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('schedules.index') }}">
            <i class="nav-icon icon-calendar"></i>
            <span>Jadwal Sidang KK</span>
        </a>
    </li>

    <li class="nav-item {{ Request::is('schedule.bukaAkses') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('schedule.bukaAkses') }}">
            <i class="nav-icon icon-key"></i>
            <span>Buka Akses Menu</span>
        </a>
    </li>
</div> --}}


<li class="nav-item nav-dropdown mb-2">
    {{-- <a class="nav-link nav-dropdown-toggle {{ Request::is('sidangs*') ? 'active' : '' }} {{ Request::is('schedules*') ? 'active' : '' }} {{ Request::is('schedule*') ? 'active' : '' }}" href="#"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-list"></i>PIC TA
    </a> --}}
    <a class="nav-link nav-dropdown-toggle " href="#"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-list"></i>PIC TA
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('sidangs.pic') ? 'active' : '' }}"
                href="{{ route('sidangs.pic') }}">
                <i class="nav-icon fa fa-calendar ml-1"></i>
                <span>Penjadwalan Sidang</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('schedules.index') ? 'active' : '' }}"
                href="{{ route('schedules.index') }}">
                <i class="nav-icon fa fa-calendar-check-o ml-1"></i>
                <span>Jadwal Sidang KK</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('schedule.bukaAkses') ? 'active' : '' }}"
                href="{{ route('schedule.bukaAkses') }}">
                <i class="nav-icon icon-key ml-1"></i>
                <span>Buka Akses Menu</span>
            </a>
        </li>
    </ul>
</li>

@endif

@if( $superadmin )
<li class="nav-item nav-dropdown mb-2">
    <a class="nav-link nav-dropdown-toggle "
        href="#" style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon fa fa-user-circle-o"></i>Super Admin
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item {{ Request::is('schedule.adminBermasalahSuperAdmin') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('schedule.adminBermasalahSuperAdmin') }}">
                <i class="nav-icon icon-exclamation"></i>
                <span>Sidang Bermasalah</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('sidangs/all') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('sidangs/all') ? 'active' : '' }}" href="{{ route('sidangs.indexAll') }}">
                <i class="nav-icon icon-list"></i>
                <span>Edit Data Sidang</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('schedule.superadmin') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('schedule.superadmin') }}">
                <i class="nav-icon icon-pencil"></i>
                <span>Edit Nilai Sidang</span>
            </a>
        </li>
    </ul>
</li>

@endif

@if($admin)
<li class="nav-item nav-dropdown mb-2">
    <a class="nav-link nav-dropdown-toggle "
        href="#" style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-list"></i>Sidang TA
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item {{ Request::is('sidangs') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('sidangs.index') }}">
                <i class="nav-icon icon-list"></i>
                <span>Pengajuan</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('schedules') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('schedule.admin-before') }}">
                <i class="nav-icon icon-list"></i>
                <span>Jadwal Sidang</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('schedules') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('schedule.admin') }}">
                <i class="nav-icon icon-calendar"></i>
                <span>Perubahan Hak Akses</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('schedule.adminBermasalah') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('schedule.adminBermasalah') }}">
                <i class="nav-icon icon-exclamation"></i>
                <span>Sidang Bermasalah</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('sidangs') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('sidangs.indexSuratTugasPenguji') }}">
                <i class="nav-icon icon-list"></i>
                <span>Surat Tugas Penguji</span>
            </a>
        </li>
        {{-- <li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="nav-icon icon-group"></i>
                <span>Master Role</span>
            </a>
        </li> --}}
    </ul>
</li>

<li class="nav-item nav-dropdown mb-2">
    <a class="nav-link nav-dropdown-toggle "
        href="#" style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon fa fa-database"></i>Data Master
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item {{ Request::is('users*') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <i class="nav-icon icon-user"></i>
                <span>Pengguna</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('lecturers*') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('lecturers*') ? 'active' : '' }}" href="{{ route('lecturers.index') }}">
                <i class="nav-icon fa fa-users"></i>
                <span>Hak Akses</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('periods*') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('periods*') ? 'active' : '' }}" href="{{ route('periods.index') }}">
                <i class="nav-icon fa fa-clock-o"></i>
                <span>Periode</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('studyPrograms*') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('studyPrograms*') ? 'active' : '' }}" href="{{ route('studyPrograms.index') }}">
                <i class="nav-icon icon-list"></i>
                <span>Program Studi</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('peminatans*') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('peminatans*') ? 'active' : '' }}" href="{{ route('peminatans.index') }}">
                <i class="nav-icon icon-list"></i>
                <span>Peminatan</span>
            </a>
        </li>
        {{-- <li class="nav-item {{ Request::is('sidangs/all') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('sidangs/all') ? 'active' : '' }}" href="{{ route('sidangs.indexAll') }}">
                <i class="nav-icon icon-list"></i>
                <span>Pendaftar TA</span>
            </a>
        </li> --}}
        <li class="nav-item {{ Request::is('verifyDocuments*') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('verifyDocuments*') ? 'active' : '' }}"
                href="{{ route('verifyDocuments.index') }}">
                <i class="nav-icon icon-doc"></i>
                <span>List SN Dokumen</span>
            </a>
        </li>
        <li class="nav-item {{ (Request::is('cLOS*') OR Request::is('clo*')) ? 'active' : '' }}">
            <a class="nav-link {{ (Request::is('cLOS*') OR Request::is('clo*')) ? 'active' : '' }}"
                href="{{ route('cLOS.index') }}">
                <i class="nav-icon icon-key"></i>
                <span>Setting CLO</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('scorePortions*') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('scorePortions*') ? 'active' : '' }}" href="{{ route('scorePortions.index') }}">
                <i class="nav-icon icon-key"></i>
                <span>Porsi Nilai</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('studyPrograms*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('studyPrograms.index') }}">
                <i class="nav-icon icon-cursor"></i>
                <span>Program Studi</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('parameters.index') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('parameters.index') ? 'active' : '' }}"
               href="{{ route('parameters.index') }}">
                <i class="nav-icon icon-list"></i>
                <span>Parameters</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('schedule/status_revisi') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('schedule/status_revisi') ? 'active' : '' }}" href="{{ route('schedule.status_revisi') }}">
                <i class="nav-icon icon-list"></i>
                <span>Status Revisi Mahasiswa</span>
            </a>
        </li>
    </ul>
</li>

@endif

@if($admin OR $superadmin)
<li class="nav-item nav-dropdown mb-2">
    <a class="nav-link nav-dropdown-toggle "
        href="#" style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-doc"></i>Export Data
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item {{ Request::is('cetak/index*') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('cetak/index*') ? 'active' : '' }}" href="{{ route('cetak.index') }}">
                <i class="nav-icon fa fa-files-o"></i>
                <span>Dokumen Sidang</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('exports*') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('exports*') ? 'active' : '' }}" href="{{ route('export.index') }}">
                <i class="nav-icon fa fa-files-o"></i>
                <span>Export Dokumen</span>
            </a>
        </li>
    </ul>
</li>

@endif


{{-- <!-- <li class="nav-item {{ Request::is('attendances*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('attendances.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Attendances</span>
    </a>
</li> -->
<!-- <li class="nav-item {{ Request::is('scores*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('scores.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Scores</span>
    </a>
</li> --> --}}

@if($pembimbing OR $penguji)


<li class="nav-item nav-dropdown">
    {{-- <a class="nav-link nav-dropdown-toggle {{ Request::is('revision*') ? 'active' : '' }}" href="#"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-note"></i>Revisi Sidang
    </a> --}}
    <a class="nav-link nav-dropdown-toggle" href="#"
        style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon icon-note"></i>Revisi Sidang
    </a>
    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('revisions.index.dosen') ? 'active' : '' }}"
                href="{{ route('revisions.index.dosen') }}">
                <i class="nav-icon fa fa-check-square-o ml-1"></i>
                <span>Revisi Mahasiswa</span>
            </a>
        </li>
    </ul>
</li>

@endif

@if($ppm)
<li class="nav-item {{ Request::is('periods*') ? 'active' : '' }}">
    <a class="nav-link {{ Request::is('periods*') ? 'active' : '' }}" href="{{ route('periods.index') }}">
        <i class="nav-icon fa fa-files-o"></i>
        <span>Export List Revisi</span>
    </a>
</li>
@endif

<li class="nav-item nav-dropdown mb-2">
    <a class="nav-link nav-dropdown-toggle "
        href="#" style="font-size: 14px; font-weight: bold;">
        <i class="nav-icon fa fa-bookmark-o"></i>Guide Book
    </a>
    <ul class="nav-dropdown-items">
        @if($admin)
        <li class="nav-item {{ Request::is('guide_book_admin') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('guide_book_admin') ? 'active' : '' }}" href="{{route('guide_book_admin')}}"style="font-size: 14px; font-weight: bold;">
                <i class="nav-icon icon-notebook"></i>Admin
            </a>
        </li>
        <li class="nav-item {{ Request::is('guide_book_PIC') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('guide_book_admin_PIC') ? 'active' : '' }}" href="{{route('guide_book_PIC')}}"style="font-size: 14px; font-weight: bold;">
                <i class="nav-icon icon-notebook"></i>PIC
            </a>
        </li>
        <li class="nav-item {{ Request::is('guide_book_pembimbing') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('guide_book_admin_pembimbing') ? 'active' : '' }}" href="{{route('guide_book_pembimbing')}}"style="font-size: 14px; font-weight: bold;">
                <i class="nav-icon icon-notebook"></i>Dosen
            </a>
        </li>
        <li class="nav-item {{ Request::is('guide_book_student') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('guide_book_admin_student') ? 'active' : '' }}" href="{{route('guide_book_student')}}"style="font-size: 14px; font-weight: bold;">
                <i class="nav-icon icon-notebook"></i>Mahasiswa
            </a>
        </li>

        @elseif($pic)
        <li class="nav-item {{ Request::is('guide_book_PIC') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('guide_book_admin_PIC') ? 'active' : '' }}" href="{{route('guide_book_PIC')}}"style="font-size: 14px; font-weight: bold;">
                <i class="nav-icon icon-notebook"></i>PIC
            </a>
        </li>
        <li class="nav-item {{ Request::is('guide_book_pembimbing') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('guide_book_admin_pembimbing') ? 'active' : '' }}" href="{{route('guide_book_pembimbing')}}"style="font-size: 14px; font-weight: bold;">
                <i class="nav-icon icon-notebook"></i>Dosen
            </a>
        </li>

        @elseif($student)
        <li class="nav-item {{ Request::is('guide_book_student') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('guide_book_admin_student') ? 'active' : '' }}" href="{{route('guide_book_student')}}"style="font-size: 14px; font-weight: bold;">
                <i class="nav-icon icon-notebook"></i>Mahasiswa
            </a>
        </li>

        @elseif($pembimbing OR $penguji)
        <li class="nav-item {{ Request::is('guide_book_pembimbing') ? 'active' : '' }}">
            <a class="nav-link {{ Request::is('guide_book_admin_pembimbing') ? 'active' : '' }}" href="{{route('guide_book_pembimbing')}}"style="font-size: 14px; font-weight: bold;">
                <i class="nav-icon icon-notebook"></i>Dosen
            </a>
        </li>
        @endif
    </ul>
</li>

{{-- <a href="#submenuusr" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <li style="padding:7px 5px 7px 20px;color:grey; font-weight:bold;">User Guide</li>
        <i class="nav-icon icon-arrow-right ml-auto"></i>
    </div>
</a>
<div id='submenuusr' class="collapse sidebar-submenu">
    @if ($admin OR $superadmin)
        <li class="nav-item {{ Request::is('#') ? 'active' : '' }}">
<a class="nav-link" href="{{ route('#') }}">
    <i class="nav-icon icon-notebook"></i>
    <span>Admin</span>
</a>
</li>
@endif

@if ($student)
<li class="nav-item">
    <a class="nav-link" href="#">
        <i class="nav-icon icon-notebook"></i>
        <span>Mahasiswa</span>
    </a>
</li>
@endif

@if ($pembimbing OR $penguji)
<li class="nav-item">
    <a class="nav-link" href="#">
        <i class="nav-icon icon-notebook"></i>
        <span>Dosen</span>
    </a>
</li>
@endif

@if ($pic)
<li class="nav-item">
    <a class="nav-link" href="#">
        <i class="nav-icon icon-notebook"></i>
        <span>PIC TA</span>
    </a>
</li>
@endif

</div> --}}
