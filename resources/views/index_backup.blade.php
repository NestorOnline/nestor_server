@extends('layout')

@section('content')
@include('flash')
<div class="card">
    <div class="card-body">
        <table class="table table-hover table-sm">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Client Name</th>
                <th scope="col">Audit Date</th>
                <th scope="col">Responsible Office</th>
                <th scope="col">Engagement Team</th>
                <th scope="col">Engagement Manager</th>
                <th scope="col">Engagement Partner</th>
                <th scope="col">Quality Control Reviewer</th>
                <th scope="col">Download</th>
                <th scope="col">Status</th>
                <th scope="col">Assignd NPSG Team</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($request_masters as $key=>$request_master)
                    <tr>
                        <th scope="row">{{ $key+1 }}</th>
                        <td>{{$request_master->client_name}}</td>
                        <td>{{$request_master->audit_date->format('d-M-Y')}}</td>
                        <td>{{$request_master->responsible_office}}</td>
                        <?php
                        $et_request_masters = App\Models\ETRequestMaster::where('request_master_id','=',$request_master->id)->get();
                        $users = App\Models\User::whereIn('id',$et_request_masters->map(function($et_request_master){
                            return $et_request_master->et_user_id;
                        }))->get();
                        ?>
                        <td>
                        @foreach($users as $user)
                        {{$user->user_name}}<br>
                        @endforeach
                           
                        </td>
                        <td >
                        <?php
$manager =  App\Models\User::find($request_master->et_manager);
                        ?>
                        {{$manager->user_name}}</td>
                        <td>
                        <?php
$partnar =  App\Models\User::find($request_master->et_partner);
                        ?>
                        {{$partnar->user_name}}</td>
                        <td>
                        <?php
