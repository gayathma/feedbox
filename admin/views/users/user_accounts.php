<div class="row">
    <div class="col-sm-12">
        <div>
            <header class="panel-heading" style="padding:0;margin:0;">
                <div class="col-md-4" style="padding:0;margin:0;"><a
                        href="<?php echo site_url(); ?>/login/load_login"><i
                            class="fa fa-arrow-left"></i>Workspace</a></div>

                <div class="col-md-4" style="text-align: CENTER;">
                    <a class="btn btn-create" style="padding: 2px;
                       width: 30%;" href="#add_user_modal" data-toggle="modal"><i
                            style="font-size: 15px;
                            vertical-align: baseline;" class="fa fa-sign-out logout-icon"></i> Create</a>
                </div>
                <div class="col-md-4 rl" style="padding:0;margin:0;"><i
                        class="fa fa-user"></i>User Accounts
                </div>
            </header>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 bk">
        <div class="panel">
            <div class="panel-body large">
                <div class="adv-table">
                    <table class="display table table-bordered table-striped" id="user_table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>User Name</th>
                            <th>User Type</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i = 0;
                        foreach ($results as $result) {
                            ?>
                            <tr id="usr_<?php echo $result->id; ?>">
                                <td><?php echo++$i; ?></td>
                                <td><?php echo $result->name; ?></td>
                                <td><?php echo $result->user_name; ?></td>
                                <td>
                                    <?php if ($result->user_type == '1') { ?>
                                        <span class="label label-primary">Super Admin</span>
                                    <?php
                                    } else {
                                        if ($result->user_type == '2') {
                                            ?>
                                            <span class="label label-success">Admin</span>
                                        <?php } else { ?>
                                            <span class="label label-info">Report Users</span>
                                        <?php
                                        }
                                    } ?>
                                </td>
                                <td><?php echo $result->email; ?></td>
                                <td><?php echo $result->location; ?></td>
                                <td>
                                    <?php if ($result->is_deleted == '0') { ?>
                                        <span class="label label-success">Active</span>
                                    <?php } else { ?>
                                        <span class="label label-primary">Deleted</span>

                                        <a class="bt"
                                           onclick="active_user(<?php echo $result->id; ?>)"><i
                                                class="fa fa-check" title="Make User Active"></i></a>
                                    <?php }?>
                                </td>

                                <td align="center">
                                    <?php if ($result->is_deleted == '0') { ?>
                                        <a class="bt"
                                           onclick="display_user_pop_up(<?php echo $result->id; ?>)"><i
                                                class="fa fa-pencil" title="Update"></i></a>
                                        <?php if ($result->id != $this->session->userdata('USER_ID')) { ?>
                                            <a class="bt"
                                               onclick="delete_user(<?php echo $result->id; ?>)"><i
                                                    class="fa fa-trash-o " title="" title="Remove"></i></a>
                                        <?php } ?>
                                    <?php }?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--User Add Modal -->
<div class="modal fade " id="add_user_modal" tabindex="-1" role="dialog"
     aria-labelledby="add_user_modal_label"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add New User</h4>
            </div>
            <form id="add_user_form" name="add_user_form">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Name<span class="mandatory">*</span></label>
                        <input id="name" class="form-control" name="name" type="text">
                    </div>

                    <div class="form-group">
                        <label for="user_type">User Type<span class="mandatory">*</span></label>
                        <select class="form-control" name="user_type">
                            <option value="">- Select User Type -</option>
                            <?php foreach ($user_types as $key => $user_type) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $user_type; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="location_id">Location<span class="mandatory">*</span></label>
                        <?php  if ($this->session->userdata('USER_TYPE') != '1') { ?> <input type="hidden"
                                                                                             name="location_id"
                                                                                             value="<?php echo $this->session->userdata(
                                                                                                 'USER_LOCATION'
                                                                                             ); ?>"> <?php } ?>
                        <select class="form-control" name="location_id" <?php  if (
                            $this->session->userdata('USER_TYPE') != '1'
                        ) {
                            ?> disabled="true" <?php } ?>>
                            <option value="">- Select Location -</option>
                            <?php foreach ($locations as $location) { ?>
                                <option value="<?php echo $location->id; ?>" <?php  if (
                                    $this->session->userdata('USER_LOCATION') == $location->id
                                ) {
                                    ?> selected="true" <?php } ?>><?php echo $location->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">Email<span class="mandatory">*</span></label>
                        <input id="email" class="form-control" name="email" type="text">
                    </div>

                    <div class="form-group">
                        <label for="user_name">User Name<span class="mandatory">*</span></label>
                        <input id="user_name" class="form-control" name="user_name" type="text">
                        <span id="username_alert"></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password<span class="mandatory">*</span></label>
                        <input id="password" class="form-control" name="password" type="password">
                    </div>

                    <div class="form-group">
                        <label for="re_password">Confirm Password<span class="mandatory">*</span></label>
                        <input id="re_password" class="form-control" name="re_password" type="password">
                    </div>

                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button class="btn btn-success" type="submit">Save</button>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- modal -->

<!--User Edit Modal -->
<div class="modal fade " id="user_edit_div" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="user_edit_content">

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('change', '#user_name', function () {
            $.post(site_url + "/users/check_user_name", "username=" + $(this).val(), function (msg) {
                if (msg == '1') {
                    $('#username_alert').html("");
                } else if (msg == '0') {
                    $('#username_alert').html("<strong style=' color: red;'>Username not available. Try again !</strong>");
                    return false;
                }

            });
        });

        $('#user_table').dataTable();

        //add user form validation
        $("#add_user_form").validate({
            rules: {
                name: "required",
                user_type: "required",
                location_id: "required",
                email: {
                    required: true,
                    email: true
                },
                user_name: {
                    required: true,
                    minlength: 3
                },
                password: {
                    required: true,
                    minlength: 6
                },
                re_password: {
                    required: true,
                    minlength: 6,
                    equalTo: $('#password')
                }

            }, submitHandler: function (form) {
                $.post(site_url + "/users/check_user_name", "username=" + $('#user_name').val(), function (msg) {
                    if (msg == '1') {
                        $('#username_alert').html("");
                        $.post(site_url + '/users/add_user', $('#add_user_form').serialize(), function (msg) {
                            if (msg == 1) {

                                add_user_form.reset();
                                toastr.success("Successfully saved !!", "Feedbox");
                                setTimeout("location.href = site_url+'/users/manage_users';", 100);

                            } else {
                                toastr.error("Error Occurred !!", "Feedbox");
                            }
                        });
                    } else if (msg == '0') {
                        $('#username_alert').html("<strong style=' color: red;'>Username not available. Try again !</strong>");
                        return false;
                    }

                });

            }
        });
    });

    //Edit User
    function display_user_pop_up(user_id) {

        $.post(site_url + '/users/load_user', {user_id: user_id}, function (msg) {

            $('#user_edit_content').html('');
            $('#user_edit_content').html(msg);
            $('#user_edit_div').modal('show');
        });
    }

    //delete user
    function delete_user(id) {

        swal({
                title: "Are you sure?",
                text: "You want to delete this User?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1abc9c",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function () {

                $.ajax({
                    type: "POST",
                    url: site_url + '/users/delete_users',
                    data: "id=" + id,
                    success: function (msg) {
                        if (msg == 1) {
                            swal("Deleted!", "Your user has been deleted.", "success");
                            setTimeout("location.reload();", 1000);
                        }
                        else if (msg == 2) {
                            swal("Error!", "Cannot be deleted as it is already assigned.", "error");
                        }
                    }
                });
            });
    }


    function active_user(user_id) {
        $.ajax({
            type: "POST",
            url: site_url + '/users/user_active',
            data: "id=" + user_id,
            success: function (msg) {
                if (msg == 1) {
                    swal("Activated!", "Your user has been activated.", "success");
                    setTimeout("location.reload();", 1500);
                }
                else if (msg == 2) {
                    swal("Error!", "Error.", "error");
                }
            }
        });
    }
</script>

