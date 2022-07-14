@extends('layout')

@section('content')
@include('flash')
<!-- page content -->
<div class="card">
<!--Start Import Initial Query -->
	<div class="card-body v-height-100">
		@if($login_user->id==$request_master->npsg_prepare)
			@if(!$isAllQueryClosed)
				{!!Form::open(['route'=>['backend.initial_queries.import_store',$request_master->id],'files'=>true,'class'=>'form-inline'])!!}
					<div class="row" style="width: 100%">
						<div class="col-sm-4">
							<h6 class="col-form-label">Import Prepare Document</h6>
						</div>
						<div class="col-sm-4">
							<input type="hidden" name="id" value="{{$id}}">
							<input type="file" name="import" class="form-control mb-2 mr-sm-2" id="importFile" placeholder="Default Input">
						</div>
						<div class="col-sm-2">
							<button type="submit"  class="btn btn-primary mb-2 flot-right">Submit</button>
						</div>
						<div class="col-sm-2">
							<a href="javascript:void()"  data-toggle="modal" data-target="#addInitialQuery"  class="btn btn-sm btn-primary">
							<span style="font-size: 10px;">
							Add Initial Query<i class="fas fa-plus"></i>
							</span>
							</a>
						</div>
					</div>
				{!!Form::close()!!}
			@endif
		@endif
		<!--End Import Initial Query -->

		<!--Start List Of Initial Query -->
		{!!Form::open(['route'=>['backend.initial_queries.import_store',$request_master->id],'files'=>true,'class'=>'form-inline'])!!}
			<div class="wrapper1">
				<div class="div1"></div>
			</div>
			<div class="wrapper2">
    			<div class="div2">
					<table class="table-bordered table-sm">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Standalone / Consolidated Financial Statement</th>
								<th scope="col">Page Number of Annual report</th>
								<th scope="col">Heading of Disclosure</th>
								<th scope="col">Financial Statement Heading (FSLI)</th>
								<th scope="col">Topic (give heading)</th>
								<th scope="col">Detailed Comment</th>
								<th scope="col">Rationale</th>
								<th scope="col">Techincal Reference</th>
								<th scope="col"></th>
								<th scope="col">ET Response</th>
								<th scope="col">Technical Refernece</th>
								<th scope="col"></th>
								<th scope="col">NPSG Remarks</th>
								<th scope="col">Status</th>
								<th scope="col">Final Conclusion</th>
								@if($login_user->user_type=='npsg')
								<th scope="col">Internal Comments</th>
								@endif
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($initialList as $key => $data)
								<tr id="tr-{{$data->id}}">
									<th scope="row">{{ $key+1 }}</th>
									<td>{{$data->scfs}}</td>
									<td>{{$data->pnar}}</td>
									<td>{{$data->head_discloser}}</td>
									<td>{{$data->fsli}}</td>
									<td>{{$data->topic}}</td>
									<td>{{$data->detail_comment}}</td>
									<td>{{$data->rational}}</td>
									<td>{{$data->technical_refercene}}</td>
									<td></td>
									@if(count($data->add_et_comment))
									@foreach($data->add_et_comment as $add_et_comment)
									<td>{{$add_et_comment->comment1}}</td>
									<td>{{$add_et_comment->comment2}}</td>
									@endforeach
									@else
									<td></td>
									<td></td>
									@endif
									<td></td>
									@if(count($data->add_nfsg_comment))
									@foreach($data->add_nfsg_comment as $add_nfsg_comment)
									<td>{{$add_nfsg_comment->comment1}}</td>
									<td>{{$data->status}}</td>
									<td>{{$add_nfsg_comment->comment2}}</td>
									@endforeach
									@else
									<td></td>
									<td>{{$data->status}}</td>
									<td></td>
									@endif
									
									@if($login_user->user_type=='npsg')
									@if(count($data->add_internal_comment))
									@foreach($data->add_internal_comment as $add_internal_comment)
									<?php
									$nfsg_user= \App\Models\User::find($add_internal_comment->user_id);
									?>
									<td><strong style="color: purple">By: </strong>{{$nfsg_user->user_name}}<br>
									<strong style="color: purple">Comment:</strong> {{$add_internal_comment->comment}}</td>
									@endforeach
									@else
									<td></td>
									@endif
									@endif
									<td>
									@if($login_user->id==$request_master->npsg_prepare)
									<a href="javascript:void()" data-tooltip="tooltip" title="Edit"  data-toggle="modal" data-target="#editInitialQuery" data-sr_no="{{ $key+1 }}" data-rmid="{{$data->id}}" data-rmscfs="{{$data->scfs}}" data-rmpnar="{{$data->pnar}}" data-rmhead_discloser="{{$data->head_discloser}}" data-rmfsli="{{$data->fsli}}" data-rmtopic="{{$data->topic}}" data-rmdetail_comment="{{$data->detail_comment}}" data-rmrational="{{$data->rational}}"   data-rmtechnical_refercene="{{$data->technical_refercene}}" class="btn btn-sm btn-primary">
										<span style="font-size: 10px;">
											<i class="fas fa-edit"></i>
										</span>
									</a>
									@endif
									@if($login_user->user_type=='et' && $request_master->status == 18 && $login_user->id == $request_master->edit_manager)
									<a href="javascript:void()" data-tooltip="tooltip" title="Add ET Comment"  data-toggle="modal" data-target="#addCommentEt" data-rmid="{{$data->id}}" data-sr_no="{{ $key+1 }}" class="btn btn-sm btn-primary">
										<span style="font-size: 10px;">
											<i class="fas fa-comment"></i>
										</span>
									</a>
									@endif
									@if($login_user->user_type=='npsg')
									<a href="javascript:void()" data-tooltip="tooltip" title="Add Internal Comment" data-toggle="modal" data-target="#addInternalComment" data-sr_no="{{ $key+1 }}" data-rmid="{{$data->id}}" class="btn btn-sm btn-primary">
											<span style="font-size: 10px;">
												<i class="fas fa-comment"></i>
											</span>
									</a>
									@if(count($data->add_et_comment))
									<a href="javascript:void()" data-tooltip="tooltip" title="Add NPSG Comment" data-toggle="modal" data-target="#addCommentReviewer" data-sr_no="{{ $key+1 }}" data-rmid="{{$data->id}}" class="btn btn-sm btn-primary">
										<span style="font-size: 10px;">
											<i class="fas fa-comment"></i>
										</span>
									</a>
									@endif
									@endif

									@if($login_user->id==$request_master->npsg_prepare && $request_master->status <= 25)
									<a href="{{route('backend.initial_queries.delete',$data->id)}}"  title="Delete Inital Query" class="btn btn-sm btn-primary">
										<span style="font-size: 10px;">
											<i class="fas fa-trash"></i>
										</span>
									</a>
									@endif
									<!-- <a href="/initial_queries/import/{{$request_master->id}}" data-tooltip="tooltip" title="Approve" class="btn btn-sm btn-primary">
										<span style="font-size: 10px;">
											<i class="fas fa-check"></i>
										</span>
									</a>
									<a href="/initial_queries/import/{{$request_master->id}}" data-tooltip="tooltip" title="Reject" class="btn btn-sm btn-primary">
										<span style="font-size: 10px;">
											<i class="fas fa-ban"></i>
										</span>
									</a> -->
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		{!!Form::close()!!}
	</div>
	@if(count($initialList) && !$isAllQueryClosed && $request_master->status < 50)
		<div class="card-footer">
			@if($login_user->user_type=='npsg')
				@if(($login_user->id==$request_master->npsg_prepare && ($request_master->status == 20 || $request_master->status == 25)) || ($login_user->id==$request_master->npsg_reviewer_1 && ($request_master->status == 30 || $request_master->status == 35)) || ($login_user->id==$request_master->npsg_reviewer_2 && ($request_master->status == 40 || $request_master->status == 45)))
				<a href="{{url('request_masters/change_status/'.$request_master->id.'/15')}}" class="btn btn-sm btn-primary">
					<span style="font-size: 10px;">
						<i class="fas fa-paper-plane"></i>
					</span>
					Return to ET
				</a>
				@if($login_user->id!=$request_master->npsg_prepare)
				<a href="{{url('request_masters/change_status/'.$request_master->id.'/18')}}" class="btn btn-sm btn-primary">
					<span style="font-size: 10px;">
						<i class="fas fa-paper-plane"></i>
					</span>
					Forward to ET For Review
				</a>
				@endif
				@if($request_master->status == 25 || $request_master->status == 35 || $request_master->status == 55)
					@if($login_user->id!=$request_master->npsg_prepare && $request_master->status != 25)
					<a href="{{url('request_masters/change_status/'.$request_master->id.'/25')}}" class="btn btn-sm btn-primary">
						<span style="font-size: 10px;">
							<i class="fas fa-paper-plane"></i>
						</span>
						Return to Prepare
					</a>
					@endif
					@if( $login_user->id!=$request_master->npsg_reviwer_1  && $request_master->status != 35)
					<a href="{{url('request_masters/change_status/'.$request_master->id.'/35')}}" class="btn btn-sm btn-primary">
						<span style="font-size: 10px;">
							<i class="fas fa-paper-plane"></i>
						</span>
						Return to Reviewer One
					</a>
					@endif
					@if($login_user->id!=$request_master->npsg_reviwer_2  && $request_master->status != 45)
					<a href="{{url('request_masters/change_status/'.$request_master->id.'/45')}}" class="btn btn-sm btn-primary">
						<span style="font-size: 10px;">
							<i class="fas fa-paper-plane"></i>
						</span>
						Return for Final Review
					</a>
					@endif
				@else
				
					@if($login_user->id!=$request_master->npsg_prepare && $request_master->status != 20)
					<a href="{{url('request_masters/change_status/'.$request_master->id.'/20')}}" class="btn btn-sm btn-primary">
						<span style="font-size: 10px;">
							<i class="fas fa-paper-plane"></i>
						</span>
						Forward to Prepare
					</a>
					@endif
					@if($login_user->id!=$request_master->npsg_reviewer_1 && $request_master->status != 30)
					<a href="{{url('request_masters/change_status/'.$request_master->id.'/30')}}" class="btn btn-sm btn-primary">
						<span style="font-size: 10px;">
							<i class="fas fa-paper-plane"></i>
						</span>
						Forward to Reviewer One
					</a>
					@endif
					@if($login_user->id!=$request_master->npsg_reviewer_2  && $request_master->status != 40)
					<a href="{{url('request_masters/change_status/'.$request_master->id.'/40')}}" class="btn btn-sm btn-primary">
						<span style="font-size: 10px;">
							<i class="fas fa-paper-plane"></i>
						</span>
						Forward For Final Review
					</a>
					@endif
				@endif
			@endif
		@endif
		@if($login_user->user_type=='et')
			@if($request_master->status == 15)
				<a href="{{url('request_masters/change_status/'.$request_master->id.'/25')}}" class="btn btn-sm btn-primary">
					<span style="font-size: 10px;">
						<i class="fas fa-paper-plane"></i>
					</span>
					Forward to Prepare
				</a>
				<a href="{{url('request_masters/change_status/'.$request_master->id.'/35')}}" class="btn btn-sm btn-primary">
					<span style="font-size: 10px;">
						<i class="fas fa-paper-plane"></i>
					</span>
					Forward to Reviewer One
				</a>
				<a href="{{url('request_masters/change_status/'.$request_master->id.'/45')}}" class="btn btn-sm btn-primary">
					<span style="font-size: 10px;">
						<i class="fas fa-paper-plane"></i>
					</span>
					Forward to Final Reviewer
				</a>
			@endif
			@if($request_master->status == 18 && $isAlletComment)
			
				<a href="{{url('request_masters/change_status/'.$request_master->id.'/20')}}" class="btn btn-sm btn-primary">
					<span style="font-size: 10px;">
						<i class="fas fa-paper-plane"></i>
					</span>
					Forward to Prepare
				</a>
				<a href="{{url('request_masters/change_status/'.$request_master->id.'/30')}}" class="btn btn-sm btn-primary">
					<span style="font-size: 10px;">
						<i class="fas fa-paper-plane"></i>
					</span>
					Forward to Reviewer One
				</a>
				<a href="{{url('request_masters/change_status/'.$request_master->id.'/40')}}" class="btn btn-sm btn-primary">
					<span style="font-size: 10px;">
						<i class="fas fa-paper-plane"></i>
					</span>
					Forward for Final Review
				</a>
			@endif
		@endif
		</div>
	@endif
	@if($isAllQueryClosed && $request_master->status >= 20)
		<div class="card-footer">
		@if($request_master->status < 40)
			@if($login_user->id!=$request_master->npsg_reviewer_1)
			<a href="{{url('request_masters/change_status/'.$request_master->id.'/30')}}" class="btn btn-sm btn-primary">
				<span style="font-size: 10px;">
					<i class="fas fa-paper-plane"></i>
				</span>
				Forward to Reviewer One
			</a>
			@endif
			@if($login_user->id!=$request_master->npsg_reviewer_2)
			<a href="{{url('request_masters/change_status/'.$request_master->id.'/40')}}" class="btn btn-sm btn-primary">
				<span style="font-size: 10px;">
					<i class="fas fa-paper-plane"></i>
				</span>
				Forward for Final Review
			</a>
			@endif
		@endif
		@if($request_master->status == 40 || $request_master->status == 45)
		<a href="{{url('request_masters/change_status/'.$request_master->id.'/50')}}" class="btn btn-sm btn-primary">
			<span style="font-size: 10px;">
				<i class="fas fa-paper-plane"></i>
			</span>
			Send For signoff to Manager
		</a>
		@endif
		@if($request_master->status == 50 && $login_user->id==$request_master->et_manager)
		<a href="{{url('request_masters/change_status/'.$request_master->id.'/55')}}" class="btn btn-sm btn-primary">
			<span style="font-size: 10px;">
				<i class="fas fa-paper-plane"></i>
			</span>
			Send For signoff to Partner
		</a>
		@endif
		@if($request_master->status == 55 && $login_user->id==$request_master->et_partner)
		<a href="{{url('request_masters/change_status/'.$request_master->id.'/60')}}" class="btn btn-sm btn-primary">
			<span style="font-size: 10px;">
				<i class="fas fa-paper-plane"></i>
			</span>
			Send For signoff to Preapare
		</a>
		@endif
		@if($request_master->status == 60 && $login_user->id==$request_master->npsg_prepare)
		<a href="{{url('request_masters/change_status/'.$request_master->id.'/65')}}" class="btn btn-sm btn-primary">
			<span style="font-size: 10px;">
				<i class="fas fa-paper-plane"></i>
			</span>
			Send For signoff to Reviewer One
		</a>
		@endif
		@if($request_master->status == 65 && $login_user->id==$request_master->npsg_reviewer_1)
		<a href="{{url('request_masters/change_status/'.$request_master->id.'/70')}}" class="btn btn-sm btn-primary">
			<span style="font-size: 10px;">
				<i class="fas fa-paper-plane"></i>
			</span>
			Send For signoff to Final Reviewer
		</a>
		@endif
		@if($request_master->status == 70 && $login_user->id==$request_master->npsg_reviewer_2)
		<a href="{{url('request_masters/change_status/'.$request_master->id.'/75')}}" class="btn btn-sm btn-primary">
			<span style="font-size: 10px;">
				<i class="fas fa-paper-plane"></i>
			</span>
			Signoff Completed
		</a>
		@endif
		</div>
	@endif
