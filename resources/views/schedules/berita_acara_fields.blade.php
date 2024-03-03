<div id="content">
  <embed type="" src="/cetak/berita_acara/{{$schedule->id}}" height="500px" width="100%">

</div>

<!-- putusan -->
<!-- <form class="" action="{{ route('schedules.berita_acara', [$schedule->id]) }}" method="post">
  @csrf
  <div class="form-group col-sm-12 mt-3">
    <button type="submit" name="button" class="btn btn-primary" {{ $schedule->keputusan == null ? 'disabled' : '' }}>Save</button>
    <a href="{{ route('schedule.penguji') }}" class="btn btn-secondary">Cancel</a>
  </div>
</form>
 -->