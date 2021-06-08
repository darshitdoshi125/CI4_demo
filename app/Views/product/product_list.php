<div class="row">
    <div class="col-xs-12">
        <div class="box">
	        <div class="box-header">
              <h3 class="box-title">View Users</h3>
            </div>
            <div class="alert alert-success alert-dismissible" id="up_msg_area" style="margin:10px;display:none;">
            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            		<i class="fa fa-times"></i></button>
            	<span id="up_msg_action"></span>
          	</div>  	
        	<div class="col-sm-12 button-manage">
            	<div class="m-b-10">
                	<input type="button" name="submit" id="del_btn" onclick="deleteproduct('0','lists','remove_product')" value="Delete" class="btn btn-danger" />

                    <a href="<?= site_url('add-product'); ?>" class="btn btn-info" >Add Product</a>
            	</div>
        	</div>
        	<div class="row"></div>
        	<div class="box-body table-responsive">
          		<table id="table_user" class="table table-bordered table-hover">
                	<thead>
                    <tr>
         				<th>
							<div class="flat-grey single-row">
								<input type="checkbox" name="" id="del_chk" class="table_ckbox"/>
							</div>
						</th>
						<th>Image</th>
						<th>Product Name</th>
						<th>Description</th>
						<th>Price</th>
						<th>Stock</th>
						<th>Status</th>
						<th>action</th>
                    </tr>
                	</thead>
                    <tbody></tbody>
            	</table>
    		</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(e){
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            }
        });
        $('.table_ckbox').iCheck
        ({
            checkboxClass: 'icheckbox_flat-grey'
        });
        oTable = $('#table_user').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?= site_url('ajax-load-product-data') ?>",
            oLanguage: {
                "sProcessing": "<img src='<?= site_url('assets/admin/images/admin_preloader.GIF'); ?>'>",
            },
            order: [[ 0, "DESC" ]],
            columns: [
                {
                    "defaultContent": "null", "render": function(data,type,row,meta) {
                        return '<div class="flat-grey single-row"><input type="checkbox" name="lists[]" class="all_del" value="'+ row.id +'"></div>';
                    }
                },
                {
                    "defaultContent": "null", "render": function(data,type,row,meta) {
                        if(row.product_image != '') {
                            return '<img src="<?= site_url(); ?>uploads/product/'+row.product_image+'" height=100 width=100 />';
                        }
                        else {
                            return '<img src="<?= site_url(); ?>assets/admin/images/no_image.gif" height=100 width=100 />';
                        }
                    }
                },
                { data: 'product_name', name: 'product_name' },
                { data: 'description', name: 'description' },
                { data: 'price', name: 'price' },
                { data: 'stock', name: 'stock' },
                {
                    "defaultContent": "null", "render": function(data,type,row,meta) {
                        var is_checked = (row.status == 'active') ? 'checked' : '';
                        var status = (row.status == 'active') ? '1' : '0';
                        return '<div id="div'+ row.id +'"><div class="switchery-demo"><div><input type="checkbox" data-plugin="switchery" data-color="#00b19d" data-size="small" id="js-switch'+ row.id +'" class="js-switch" '+is_checked+' onchange="return change_block_status('+ row.id +','+status+')" /></div></div></div>';
                    }
                },
                {
                    "defaultContent": "null", "render": function(data,type,row,meta) {
                        return '<a class="btn-success btn btn-sm" href="edit-product/'+row.id+'"><i class="fa fa-edit"></i> Edit</a>'+ ' <a class="btn-danger btn btn-sm" onclick="deleteproduct('+ row.id +')" href="javascript:void(0)"><i class="fa fa-trash"></i> Delete</a>';
                    }
                },
            ],
            'createdRow': function( row, data, dataIndex ) {
                $(row).attr('id', 'row_'+data.id);
            },
            columnDefs: [
                { "orderable": false, "targets": [0,7] },
            ],
            fnDrawCallback: function()
			{
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

                elems.forEach(function(html) {
                    var switchery = new Switchery(html);

                });
				console.log(elems);
                
				$('.all_del').iCheck
				({
					checkboxClass: 'icheckbox_flat-grey'
				});
				$('.as_tooltips').tooltip();
			}
        });
        $("#del_chk").on('ifClicked', function () {
            $('#del_chk').on('ifChecked', function (event) {
                $('.all_del').prop('checked', false);
                $('.all_del').iCheck('check');
            });
            $('#del_chk').on('ifUnchecked', function (event) {
                $('.all_del').prop('checked', true);
                $('.all_del').iCheck('uncheck');
            });
        }); 
    });
    function change_block_status(id,flag) {
        var form_data = {
            id:id,
            flag:flag
        };
        $.ajax
        ({
            url:'<?= site_url("change-block-status"); ?>',
            data:form_data,
            type:'POST',
            success:function(data) 
            {
                if (flag == 1) {
                    $('#up_msg_action').html('Brand Active Successfully.');
                } 
                else {
                    $('#up_msg_action').html('Brand Inactive Successfully.');
                }
                $('#up_msg_area').css('display','block');
                setTimeout(function()
                {
                    $('#up_msg_area').stop().slideUp('slow');
                }, 4000);
                check_verify = (flag == 0) ? 'checked' : '';
                verify_status = (flag == 0) ? '1' : '0';
                $("#div"+id).html('<div class="switchery-demo"><div><input type="checkbox" id="js-switch'+id+'" class="js-switch" '+check_verify+' onchange="return change_block_status('+id+','+verify_status+')" /></div></div>');
                    
                var elems = Array.prototype.slice.call(document.querySelectorAll('#js-switch'+id));
                elems.forEach(function(html) 
                {
                    var switchery = new Switchery(html);

                });
            }
        });
    }
    function deleteproduct(id) {
        var list = [];
        if (id != 0)
        {
            list.push(id);
        } else
        {
            $.each($("input[name='lists[]']:checked"), function()
            {
                list.push($(this).val());
            });
        }
        var list_array = list.join(",");
        if(list_array == '') {
            alert('Please select items to remove.');
            return false;
        }
        else {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this data!.",
                type: "error",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: "Delete"
            },
            function(isConfirm)
            {
                if (isConfirm)
                {
                    var form_data =
                    {
                        list_array:list_array,
                    };

                    $.ajax({
                        url:"<?= site_url('delete-product'); ?>",
                        type:"POST",
                        data:form_data,
                        success:function(data)
                        {
                            swal("Deleted!", "Data deleted successfully.", "success");
                            window.location.reload();
                        }
                    });
                }
                else
                {
                    swal("Cancelled", "Your data is safe", "error");
                }
            });
        }
    }

</script>