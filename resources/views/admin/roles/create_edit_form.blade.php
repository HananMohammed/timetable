@push('css')
    <style>
        .select2{
            width: 100%!important;
        }
    </style>
@endpush

<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rolesLabel">Create Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="roleForm">
                    <input type="hidden" value="" id="roleId">
                    <div class="form-group">
                        <label>Role Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control"  placeholder="Enter Role Name" name="name"/>
                        <span class="invalid-feedback " role="alert"></span>
                    </div>
                    <div class="form-group">
                        <label>Assign Permissions <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="kt_select2_3" name="permissions" multiple="multiple">
                            @if(!empty($permissions))
                                @foreach($permissions as $permission)
                                    <option value="{{$permission->id}}">{{$permission->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="invalid-feedback " role="alert"></span>
                    </div>
                </form>
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="save">Save changes</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        var KTSelect2 = function() {
            var demos = function() {
                $('#kt_select2_3').select2({
                    placeholder: "Select Role Permissions",
                });
            }
            // Public functions
            return {
                init: function() {
                    demos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            KTSelect2.init();
        });

        let bindErrorMessages = (index, value, element)=>{
            $(`${element}[name=${index}]`).addClass('is-invalid')
            $(`${element}[name=${index}]`).parent().children('.invalid-feedback').html(`<strong>${value}</strong>`)
        }
        $('#roleModal').on('hidden.bs.modal', function () {
             $("#rolesLabel").text('Create Role')
             $("input, select").val('')
             $("#roleId").val('')
             $("select[name='permissions']").val('').trigger('change')
             $("input, select").removeClass('is-invalid')
             $("input, select").parent().children('.invalid-feedback').text('')
        })

        $(document).on('click','.editRow',function (){
            let url = `/dashboard/roles/${$(this).data('id')}/edit`
            axios({
                method: 'get',
                url: url,
            }).then((response) => {
                if(response.status){
                    $("#rolesLabel").text('Edit Role')
                    $("#roleId").val(response.data.data.id)
                    $("input[name='name']").val(response.data.data.name)
                    let permissions = []
                    response.data.data.permissions.forEach((value, index)=>{permissions.push(value.id)})
                    $("select[name='permissions']").val(permissions).trigger('change')
                    $('#roleModal').modal('show');
                }
            }, (error) => {
                console.log(error)
            });

        });
    </script>
@endpush