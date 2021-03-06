@extends('admintemplate')

@section('content')

@if(Session::get('regadmin'))
<div class="nNote {{ Session::get('regadmin') }}">
    <p>{{ Session::get('addmsg') }}</p>
</div>
@endif

<div class="fluid">
    <div class="widget grid12">
        <div class="whead"><h6>Product Form</h6><div class="clear"></div></div>
        @foreach($errors->all('<p style="text-align: center">:message</p>') as $message)
            {{ $message }}
        @endforeach
        <div class="body">
        	<!-- <form method="put" action="{{ URL::route('admin.products.update',$product->id) }}" id="frmnewproduct" enctype="multipart/form-data"> -->
            {{ Form::open(array('route' => array('admin.products.update',$product->id),'files'=>true,'method'=>'put')) }}
        		<div class="formRow">
                    <div class="grid3"><label>Product Name:</label></div>
                    <div class="grid9"><input type="text" name="product_name" value="{{ $product->product_name }}" class="required"/></div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>Short Description(thumbnail):</label></div>
                    <div class="grid9">
                        <textarea rows="8" class="auto lim" name="short_description">{{ $product->short_description }}</textarea>
                        <span class="note" id="limitingtext">Field limited to 200 characters.</span>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>Product Details:</label></div>
                    <div class="grid9" style="border: 1px solid #d7d7d7">
                        <textarea id="editor" name="product_details" rows="" cols="16" class="required">{{ $product->product_details }}</textarea>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <div class="grid3"><label>Categories:</label></div>
                    <div class="grid9">
                        <select data-placeholder="Select category here" class="fullwidth select required" multiple="multiple" tabindex="6" name="categories[]">
                            <option value=""></option>
                            @foreach($maincat as $mc)

                            <optgroup label="{{ $mc->occasion_type }}">
                                <?php $cats = Occasion::where('occasion_type','=',$mc->id)->get(); ?>
                                @foreach($cats as $cat)
                                <option value="{{ $cat->id }}" {{ in_array($cat->id,$product_occs) ? 'selected':'' }}>{{ $cat->occasion_name }}</option>
                                @endforeach
                            </optgroup>

                            @endforeach
                            
                        </select>  
                    </div>             
                    <div class="clear"></div>
                </div>

                <div class="formRow">
                    <div class="grid3"><label>Tags:</label></div>
                    <div class="grid9">
                        <input type="text" id="tags" name="tags" class="tags" value="{{ $product->tags }}" />
                        <span>*To multiple tags, press "ENTER" on every other tag that you indicate.</span>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>Recipient:</label></div>
                    <div class="grid9 check">
                        @foreach($recipients as $row)

                        <input type="checkbox" {{ in_array($row->recipient_id,$product_recipient) ? 'checked':'' }} name="recipient[]" value="{{ $row->recipient_id }}" />
                        <label for="check1"  class="mr20">{{ $row->recipient }}</label>

                        @endforeach
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>Product Location:</label></div>
                    <div class="grid9 check">
                        @foreach($states as $row1)

                        <input type="checkbox" {{ in_array($row1->state,$product_location) ? 'checked':'' }} name="product_location[]" value="{{ $row1->state }}"/>
                        <label for="check1"  class="mr20">{{ $row1->state }}</label>
                        <div class="clear"></div>

                        @endforeach
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>Price:</label></div>
                    <div class="grid9 enabled_disabled">
                        <div class="floatL mr10"><input type="text" name="price" value="{{ $product->price }}" class="required" /></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>Validity: </label></div>
                    <div class="grid9 enabled_disabled">
                        <div class="floatL mr10"><input type="text" name="validity" value="{{ $product->validity }}" /></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>Free exchange: </label></div>
                    <div class="grid9 on_off">
                        <div class="floatL mr10"><input type="checkbox" id="check20" {{ $product->free_exchange ? 'checked':'' }} name="free_exchange" /></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>Delivery Date: </label></div>
                    <div class="grid9 enabled_disabled">
                        <div class="floatL mr10"><input type="text" name="delivery_date" value="{{ date('m-d-Y',strtotime($product->delivery_date)) }}" class="datepicker"/></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <div class="grid3"><label>Delivery Cost: </label></div>
                    <div class="grid9 enabled_disabled">
                        <div class="floatL mr10"><input type="text" name="delivery_cost" value="{{ $product->delivery_cost }}" /></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">    
                    <div class="grid3"><label>Upload image(s): </label></div>
                    <div class="grid9">
                        <div class="floatL mr10"><input type="file" name="imgs[]" multiple class="upl" /></div>
                        <span class="num-file"></span>
                    </div>
                    <div class="gallery">
                        @if(count($imgs) > 0)
                        <ul>
                            @foreach($imgs as $img)
                            <li style="height:80px;width: 93px;">
                                <a href="{{ URL::to('/') }}/uploads/products/{{ $img->image }}" title="" class="lightbox">
                                    <img src="{{ URL::to('/') }}/uploads/products/smallthumb_{{ $img->image }}" alt="" />
                                </a>
                                <span><a href="#" url="{{ $url }}?id={{ $img->pi_id }}&pid={{ $img->product_id }}" class="delssimg" style="display: inline-block">Delete</a></span> | <span><a href="" style="display: inline-block">Primary</a></span>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p>No image uploaded</p>
                        @endif
                    </div>
                    <div class="clear"></div>               
                </div>
                <div class="formRow">
                    <a href="#" class="buttonM bRed ml10 floatR" id="modal_open">Delete this product</a>
                    <input type="submit" class="buttonL bGreen floatR" value="+ Update Product" />
                    <div class="clear"></div>
                </div>
        	</form>
        </div>
    </div>
</div>

{{ Form::open(array('route' => array('admin.products.destroy',$product->id),'method'=>'delete','id'=>'frmdestroyprod')) }}</form>

<div id="dialog-modal" title="Please confirm...">
    <p>Are you sure you want to delete this product?</p>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#frmnewproduct').validate();

    $('.upl').change(function(){
        var n = $("input:file")[0].files.length;
        $('.num-file').text(n+' file(s)');
    });

    $('.delssimg').click(function(){
        var a = confirm("Are you sure you want to delete this image?");
        var url = $(this).attr('url');

        if(a)
            window.location.href = url;
    });
});
</script>

@endsection

@section('subnav')

    @include('admin.products.psubnav')

@endsection