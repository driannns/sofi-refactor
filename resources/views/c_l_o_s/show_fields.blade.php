<div class="table-responsive-sm">
  <table class="table table-striped table-borderless">
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Code</td>
          <td>:</td>
          <td>{{ $cLO->code }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Percentage</td>
          <td>:</td>
          <td>{{ $cLO->precentage }}%</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Description</td>
          <td>:</td>
          <td>{{ $cLO->description }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Unsur Penilaian</td>
          <td>:</td>
          <td>{!! nl2br(e($cLO->components[0]->unsur_penilaian)) !!}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Period</td>
          <td>:</td>
          <td>{{ $cLO->period->name }}</td>
        </tr>
        <tr>
          <td class="font-weight-bold" style="white-space: nowrap;">Berlaku Untuk</td>
          <td>:</td>
          <td>
            {{ $cLO->components[0]->pembimbing == 1 ? 'Pembimbing' : '' }}<br>
            {{ $cLO->components[0]->penguji == 1 ? 'Penguji' : '' }}
          </td>
        </tr>
  </table>
</div>