$qc_rewier =  App\Models\User::find($request_master->qc_reviewer);
                        ?>
                        {{$qc_rewier->user_name}}</td>
                        <td style="width: 150px">
                        SFSPY-S:@if($request_master->sfspy_standalone_file)
						<?php
                         $explode=explode('/',$request_master->sfspy_standalone_file);
						?>
						<a href="{{route('backend.request_masters.download',$explode[1])}}" class="btn btn-large pull-right"><i class="fa fa-download"> </i> </a>
						@endif<br>
                        SFSPY-C:@if($request_master->sfspy_consol_file)
						<?php
                         $explode=explode('/',$request_master->sfspy_consol_file);
						?>
						<a href="{{route('backend.request_masters.download',$explode[1])}}" class="btn btn-large pull-right"><i class="fa fa-download"> </i></a>
						@endif<br>
                        DFSCY-S:@if($request_master->dfscy_standalone_file)
						<?php
                         $explode=explode('/',$request_master->dfscy_standalone_file);
						?>
						<a href="{{route('backend.request_masters.download',$explode[1])}}" class="btn btn-large pull-right"><i class="fa fa-download"> </i></a>
						@endif<br>
                        DFSCY-C:@if($request_master->dfscy_consolidated_file)
						<?php
                         $explode=explode('/',$request_master->dfscy_consolidated_file);
						?>
						<a href="{{route('backend.request_masters.download',$explode[1])}}"  class="btn btn-large pull-right"> <i class="fa fa-download"> </i> </a>
						@endif<br>
                        DCC:@if($request_master->draft_disclosure_checklist_file)
						<?php
                         $explode=explode('/',$request_master->draft_disclosure_checklist_file);
						?>
						<a href="{{route('backend.request_masters.download',$explode[1])}}" class="btn btn-large pull-right"><i class="fa fa-download"> </i> </a>
						@endif<br>
                        DIAS:@if($request_master->draft_ind_as_checklist)
						<?php
                         $explode=explode('/',$request_master->draft_ind_as_checklist);
						?>
						<a href="{{route('backend.request_masters.download',$explode[1])}}" class="btn btn-large pull-right"><i class="fa fa-download"> </i></a>
						@endif<br>
                        <!-- Download All: <a href="{{route('backend.request_masters.download_all',$request_master->id)}}" class="btn btn-large pull-right"><i class="fa fa-download"> </i></a> -->
                         </td>
                        <td>{{config('gt.checkpoint_status')[$request_master->status]}}</td>
                        <td>
                        <?php
                        $preperd =  App\Models\User::find($request_master->npsg_prepare);
                        $reviewer1 =  App\Models\User::find($request_master->npsg_reviewer_1);
                        $reviewer2 =  App\Models\User::find($request_master->npsg_reviewer_2);
                        ?>
                            @if($preperd)
                            P-{{$preperd->user_name}}<br>
                            @endif
                            @if($reviewer1)
                            R1-{{$reviewer1->user_name}}<br>
                            @endif
                            @if($reviewer2)
                            R2-{{$reviewer2->user_name}}<br>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <!-- @if($login_user->role!='npsg_admin')
                                <a href="javascript:void()" data-tooltip="tooltip" title="View Document" data-toggle="modal" data-target="#showDocuments" data-rm="{{$request_master}}" class="btn btn-sm btn-primary">
                                    <span style="font-size: 10px;">
                                        <i class="fas fa-file-excel"></i>
                                    </span>
                                </a>
                                @endif -->
                                @if($login_user->role=='npsg_admin')
                                <a  href="javascript:void()" data-tooltip="tooltip" title="Assign NPSG Users" data-toggle="modal" data-target="#addReviewerModel" data-rmid="{{$request_master->id}}" class="btn btn-sm btn-primary">
                                    <span style="font-size: 10px;">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </a>
                                @endif
                                @if($login_user->role!='npsg_admin')
                                    @if($login_user->user_type=='npsg' || ($request_master->status >= 18 && ($login_user->id ==  $request_master->et_manager || $login_user->id ==  $request_master->et_partner || $login_user->id == $request_master->edit_manager)))
                                    <a href="{{url('/initial_queries/import/'.$request_master->id)}}" class="btn btn-sm btn-primary" data-tooltip="tooltip" title="View Detail">
                                        <span style="font-size: 10px;">
                                            <i class="fas fa-tasks"></i>
                                        </span>
                                    </a>
                                    @endif
                                @endif
                                @if( $request_master->et_manager == $login_user->id)
                                <a href="javascript:void()" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#changeAccess" data-rrmid="{{$request_master->id}}" data-tooltip="tooltip" title="Change Access Rights">
                                    <span style="font-size: 10px;">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </a>
                                @endif
                                @if(($login_user->id===$request_master->et_manager||$login_user->id===$request_master->et_partner)&& ($request_master->status < 18&&$request_master->status != 10))
                                <a href="{{route('backend.request_masters.edit',$request_master->id)}}" class="btn btn-sm btn-primary" data-tooltip="tooltip" title="Edit">
                                    <span style="font-size: 10px;">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </a>
                                @endif
                                @if($login_user->id===$request_master->et_manager && $request_master->status == 0)
                                <!-- <a href="{{url('request_masters/change_status/'.$request_master->id.'/5')}}" class="btn btn-sm btn-primary" data-tooltip="tooltip" title="Forwerd To Partner">
                                    <span style="font-size: 10px;">
                                        <i class="fas fa-paper-plane"></i>
                                    </span>
                                </a> -->
                                @endif
                                @if($request_master->status == 0 && ($login_user->id==$request_master->et_partner||$login_user->id==$request_master->et_manager))
                                <a href="{{url('request_masters/change_status/'.$request_master->id.'/10')}}" class="btn btn-sm btn-primary" data-tooltip="tooltip" title="Submit To NPSG">
                                    <span style="font-size: 10px;">
                                        <i class="fas fa-paper-plane"></i>
                                    </span>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $request_masters->links() !!}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addReviewerModel" tabindex="-1" role="dialog" aria-labelledby="addReviewerModelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addReviewerModelLabel">Select NPSG Members</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      {!!Form::open(['route'=>['backend.request_masters.assign_npsg_team',],'files'=>true,'class'=>'form-horizontal'])!!}
      <input id="addReviewerModelLidden" name="request_master_id" type="hidden">
            <div class="mb-3 row">
				<label for="npsgPrepare" class="col-sm-5 col-form-label">Prepare User<span class="required">*</span></label>
				<div class="col-sm-7">
					<select id="npsgPrepare" name="npsg_prepare" class="form-control" required>
						<option value="">---Select Prepare User---</option>
						@foreach($npfg_users as $npfg_user)
                        @if($npfg_user->role=='npsg_admin')
                        @else
                        <option value="{{$npfg_user->id}}">{{$npfg_user->user_name}}</option>
                        @endif
						@endforeach
					</select>
				</div>
			</div>
			<div class="mb-3 row">
				<label for="npsgReviewer" class="col-sm-5 col-form-label">Reviewer One<span class="required">*</span></label>
				<div class="col-sm-7">
					<select id="npsgReviewer" name="npsg_reviewer_1" class="form-control" required>
						<option value="">---Select Reviewer One---</option>
                        @foreach($npfg_users as $npfg_user)
						<option value="{{$npfg_user->id}}">{{$npfg_user->user_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
            <div class="mb-3 row">
				<label for="npsgReviewer" class="col-sm-5 col-form-label">Reviewer Two<span class="required">*</span></label>
				<div class="col-sm-7">
					<select id="npsgReviewer" name="npsg_reviewer_2" class="form-control" required>
						<option value="">---Select Reviewer Two---</option>
                        @foreach($npfg_users as $npfg_user)
						<option value="{{$npfg_user->id}}">{{$npfg_user->user_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        {!!Form::close()!!}
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="changeAccess" tabindex="-1" role="dialog" aria-labelledby="changeAccessLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeAccessLabel">Select New Manager</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      {!!Form::open(['route'=>['backend.request_masters.assign_new_manager'],'files'=>true,'class'=>'form-horizontal'])!!}
      <input id="changeAccessModelLidden" name="request_master_id" type="hidden">
            <div class="mb-3 row">
				<label for="newManager" class="col-sm-5 col-form-label">New Manager<span class="required">*</span></label>
				<div class="col-sm-7">
					<select id="newManager" name="new_manager_id" class="form-control" required>
						<option value="">---Select Prepare User---</option>
						@foreach($et_users as $user)
						<option value="{{$user->id}}">{{$user->user_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        {!!Form::close()!!}
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="showDocuments" tabindex="-1" role="dialog" aria-labelledby="showDocumentsLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width:90%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showDocumentsLabel">Documents</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input id="showDocumentsLidden" name="request_master_id" type="hidden">
                <div id="showDocumentsInnerBox">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#addReviewerModel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('rmid') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('#addReviewerModelLabel').text('Select NPSG Members for #' + id)
        modal.find('#addReviewerModelLidden').val(id)
    });
    $('#changeAccess').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('rrmid') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('#changeAccessModelLabel').text('Select New Manager for #' + id)
        modal.find('#changeAccessModelLidden').val(id)
    });
    $('#showDocuments').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var rm = button.data('rm') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('#showDocumentsLabel').text('Documents for #' + rm.id)
        modal.find('#showDocumentsLidden').val(rm.id)
        $('#showDocumentsInnerBox').html(`<h4>Signed financial statement of previous year</h4>`)
        $('#showDocumentsInnerBox').append(`<object data="{{config('app.url')}}/${rm.sfspy_standalone_file}" width="100%"></object>`)
        $('#showDocumentsInnerBox').append(`<h4>Signed financial statement of previous year</h4>`)
        $('#showDocumentsInnerBox').append(`<object data="{{config('app.url')}}/${rm.sfspy_consol_file}" width="100%"></object>`)
        $('#showDocumentsInnerBox').append(`<h4>Draft financial statement of current year</h4>`)
        $('#showDocumentsInnerBox').append(`<object data="{{config('app.url')}}/${rm.dfscy_standalone_file}" width="100%"></object>`)
        $('#showDocumentsInnerBox').append(`<h4>Signed financial statement of previous year</h4>`)
        $('#showDocumentsInnerBox').append(`<object data="{{config('app.url')}}/${rm.dfscy_consolidated_file}" width="100%"></object>`)
        $('#showDocumentsInnerBox').append(`<h4>Draft discloser cheaklist</h4>`)
        $('#showDocumentsInnerBox').append(`<object data="{{config('app.url')}}/${rm.draft_disclosure_checklist_file}" width="100%"></object>`)
        $('#showDocumentsInnerBox').append(`<h4>Draft ind AS checklist</h4>`)
        $('#showDocumentsInnerBox').append(`<object data="{{config('app.url')}}/${rm.draft_ind_as_checklist}" width="100%"></object>`)
    })
</script>
@endsection