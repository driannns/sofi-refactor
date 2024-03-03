<div class="table-responsive-sm">
  <table class="table table-striped table-borderless">
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Username</td>
          <td>:</td>
          <td>{{ $user->username }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Nama</td>
          <td>:</td>
          <td>{{ $user->nama }}</td>
        </tr>
        @if(!empty($child))
        @if($user->lecturers != null)
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">NIP</td>
          <td>:</td>
          <td>{{ $child->nip }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">JFA</td>
          <td>:</td>
          <td>{{ $child->jfa }}</td>
        </tr>
        @else
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">NIM</td>
          <td>:</td>
          <td>{{ $child->nim }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">TAK</td>
          <td>:</td>
          <td>{{ $child->tak }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">EPRT</td>
          <td>:</td>
          <td>{{ $child->eprt }}</td>
        </tr>
        @endif
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Kelompok Keahlian</td>
          <td>:</td>
          <td>{{ $child->kk }}</td>
        </tr>
        @endif
  </table>
</div>
