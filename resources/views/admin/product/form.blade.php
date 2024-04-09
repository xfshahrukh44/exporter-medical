<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
               {!! Form::Label('item', 'Select Category:') !!}
               {!! Form::select('item_id', $items, isset($product)?$product->category:null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                 <label for="">SubCategory</label>
                <select name="subcategory" class="form-control">
                    @foreach($subcategory as $key => $value)
                        <option {{($product->subcategory == $value->id) ? 'selected': ''}} value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
               {!! Form::label('product_title', 'Product Title') !!}
               {!! Form::text('product_title', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">List Price ($)</label>
                <input type="number" class="form-control" value="{{$product->list_price}}" name="list_price" step="0.01" placeholder="10.00">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Standard Price ($)</label>
                <input type="number" class="form-control" value="{{$product->stand_price}}" name="stand_price" step="0.01" placeholder="10.00">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">SKU</label>
                <input type="text" class="form-control" value="{{$product->sku}}" name="sku">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Item Number</label>
                <input type="text" class="form-control" value="{{$product->item_number}}" name="item_number">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Weight</label>
                <input type="number" class="form-control" value="{{$product->weight}}" name="weight" step="0.01" placeholder="10.00">
            </div>
        </div>
        <div class="col-md-12" style="display: none;">
            <div class="form-group">
                <label for="">Stock</label>
                <input type="number" class="form-control" value="{{($product->stock) ? $product->stock : 5}}" name="stock">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Vendor</label>
                <input type="number" class="form-control" name="vendor" value="{{$product->vendor}}" step="0.01" placeholder="10.00">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Length</label>
                <input type="number" class="form-control" name="length" value="{{$product->length}}" step="0.01" placeholder="10.00">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Width</label>
                <input type="number" class="form-control" value="{{$product->width}}" name="width">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Height</label>
                <input type="number" class="form-control" value="{{$product->height}}" name="height">
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('featured', 'Featured') !!}
              <select name="is_featured" id="" class="form-control">
                  <option {{($product->is_featured == 0) ?  'selected' : ''}} value="0">No</option>
                <option {{($product->is_featured == 1) ?  'selected' : ''}} value="1">Yes</option>
              </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('description', 'Description') !!}
                {!! Form::textarea('description', null, ('required' == 'required') ? ['class' => 'form-control', 'id' => 'summary-ckeditor', 'required' => 'required'] : ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('image', 'Image') !!}
                <input class="form-control dropify" name="image" type="file" id="image" {{ ($product->image != '') ? "data-default-file = /$product->image" : ''}} {{ ($product->image == '') ? "required" : ''}} value="{{$product->image}}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('additional_image', 'Gallary Image') !!}
                <div class="gallery Images">
                @foreach($product_images as $product_image)
                <div class="image-single">
                <img src="{{ asset( $product_image->image)}}" alt="" id="image_id">
                <button type="button" class="btn btn-danger" data-repeater-delete="" onclick="getInputValue({{$product_image->id}}, this);"> <i class="ft-x"></i>Delete</button>
                </div>
                @endforeach
                </div>
                <input class="form-control dropify" name="images[]" type="file" id="images" {{ ($product->additional_image != '') ? "data-default-file = /$product->additional_image" : ''}} value="{{$product->additional_image}}" multiple>
            </div>
        </div>
     
    </div>
</div>

<div class="form-actions text-right pb-0">
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
