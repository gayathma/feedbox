<script type="text/javascript">
    var clipboard = new Clipboard('.clipbrd');

    clipboard.on('success', function(e) {
        toastr.success("Copied To Clipboard !!", "Feedbox");
        e.clearSelection();
    });
</script>
<div class="row">
    <div class="col-sm-12">
        <div>
            <header class="panel-heading" style="padding:0;margin:0;">
                <div class="col-md-4" style="padding:0;margin:0;">
                    <i
                        class="fa fa-home"></i>Workspace
                </div>
                <div class="col-md-4" style="text-align: CENTER;"></div>
                <div class="col-md-4 rl" style="padding:0;margin:0;">
                    <a href="<?php echo site_url(); ?>/questionnaire/question_types"><i
                            class="fa fa-tasks"></i>Question Categories</a>
                </div>

            </header>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel-body">
            <div class="row state-overview">
                <div class="col-md-3 col-lg-2" id="first_btn">
                    <div class="panel-base green-shadow green" onclick="add_form()">
                        <i class="fa fa-plus dash-plus"></i>
                            <span>
                            Create a new form</span>
                    </div>
                </div>

                <?php if (!empty($questionnaires)): ?>
                    <?php foreach ($questionnaires as $questionnaire): ?>
                        <div class="col-md-3 col-lg-2 pp" id="ques_<?php echo $questionnaire->id; ?>">

                            <div class="panel-base white">
                                <a style=" cursor: pointer;font-size: 5px;padding: 11px;position: absolute;right: 0;top: 0;"
                                   onclick="delete_questionnaire(<?php echo $questionnaire->id; ?>)">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                                <a href="<?php echo site_url(
                                ); ?>/questionnaire/main_form/<?php echo $questionnaire->id; ?>">
                                    <span class="span-ng black vcenter"><?php echo  $questionnaire->name;?></span>
                                </a>

                                <form class="form">
                                    <div class="row">
                                        <div class="col-md-12 sp">
                                            <div class="form-group">
                                                <!-- Target -->
                                                <input id="clip<?php echo $questionnaire->id; ?>"
                                                       class="form-control"
                                                       value="<?php echo
                                                           $domain_url . '/' . $questionnaire->id; ?>">
                                                <button class="btn clipbrd"
                                                        data-clipboard-target="#clip<?php echo $questionnaire->id; ?>">
                                                    <i class="fa fa-clipboard"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Trigger -->

                                </form>
                            </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>

<div style="display: none;" id="questionnaire_content" class="panel-base green">
    <form id="add_questionnaire_form" name="add_questionnaire_form" class="form" method="POST">
        <div class="row">
            <div class="col-md-12 ltlfrm">
                <div class="form-group">
                    <label for="name">Type questionnaire name</label>
                    <input id="name" class="form-control" name="name" type="text" value="">
                </div>

                <div class="form-group">
                    <label for="language">Language</label>
                    <select id="language" class="form-control" name="language">
                        <?php foreach ($languages as $key => $language) { ?>
                            <option value="<?php echo $key; ?>"><?php echo $language;?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="hidden"
                           name="location_id"
                           value="<?php echo $this->session->userdata(
                               'USER_LOCATION'
                           ); ?>">
                    <select id="location" class="form-control" name="location" disabled="true">
                        <?php foreach ($locations as $location) { ?>
                            <option value="<?php echo $location->id; ?>"  <?php  if (
                                $this->session->userdata('USER_LOCATION') == $location->id
                            ) {
                                ?> selected="true" <?php } ?>><?php echo $location->name;?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit" style="width:100%">Start building</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#add_questionnaire_form").validate({
            rules: {
                name: 'required',
                language: 'required'
            },
            submitHandler: function (form) {
                $.post(site_url + '/questionnaire/save_questionnaire', $('#add_questionnaire_form').serialize(), function (msg) {
                    if (msg != "") {

                        window.location = site_url + '/questionnaire/main_form/' + msg;
                    } else {
                        $('#rtn_msg_edit').html('<div class="alert alert-block alert-danger fade in"><button class="close close-sm" type="button" data-dismiss="alert"><i class="fa fa-times"></i></button><strong>An error occured.</strong></div>');

                    }
                });


            }
        });
    });

    function add_form() {
        $('#first_btn').html(' <div class="panel-base" > <div class="s-top green" onclick="load_questionnaire_form()"><i class="smilie fa fa-tasks dash-plus" style="font-size:4em;padding-top:20px;"></i>Questionnaire</div><div class="s-bottom green green-shadow" onclick="add_form()"><i class="smilie fa fa-smile-o dash-plus" style="font-size:4em;padding-top:20px;"></i>Instant feedback</button></div>');
    }

    function load_questionnaire_form() {
        content = $('#questionnaire_content');
        $('#first_btn').html(content);
        $('#questionnaire_content').attr('style', '');
    }

    //delete questionnaire
    function delete_questionnaire(id) {

        swal({
                title: "Are you sure?",
                text: "You want to delete this Questionnaire?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1abc9c",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function(){
                $.ajax({
                    type: "POST",
                    url: site_url + '/questionnaire/delete_questionnaire',
                    data: "id=" + id,
                    success: function (msg) {
                        if (msg == 1) {
                            $('#ques_' + id).hide();
                            swal("Deleted!", "Your questionnaire has been deleted.", "success");
                        }
                        else if (msg == 2) {
                            swal("Error!", "Cannot be deleted as it is already assigned.", "error");
                        }
                    }
                });

            });
    }
</script>
