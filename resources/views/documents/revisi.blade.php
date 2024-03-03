@if($isPrint)
    @include('documents.partitions.headerPrint')
@else
    @include('documents.partitions.header')
@endif

<div class="row">
    <div class="col-md-12 text-center mb-5">
        <h2 class="font-weight-bold">LEMBAR PERBAIKAN TUGAS AKHIR</h2>
    </div>
</div>

<div class="container mb-5">
    <div class="row" style="margin:0 20% 0 20%">
        <div class="col-sm-12">
            <table class="table table-borderless">
                <tr>
                    <td style="white-space:nowrap;">NAMA</td>
                    <td style="width:10px">:</td>
                    <td>{{ $schedule->sidang->mahasiswa->user->nama }}</td>
                </tr>
                <tr>
                    <td style="white-space:nowrap;">NIM</td>
                    <td style="width:10px">:</td>
                    <td>{{ $schedule->sidang->mahasiswa->nim }}</td>
                </tr>
                <tr>
                    <td style="white-space:nowrap;">JUDUl TA</td>
                    <td style="width:10px">:</td>
                    <td>{{ $schedule->sidang->judul }}</td>
                </tr>
                <tr>
                    <td style="white-space:nowrap;">PEMBIMBING 1</td>
                    <td style="width:10px">:</td>
                    <td>
                        {{ $schedule->sidang->pembimbing1->user->nama }}
                    </td>
                </tr>
                <tr>
                    <td style="white-space:nowrap;">PEMBIMBING 2</td>
                    <td style="width:10px">:</td>
                    <td>
                        {{ $schedule->sidang->pembimbing2->user->nama }}
                    </td>
                </tr>
                <tr>
                    <td style="white-space:nowrap;">PENGUJI 1</td>
                    <td style="width:10px">:</td>
                    <td>
                        {{ $schedule->detailpenguji1->user->nama }}
                    </td>
                </tr>
                <tr>
                    <td style="white-space:nowrap;">PENGUJI 2</td>
                    <td style="width:10px">:</td>
                    <td>
                        {{ $schedule->detailpenguji2->user->nama }}
                    </td>
                </tr>
            </table>
            <div class="table-responsive-lg" style="background:white;">
                <table class="table table-bordered text-center">
                    <tr>
                        <td>
                            <h6>Hal-hal yang harus diperbaiki dalam buku laporan Tugas Akhir</h6>
                                @if( count($revisions_ta) > 0)
                                <ul class="text-left">
                                    @foreach($revisions_ta as $revisi)
                                        <li>{{$revisi->deskripsi}}</li>
                                    @endforeach
                                </ul>
                                @else
                                    Tidak ada Catatan Revisi
                                @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h6>Hal-hal yang harus diperbaiki dalam jurnal Tugas Akhir</h6>
                            @if( count($revisions_makalah) > 0)
                            <ul class="text-left">
                                @foreach($revisions_makalah as $makalah)
                                    <li>{{$makalah->deskripsi}}</li>
                                @endforeach
                            </ul>
                            @else
                                Tidak ada Catatan Revisi
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <p class="mb-4 font-weight-bold">
                *Perbaikan paling lambat dikumpulkan satu minggu setelah sidang.
            </p>
        </div>
    </div>
</div>
@include('documents.partitions.footer')