</div>
<!--End List Of Initial Query -->
<!--End Add Initial Query -->

<div class="modal fade" id="addInitialQuery" tabindex="-1" role="dialog" aria-labelledby="addInitialQueryLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addInitialQueryLabel">Add Initial Query</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  {!!Form::open(['route'=>['backend.initial_queries.add'],'files'=>true,'class'=>'form-horizontal'])!!}
	  <input class="form-control"   name="request_master_id" value="{{$request_master->id}}" type="hidden">
            <div class="mb-3 row">
				<label for="npsgPrepare" class="col-sm-12 col-form-label">	Standalone / Consolidated Financial Statement	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control"   name="scfs" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">Page Number of Annual report	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control"   name="pnar" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">Heading of Disclosure	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control"   name="head_discloser" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">	Financial Statement Heading (FSLI)	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control"   name="fsli" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">	Topic (give heading)	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control"   name="topic" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">	Detailed Comment	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control"   name="detail_comment" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">	Rational<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control"   name="rational" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">	Techincal Reference	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control"   name="technical_refercene" type="text">
				</div>
			</div>
			
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Initial Query</button>
        </div>
		{!!Form::close()!!}
    </div>
  </div>
</div>
<!--Start Edit Initial Query -->
<div class="modal fade" id="editInitialQuery" tabindex="-1" role="dialog" aria-labelledby="editInitialQueryLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editInitialQueryLabel">Add Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  {!!Form::open(['route'=>['backend.initial_queries.update'],'files'=>true,'class'=>'form-horizontal'])!!}
      <input id="editInitialQueryLidden"  name="initial_query_id" type="hidden">
            <div class="mb-3 row">
			<label for="npsgPrepare" class="col-sm-12 col-form-label">	Standalone / Consolidated Financial Statement	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control" id="scfs"   name="scfs" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">Page Number of Annual report	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control" id="pnar"   name="pnar" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">Heading of Disclosure	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control" id="head_discloser"  name="head_discloser" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">	Financial Statement Heading (FSLI)	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control" id="fsli"   name="fsli" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">	Topic (give heading)	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control" id="topic"  name="topic" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">	Detailed Comment	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control" id="detail_comment"  name="detail_comment" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">	Rational<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control" id="rational"  name="rational" type="text">
				</div>

				<label for="npsgPrepare" class="col-sm-12 col-form-label">	Techincal Reference	<span class="required">*</span></label>
				<div class="col-sm-12">
				<input class="form-control" id="technical_refercene"   name="technical_refercene" type="text">
				</div>
			</div>
			
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
		{!!Form::close()!!}
    </div>
  </div>
