var baseUrl = $('#baseUrl').val();

var adminUrl = $('#adminUrl').val();





function checkStoreName(store_name) {

	$.ajax({

		url: adminUrl+'profile/check_store_name',

		type: 'post',

		dataType: 'html',

		data: {storeName: store_name},

	})

	.done(function(data) {

		if (data=='') {

			$('input:submit').attr('disabled', 'disabled');

		} else {

			$('input:submit').removeAttr('disabled');

		}

		$('#store-name-field').text(data);

	})

	.fail(function(data) {

		console.log(data);

	});

}





function CategoryListing(bId) {

	$.ajax({

		url: adminUrl+'products/get_category',

		type: 'post',

		dataType: 'html',

		data: {bazarId: bId},

	})

	.done(function(data) {

		$('#category').html(data);

	})

	.fail(function(data) {

		console.log(data);

	});

}





function subCategoryListing(cId) {

	$.ajax({

		url: adminUrl+'products/get_subcategory',

		type: 'post',

		dataType: 'html',

		data: {categoryId: cId},

	})

	.done(function(data) {

		$('#subCategory').html(data);

	})

	.fail(function(data) {

		console.log(data);

	});

}





function autoGenerateUrl(data) {

	var outputString = data.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/?])+/g,'').replace(/([\s])+/g,'-').replace(/^(-)+|(-)+$/g,'');

	$('input#autoFillUrl').val(outputString.toLowerCase());

}



$('#autoGenerateUrl').on('focus, keyup, keydown focusout', function(event) {

	autoGenerateUrl($(this).val());

});



function changeFAQStatus(id, thisSwitch) 
{
	var newStatus;
	if (thisSwitch.val() == 1) {
		thisSwitch.val('0');
		newStatus = '0';
	} else {
		thisSwitch.val('1');
		newStatus = '1';
	}
	$.ajax({
		url: adminUrl+'faq/changeStatus',
		type: 'POST',
		dataType: 'json',
		data: {
			status: String(newStatus),
			faqId: id
		},
	})
	.done(function(data) {
		alert_func(data);
	})

	.fail(function(data) {
		console.log(data);
	});	

}



function changeCategoryStatus(cId, thisSwitch) {
	var newStatus;
	if (thisSwitch.val() == 1) {
		thisSwitch.val('0');
		newStatus = '0';
	} else {
		thisSwitch.val('1');
		newStatus = '1';
	}

	$.ajax({
		url: adminUrl+'category/changeStatus',
		type: 'POST',
		dataType: 'json',
		data: {
			categoryId: String(cId),
			status: String(newStatus)
		},

	})

	.done(function(data) {
		alert_func(data);

	})

	.fail(function(data) {
		console.log(data);

	});	

}





function changeSubCategoryStatus(sId, thisSwitch) {

	var newStatus;

	if (thisSwitch.val() == 1) {

		thisSwitch.val('0');

		newStatus = '0';

	} else {

		thisSwitch.val('1');

		newStatus = '1';

	}

	$.ajax({

		url: adminUrl+'subcategory/changeStatus',

		type: 'POST',

		dataType: 'json',

		data: {

			subcategoryId: String(sId),

			status: String(newStatus)

		},

	})

	.done(function(data) {

		alert_func(data);

	})

	.fail(function(data) {

		console.log(data);

	});

}





function deleteProductImage(imageName, imageId, thisBtn) {

	swal({

		title: 'Are You sure want to delete this image?',

		type: 'warning',

		showCancelButton: true,

		confirmButtonColor: '#A5DC86',

		cancelButtonColor: '#DD6B55',

		confirmButtonText: 'Yes',

		cancelButtonText: 'No',

		closeOnConfirm: true,

		closeOnCancel: true

	}, function(isConfirm){

		if (isConfirm) {

			$.ajax({

				url: adminUrl+'products/delete_product_image',

				type: 'POST',

				dataType: 'json',

				data: {

					productImageId: imageId,

					productImageName: imageName

				},

			})

			.done(function(data) {

				thisBtn.parent('.thumbnail').parent('.fileinput.fileinput-new').remove();

				alert_func(data);

			})

			.fail(function(data) {

				console.log(data);

			});

		}

	});

}





function showEnquiryDetails(enqId) {
	$.ajax({
		url: adminUrl+'enquiry/view',
		type: 'POST',
		dataType: 'html',
		data: {
			enquiryId: enqId,
		},

	})

	.done(function(res) {

		var data = res.trim();

		if (res != '') {

			if (res == 'noEnquiry') {

				alert_func(["Updated successfully!", "success", "#A5DC86"]);

			} else {

				$('#view-enquiries-modal .modal-body').html(res);

				$('#view-enquiries-modal').modal('show');

			}

		}

	})

	.fail(function(data) {

		console.log(data);

	});

}





function changeEnquiryStatus(enqId, thisElement) {

	var newStatus = String(thisElement.val());

		console.log(enqId);

		console.log(newStatus);

	$.ajax({

		url: adminUrl+'enquiry/changeStatus',

		type: 'POST',

		dataType: 'json',

		data: {

			enquiryId: String(enqId),

			status: String(newStatus),

		},

	})

	.done(function(data) {

		console.log(data);

		$('#view-enquiries-modal').modal('hide');

		if (data[1] == 'success') {

			if (String(newStatus) == '1') {

				$('#status-id-'+enqId).html('<h4 class="label label-success">Replied</h4>');

			} else {

				$('#status-id-'+enqId).html('<h4 class="label label-warning">Pending</h4>');

			}

		}

		swal({

			title: data[0],

			type: data[1],

			showCancelButton: false,

			confirmButtonColor: data[2],

			confirmButtonText: 'Ok',

			closeOnConfirm: true

		}, function(isConfirm){

			if (isConfirm) {

				$('#view-enquiries-modal').modal('show');

			}

		});

	})

	.fail(function(data) {

		console.log(data);

	});

}

function changeRewardProductStatus(pId, newStatus) {

	$.ajax({

		url: adminUrl+'rewards/products_change_status',

		type: 'POST',

		dataType: 'json',

		data: {

			productStatus: String(newStatus),

			productId: pId

		},

	})

	.done(function(data) {

		alert_func(data);

	})

	.fail(function(data) {

		console.log(data);

	});	

}