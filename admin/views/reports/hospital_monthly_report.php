<div class="row">
    <div class="col-sm-12">
        <div>
            <header class="panel-heading">
                <a href="<?php echo site_url(); ?>/login/load_login"><i
                        class="fa fa-arrow-left"></i>Monthly Inpatient Feedback Report</a>

                <div class="pull-right">
                    <form class="form-inline" id="month_report" name="month_report">
                        <div class="form-group">
                            <select id="questionnaire" name="questionnaire" class="form-control">
                                <option value="">- Select Questionnaire -</option>
                                <?php foreach($questionnaires as $questionnaire){?>
                                    <option value="<?php echo $questionnaire->id;?>"><?php echo $questionnaire->name;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="month" id="month" class="form-control" placeholder="Month" value="<?php echo date('Y-m');?>">
                        </div>
                        <div class="form-group">
                            <input type="text" name="total_admissions" id="total_admissions" class="form-control"
                                   placeholder="Total Admissions">
                        </div>

                        <button type="submit" class="btn btn-success green-shadow">Generate</button>
                        <button type="button" class="btn btn-success green-shadow" onclick="export_report()">Export</button>
                    </form>
                </div>

            </header>
            <div class="panel-body" id="report_content">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function ($) {
        $("#month_report").validate({
            rules: {
                month: "required",
                questionnaire: "required",
                total_admissions: {
                    required:true,
                    number:true
                }
            }, highlight: function(element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);

            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
            },
            errorPlacement: function(error, element) {
            },
            submitHandler: function(form) {
                $.post(site_url + '/reports/generate_hospital_monthly_report', $("#month_report").serialize(), function (msg) {
                    $('#report_content').html('');
                    $('#report_content').html(msg);
                });
            }
        });

        $('#month').datepicker({
            autoclose: "true",
            viewMode:'months',
            minViewMode: "months",
            format: 'yyyy-mm'
        });
    });

    function export_report(){
        if($("#month_report").valid()){
            var win = window.open(site_url + '/reports/generate_hospital_monthly_report_export?month=' + $("#month").val()+'&total_admissions='+ $("#total_admissions").val()+'&questionnaire=' + $("#questionnaire").val(), '_blank');
            win.focus();
        }
    }

</script>