</div>
<!--End Edit Initial Query -->

<!--Start Add ET Comment -->
<div class="modal fade" id="addCommentEt" tabindex="-1" role="dialog" aria-labelledby="addCommentEtLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCommentEtLabel">Add Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  {!!Form::open(['route'=>['backend.comments.add_et_comment'],'files'=>true,'class'=>'form-horizontal'])!!}
      <input id="addCommentEtLidden"  name="initial_query_id" type="hidden">
            <div class="mb-3 row">
				<label for="npsgPrepare" class="col-sm-12 col-form-label">	ET Response<span class="required">*</span></label>
				<div class="col-sm-12">
					<textarea class="form-control" name="comment1"></textarea>
				</div>
			</div>
			<div class="mb-3 row">
				<label for="npsgReviewer" class="col-sm-12 col-form-label">Technical Refernece<span class="required">*</span></label>
				<div class="col-sm-12">
					<textarea class="form-control" name="comment2"></textarea>
				</div>
			</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Comment</button>
        </div>
		{!!Form::close()!!}
    </div>
  </div>
</div>
<!--End Add ET Comment -->



<!--Start Add Reviewer Comment -->
<div class="modal fade" id="addCommentReviewer" tabindex="-1" role="dialog" aria-labelledby="addInternalCommentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCommentReviewerLabel">Add Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  {!!Form::open(['route'=>['backend.comments.add_npsg_comment'],'files'=>true,'class'=>'form-horizontal'])!!}
      <input id="addCommentReviewerLidden" name="initial_query_id" type="hidden">
            <div class="mb-3 row">
				<label for="npsgPrepare" class="col-sm-12 col-form-label">Remarks<span class="required">*</span></label>
				<div class="col-sm-12">
					<textarea class="form-control" name="comment1"></textarea>
				</div>
			</div>
			<div class="mb-3 row">
				<label for="npsgPrepare" class="col-sm-12 col-form-label">Prepare User<span class="required">*</span></label>
				<div class="col-sm-12">
					<select id="npsgPrepare" name="status" class="form-control" required>
						<option value="">---Select Status---</option>
						<option value="Open">Open</option>
						<option value="Close">Close</option>
					</select>
				</div>
			</div>
			<div class="mb-3 row">
				<label for="npsgReviewer" class="col-sm-12 col-form-label">Final Conclusion<span class="required">*</span></label>
				<div class="col-sm-12">
					<textarea class="form-control" name="comment2"></textarea>
				</div>
			</div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit Review</button>
			
        </div>
		{!!Form::close()!!}
    </div>
  </div>
