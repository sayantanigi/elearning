<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('can_action'))
{
	function can_action($menu_id, $action)
	{
		$CI = &get_instance();
		$designations_id = $CI->session->userdata('userId');
		$where = array('userId' => $userId, $action => $menu_id);
		//$user_type = $CI->session->userdata('userType');
		//if ($user_type == 0) {
		//	return true;
		//} else {
			$can_do = $CI->db->where($where)->get('user_role')->row();
			if (!empty($can_do)) {
				return true;
			}
		//}
	}
}


if ( ! function_exists('can_do'))
{
	function can_do($menu_id)
	{
		$CI = &get_instance();
		$designations_id = $CI->session->userdata('userId');
		//$user_type = $CI->session->userdata('userType');
		//if ($user_type == 0) {
		//	return true;
		//} else {
			$can_do = $CI->db->where(array('userId' => $userId, 'menu_id' => $menu_id))->get('user_role')->result();
			if (!empty($can_do)) {
				return true;
			}
		//}
	}
}



function btn_edit($uri) {
    return anchor($uri, '<i class="fa fa-pencil-square-o"></i> Edit', array('class' => "btn btn-primary btn-xs", 'title'=>'Edit', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}

function btn_addimage($uri) {
    return anchor($uri, '<i class="fa fa-plus"></i> Add Image', array('class' => "btn btn-primary btn-xs", 'title'=>'Edit', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}
function btn_edit_disable($uri) {
    return anchor($uri, '<span class="glyphicon glyphicon-pencil"></span>', array('class' => "btn btn-primary btn-xs disabled", 'title'=>'Edit', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}

function btn_edit_modal($uri) {
    return anchor($uri, '<span class="glyphicon glyphicon-pencil"></span>', array('class' => "btn btn-primary btn-xs", 'title'=>'Edit', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-toggle'=>'modal', 'data-target'=>'#myModal'));
}

//For New Modal
function btn_open_modal($uri) {
    return anchor($uri, '<span class="glyphicon glyphicon-plus"></span> Add New People', array('class' => "btn btn-primary btn-xs", 'title'=>'Open A New Modal', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'data-toggle'=>'modal', 'data-target'=>'#myModalGallery'));
}

function btn_delete($uri) {
    return anchor($uri, '<i class="fa fa-trash-o"></i> Delete', array(
        'class' => "btn btn-danger btn-xs", 'title'=>'Delete', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');"
    ));    
}
function btn_delete_disable($uri) {
    return anchor($uri, '<i class="fa fa-trash-o"></i>', array(
        'class' => "btn btn-danger btn-xs disabled", 'title'=>'Delete', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');"
    ));    
}
function btn_active($uri) {
    return anchor($uri, '<i class="fa fa-check"></i>', array(
        'class' => "btn btn-success btn-xs", 'title'=>'Active', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to active new sesion . This cannot be undone. Are you sure?');"
    ));    
}

function btn_print() {
    return anchor('','<span class="glyphicon glyphicon-print"></i></span>', array('class' => "btn btn-primary btn-xs", 'title'=>'Print','data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick'=>'printDiv("printableArea")'));
}

function btn_atndc_print() {
    return anchor('','<span class="glyphicon glyphicon-print"></i></span>', array('class' => "btn btn-customs btn-xs", 'title'=>'Print','data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick'=>'printDiv("printableArea")'));
}

function btn_pdf($uri) {
    return anchor($uri, '<span <i class="fa fa-file-pdf-o"></i></span>', array('class' => "btn btn-primary btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'PDF'));
}
function btn_make_pdf($uri) {
    return anchor($uri, '<span <i class="fa fa-file-pdf-o""></i></span>', array('class' => "btn btn-primary btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Generate&nbsp;PDF'));
}
function btn_excel($uri) {
    return anchor($uri, '<span <i class="fa fa-file-excel-o"></i></span>', array('class' => "btn btn-primary btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'Excel'));
}

function btn_view($uri) {
    return anchor($uri, '<span class="fa fa-list-alt"></span>', array('class' => "btn btn-info btn-xs",'data-toggle'=>'tooltip', 'data-placement'=>'top', 'title'=>'View'));
}

function btn_save($uri) {
    return anchor($uri, '<span <i class="fa fa-plus-circle"></i></span>', array('class' => "btn btn-success btn-xs", 'title'=>'Save', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}

function btn_add($uri) {
    return anchor($uri, '<span <i class="fa fa-plus-square"></i></span>', array('class' => "btn btn-success btn-xs", 'title'=>'Add Routine', 'data-toggle'=>'tooltip', 'data-placement'=>'top'));
}

function btn_publish($uri) {
return anchor($uri, '<i class="fa fa-check"></i>', array(
        'class' => "btn btn-success btn-xs", 'title'=>'Click to Unpublish', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to unpublish an exam. Are you sure?');"
    ));    
}

function btn_unpublish($uri) {
    return anchor($uri, '<i class="fa fa-times"></i>', array(
        'class' => "btn btn-danger btn-xs", 'title'=>'Click to PUblish', 'data-toggle'=>'tooltip', 'data-placement'=>'top', 'onclick' => "return confirm('You are about to publish an exam. Are you sure?');"
    ));
}
