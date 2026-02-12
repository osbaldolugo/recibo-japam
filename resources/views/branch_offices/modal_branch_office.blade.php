<div class="modal fade in" id="modal_branch_office" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="close_modal_branch_office"><i class="fa fa-times"></i></button>
                <h4 class="modal-title" id="txtTitleModal"></h4>
            </div>
            <div class="modal-body loading-modal-branch-office">
                <div class="row">
                    @include('branch_offices.fields')
                </div>
            </div>
        </div>
    </div>
</div>