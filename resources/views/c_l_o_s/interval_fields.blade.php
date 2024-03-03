<!-- Schedule Id Field -->
<div class="row">
  <div class="form-group col-sm-8">
    <button type="button" id="addInterval" class='btn btn-primary'>
      Tambah Interval
    </button>
  </div>
</div>

<table class="table table-responsive-lg table-bordered">
  <thead>
    <tr>
      <th>Interval</th>
      <th>Ekuivalensi (Skala 100)</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="revisionPlace">
    @if($cLO == null)
    <tr>
      <td>
        <div class="form-group col-sm-12">
          {!! Form::number('interval[]', null, ['class' => 'form-control','required','placeholder' => 'Ex: 1']) !!}
        </div>
      </td>
      <td>
        <div class="form-group col-sm-12">
          {!! Form::number('ekuivalensi[]', null, ['class' => 'form-control','required','placeholder' => 'Ex: 20.01', 'step' => '0.01']) !!}
        </div>
      </td>
      <td></td>
    </tr>
    @else
    @foreach($cLO->components[0]->intervals as $interval)
    <tr>
      <td>
        <div class="form-group col-sm-12">
          {!! Form::number('interval[]', $interval->value, ['class' => 'form-control','required','placeholder' => 'Ex: 1']) !!}
        </div>
      </td>
      <td>
        <div class="form-group col-sm-12">
          {!! Form::number('ekuivalensi[]', $interval->ekuivalensi, ['class' => 'form-control','required','placeholder' => 'Ex: 20.01', 'step' => '0.01']) !!}
        </div>
      </td>
      <td>
        <div class='form-group col-sm-12'>
          <button type='button' name='btn-del' class='btn btn-danger w-100'>
            Hapus Baris
          </button>
        </div>
      </td>
    </tr>
    @endforeach
    @endif
  </tbody>
</table>

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function(){
      $('#addInterval').on('click', function(){
        var line = "<tr>"+
            "<td>"+
              "<div class='form-group col-sm-12'>"+
                "<input type='number' name='interval[]' class='form-control' required=''>"+
              "</div>"+
            "</td>"+
            "<td>"+
              "<div class='form-group col-sm-12'>"+
                "<input type='number' name='ekuivalensi[]' class='form-control' value='' required=''>"+
              "</div>"+
            "</td>"+
            "<td>"+
            "<div class='form-group col-sm-12'>"+
              "<button type='button' name='btn-del' class='btn btn-danger w-100'>"+
                "Hapus Baris"+
              "</button>"+
              "</div>"+
            "</td>"+
          "</tr>";
        $('#revisionPlace').append(line);
      });

      $('#revisionPlace').on('click', 'button[type="button"]', function(e){
        $(this).closest('tr').remove();
      })
    });
  </script>
@endpush