</div>
<!--End Add Reviewer Comment -->

<!--Start Add Internal Comment -->
<div class="modal fade" id="addInternalComment" tabindex="-1" role="dialog" aria-labelledby="addInternalCommentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addInternalCommentLabel">Add Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  {!!Form::open(['route'=>['backend.internal_comments.add'],'files'=>true,'class'=>'form-horizontal'])!!}
      <input id="addInternalCommentLidden" name="initial_query_id" type="hidden">
            <div class="mb-3 row">
				<label for="npsgPrepare" class="col-sm-12 col-form-label">Remarks<span class="required">*</span></label>
				<div class="col-sm-12">
					<textarea class="form-control" name="comment"></textarea>
				</div>
			</div>
		
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit Review</button>
			
        </div>
		{!!Form::close()!!}
    </div>
  </div>
</div>
<!--End Add Internal Comment -->
@endsection

@section('script')
<script>
    $('#addCommentEt').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('rmid') // Extract info from data-* attributes
	var sr_no = button.data('sr_no') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('#addCommentEtLabel').text('Add Comment by ET Team for #' + sr_no)
    modal.find('#addCommentEtLidden').val(id)
    })
	$('#addCommentReviewer').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('rmid') // Extract info from data-* attributes
	var sr_no = button.data('sr_no') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('#addCommentReviewerLabel').text('Add Comment by NPSG Teamfor #' + sr_no)
    modal.find('#addCommentReviewerLidden').val(id)
    })
	$('#addInternalComment').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('rmid') // Extract info from data-* attributes
	var sr_no = button.data('sr_no') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('#addInternalCommentLabel').text('Add Internal Comment For NPSG Teamfor #' + sr_no)
    modal.find('#addInternalCommentLidden').val(id)
    })
	$('#editInitialQuery').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('rmid') // Extract info from data-* attributes
	var sr_no = button.data('sr_no') // Extract info from data-* attributes
	var scfs = button.data('rmscfs') // Extract info from data-* attributes
	var pnar = button.data('rmpnar') // Extract info from data-* attributes
	var head_discloser = button.data('rmhead_discloser') // Extract info from data-* attributes
	var fsli = button.data('rmfsli') // Extract info from data-* attributes
	var topic = button.data('rmtopic') // Extract info from data-* attributes
	var detail_comment = button.data('rmdetail_comment') // Extract info from data-* attributes
	var rational = button.data('rmrational') // Extract info from data-* attributes
	var technical_refercene = button.data('rmtechnical_refercene') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('#editInitialQueryLabel').text('Add Internal Comment For NPSG Teamfor #' + sr_no)
    modal.find('#editInitialQueryLidden').val(id)
	modal.find('#scfs').val(scfs)
	modal.find('#pnar').val(pnar)
	modal.find('#head_discloser').val(head_discloser)
	modal.find('#fsli').val(fsli)
	modal.find('#topic').val(topic)
	modal.find('#detail_comment').val(detail_comment)
	modal.find('#rational').val(rational)
	modal.find('#technical_refercene').val(technical_refercene)
    })
	var pathname = window.location.hash.substr(1);;
	var current_pos = $('#'+pathname).position().top;
	$(document).ready(function () {
		$(".v-height-100").scrollTop(current_pos);
	});
	
</script>
@endsection
