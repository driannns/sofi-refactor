@extends('layouts.app_embed')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
             <div class="row">
                 <div class="col-lg-12">
                    <div class="table-responsive-sm" style="overflow-x:scroll">
                      <table class="table table-striped" id="schedules-table">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Date</th>
                              <th>Feedback</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($revisionLogs as $index=>$revisionLog)
                              <tr>
                                <td>{{ $index+1 }}</td>
                                <td>
                                  {{ date('d-M-y H:i', strtotime($revisionLog->created_at)) }}
                                </td>
                                <td>{{ $revisionLog->feedback }}</td>
                              </tr>
                          @endforeach
                          </tbody>
                      </table>
                  </div>
             </div>
         </div>
    </div>
@endsection
