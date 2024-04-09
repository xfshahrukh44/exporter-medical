<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label> Select Main Category</label>
                <select name="category" id="e1" class="form-control select2">
                @foreach ($category as $categories)
                <option {{ ($categories->id == $subcategory->category)? 'selected':'' }} value="{{ $categories->id }}">{{ $categories->name }}</option>
                @endforeach

                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text(
                    'name',
                    null,
                    'required' == 'required' ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control'],
                ) !!}
            </div>
        </div>
    </div>
</div>
<div class="form-actions text-right pb-0">
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
