<div class="form-body">
    <div class="row">
		<div class="col-md-12">
    <div class="form-group">
    	{!! Form::label('title', 'Title') !!}
        {!! Form::text('title', (isset($coupon) ? $coupo->title : ''), ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    </div>
</div><div class="col-md-12">
    <div class="form-group">
    	{!! Form::label('code', 'Code') !!}
        {!! Form::text('code', (isset($coupon) ? $coupo->code : ''), ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
    </div>
</div><div class="col-md-12">
    <div class="form-group">
    	{!! Form::label('off_amount', 'Off Amount') !!}
        {!! Form::number('off_amount', (isset($coupon) ? $coupo->off_amount : 0.00), ['id' => 'off_amount', 'class' => 'form-control', 'required' => 'required', 'step' => '.01']) !!}
    </div>
</div><div class="col-md-12">
    <div class="form-group">
    	{!! Form::label('off_percentage', 'Off Percentage') !!}
        {!! Form::number('off_percentage', (isset($coupon) ? $coupo->off_percentage : 0), ['id' => 'off_percentage', 'class' => 'form-control', 'required' => 'required', 'step' => '.01']) !!}
    </div>
</div>
	</div>
</div>
<div class="form-actions text-right pb-0">
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
