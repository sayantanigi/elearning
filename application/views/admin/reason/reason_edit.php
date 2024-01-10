

<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('admin/instructors/instructor-change-reason') ?>"><?=ucwords(@$page)?></a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
            </ol>
        </div>
        <div class="row">   
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> <?= $title ?> </h4>

                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="<?= admin_url('reason/update') ?>" class="form-horizontal forms-sample" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="reasonId" value="<?=$reasonDetail->reasonId?>">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Reason <span class="error">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="reason" value="<?=$reasonDetail->reason?>" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Status </label>
                                    <div class="col-sm-4">

                                       <select name="status" id="status" class="form-control" required>
                                            <option value="1" <?=($reasonDetail->status == 1?'selected':'')?>>Active</option>
                                            <option value="0" <?=($reasonDetail->status == 0?'selected':'')?>>Deactive</option>
                                        </select>

                                    </div>
                                </div>
                                
                                <div class="form-group row offset-3">  
                                    <button type="submit" class="btn btn-rounded btn-info">Save</button>
                                    <a class="btn btn-rounded btn-secondary ml-1" href="<?= admin_url('instructors/instructor-change-reason') ?>">
                                        Back
                                    </a>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>                  
        </div>
    </div>
</div>
