<?php
$product_id = 0;
if(isset($product_data) && !empty($product_data))
{
	$product_id = $product_data->id;
	$product_name = $product_data->product_name;
	$price = $product_data->price;
	$stock = $product_data->stock;
	$description = $product_data->description;
	$image = $product_data->product_image;
}


?>

<div class="row">
	<div class="col-md-12">
		<div class="btn-group pull-right m-t-5 m-b-20">
			<a href="<?= site_url('product-list'); ?>" class="btn btn-custom waves-effect waves-light">
				Back
			</a>
		</div>
	</div>
    <div class="col-md-12">
      	<div class="box">
        	<div class="box-header with-border">
          		<h3 class="box-title"><?= $title;?></h3>
        	</div>
        	<div class="col-md-12" id="product_error"></div>
        	<form method="post" id="product-frm" name="product-frm" action="javascript:void(0)" enctype="multipart/form-data" autocomplete="off">
	        	<input type="hidden" name="product_id" id="product_id" value="<?= @$product_id;?>">
                <div class="box-body">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Name</label>
                            <input type="text" name="product_name" id="product_name" placeholder="" class="form-control"  style="" value="<?= @$product_name;?>">
                            <span id="error_product_name">
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="text" name="price" id="price" placeholder="" class="form-control"  style="" value="<?= @$price;?>">
                            <span id="error_price">
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Stock</label>
                            <input type="text" name="stock" id="stock" placeholder="" class="form-control"  style="" value="<?= @$stock;?>">
                            <span id="error_stock">
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Product Image</label>
                            <input type="file" name="product_image" id="product_image" placeholder="" class="form-control"  style="" value="<?= @$image;?>">
                            <span id="error_product_image">
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description" placeholder="Enter Description"><?= @$description;?></textarea>
                            <span id="error_description">
                            </span>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <div class="col-lg-12">
                            <div class="box-footer">
                                <button type="reset" class="btn btn-default" onclick="javascript:history.go(-1);">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="btnSave" id="btnSave">Submit</button>
                            </div>
                        </div>
                    </div>
        
                </div>
        	</form>
      	</div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function()
{
	
	$('#product-frm').validate
	({
        rules:
        {
            product_name:
            {
                required: true,
                remote:{
                    url: "<?= site_url('check-product');?>",
                    type:"POST",
                    data:{ product_id: '<?= @$product_id;?>' },
                }
            },
            price:
            {
                required: true,
                number: true
            },
            stock:
            {
                required: true,
                number: true
            },
            product_image:
            {
                required:function(element)
                {
                    return $("#product_id").val() == '0';
                },
                //extension: "png|jpg|jpeg|PNG|JPG|JPEG"
            },
            description:
            {
                required: true,
            },
        },
        messages:
        {
            product_name:
            {
                required: "Please enter product name",
            },
            price:
            {
                required: "Please enter price",
            },
            stock:
            {
                required: "Please enter stock",
            },
            product_image:
            {
                required: "Please upload product image",
            },
            description:
            {
                required: "Please enter description",
            },
        },
        submitHandler: function(form)
        {
            $("#btnSave").attr('disabled','true');
            var form_data = new FormData();
            var files = $('#product_image')[0].files;
            
            form_data.append('id',$('#product_id').val());
            form_data.append('product_name',$('#product_name').val());
            form_data.append('price',$('#price').val());
            form_data.append('stock',$('#stock').val());
            form_data.append('description',$('#description').val());
            form_data.append('file',files[0]);

            $.ajax({
                url:"<?= site_url("save-product")?>",
                data:form_data,
                type:'POST',
                contentType: false,
                processData: false,
                success:function(result)
                {
                    if (result.success == true) {
                        $("#product_error").html('<div id="error_product" class="alert alert-success">'+result.msg+'</div>');
                        setTimeout(function () {
                            $("#error_product").css( "display", "none" );
                            window.location.href = "<?= site_url('product-list')?>";
                            $("#btnSave").attr('disabled',false);
                        },3000);
                    }
                    else {
                        $("#product_error").html('<div id="error_product" class="alert alert-danger">'+result.msg+'</div>');
                        setTimeout(function () {
                            $("#error_product").css( "display", "none" );
                            $("#btnSave").attr('disabled',false);
                        },3000);
                    }
                }
            });
            setTimeout(function () {$("#btnSave").removeAttr('disabled');},4000);
            return false;
        }
    });
});

</script>