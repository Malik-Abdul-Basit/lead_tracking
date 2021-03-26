<?php
include_once("header/check_login.php");
include_once("../includes/head.php");
include_once("../includes/mobile_menu.php");
?>
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            <?php include_once("../includes/main_menu.php"); ?>
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                <?php include_once("../includes/header_menu.php"); ?>
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Breadcrumb-->
                    <?php include_once('../includes/bread_crumb.php'); ?>
                    <!--end::Breadcrumb-->

                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Card-->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <?php
                                                if (isset($_GET['id'])) {
                                                    if (!hasRight($user_right_title, 'edit')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Edit ' . ucwords(str_replace("_", " ", $page));
                                                    $id = htmlentities($_GET['id']);
                                                    $Q = "SELECT * FROM `sources_lead_details` WHERE `id`='{$id}' AND `user_id`='{$global_user_id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);

                                                        $date = html_entity_decode(stripslashes(date('d-m-Y', strtotime($Result->date))));
                                                        $calls = html_entity_decode(stripslashes($Result->calls));
                                                        $follow_up = html_entity_decode(stripslashes($Result->follow_up));

                                                        $good_response = html_entity_decode(stripslashes($Result->good_response));
                                                        $bad_response = html_entity_decode(stripslashes($Result->bad_response));
                                                        $lead_conversion = html_entity_decode(stripslashes($Result->lead_conversion));
                                                        $bad_data = html_entity_decode(stripslashes($Result->bad_data));

                                                        $no_answer = html_entity_decode(stripslashes($Result->no_answer));
                                                        $voice_mails = html_entity_decode(stripslashes($Result->voice_mails));
                                                        $emails_sent = html_entity_decode(stripslashes($Result->emails_sent));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));
                                                    $id = $follow_up = $good_response = $bad_response = 0;
                                                    $lead_conversion = $bad_data = $no_answer = $voice_mails = $emails_sent = 0;
                                                    $calls = 1;
                                                    $date = date('d-m-Y');
                                                }
                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <div class="row">

                                                                    <!-- Date -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="date">
                                                                                * Date:
                                                                                <small>(dd-MM-yyyy)</small>
                                                                            </label>
                                                                            <input tabindex="10" <?php echo $DateInput; ?>
                                                                                   id="date" placeholder="Date"
                                                                                   value="<?php echo $date; ?>">
                                                                            <span class="e-clear-icon e-clear-icon-hide"
                                                                                  aria-label="close"
                                                                                  role="button"></span>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageDate"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- No of Calls -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="calls">* Number of
                                                                                Calls:</label>
                                                                            <input tabindex="20" maxlength="9"
                                                                                   onkeypress="allowNumberOnly(event)"
                                                                                   id="calls"
                                                                                   value="<?php echo $calls; ?>" <?php echo $TouchSpin . $onblur; ?>
                                                                                   placeholder="No of Call"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCalls"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row">

                                                                    <!-- No of Calls -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="follow_up">Number of Follow Up
                                                                                Calls:</label>
                                                                            <input tabindex="30" maxlength="9"
                                                                                   onkeypress="allowNumberOnly(event)"
                                                                                   id="follow_up"
                                                                                   value="<?php echo $follow_up; ?>" <?php echo $TouchSpin . $onblur; ?>
                                                                                   placeholder="No of Follow Up Calls"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFollowUp"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Good Response -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="good_response">Good
                                                                                Response:</label>
                                                                            <input tabindex="40" maxlength="9"
                                                                                   onkeypress="allowNumberOnly(event)"
                                                                                   id="good_response"
                                                                                   value="<?php echo $good_response; ?>" <?php echo $TouchSpin . $onblur; ?>
                                                                                   placeholder="Good Response"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageGoodResponse"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row">

                                                                    <!-- Bad Response -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="bad_response">Bad
                                                                                Response:</label>
                                                                            <input tabindex="50" maxlength="9"
                                                                                   onkeypress="allowNumberOnly(event)"
                                                                                   id="bad_response"
                                                                                   value="<?php echo $bad_response; ?>" <?php echo $TouchSpin . $onblur; ?>
                                                                                   placeholder="Bad Response"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageBadResponse"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Bad Data -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="bad_data">Bad Data:</label>
                                                                            <input tabindex="60" maxlength="9"
                                                                                   onkeypress="allowNumberOnly(event)"
                                                                                   id="bad_data"
                                                                                   value="<?php echo $bad_data; ?>" <?php echo $TouchSpin . $onblur; ?>
                                                                                   placeholder="Bad Data"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageBadData"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Lead Conversion -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="lead_conversion">Lead
                                                                                Conversion:</label>
                                                                            <input tabindex="70" maxlength="9"
                                                                                   onkeypress="allowNumberOnly(event)"
                                                                                   id="lead_conversion"
                                                                                   value="<?php echo $lead_conversion; ?>" <?php echo $TouchSpin . $onblur; ?>
                                                                                   placeholder="Lead Conversion"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageLeadConversion"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row">

                                                                    <!-- No Answer -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="no_answer">No Answer:</label>
                                                                            <input tabindex="80" maxlength="9"
                                                                                   onkeypress="allowNumberOnly(event)"
                                                                                   id="no_answer"
                                                                                   value="<?php echo $no_answer; ?>" <?php echo $TouchSpin . $onblur; ?>
                                                                                   placeholder="No Answer"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageNoAnswer"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Voice Mails -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="voice_mails">Voice
                                                                                Mails:</label>
                                                                            <input tabindex="90" maxlength="9"
                                                                                   onkeypress="allowNumberOnly(event)"
                                                                                   id="voice_mails"
                                                                                   value="<?php echo $voice_mails; ?>" <?php echo $TouchSpin . $onblur; ?>
                                                                                   placeholder="Voice Mails"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageVoiceMails"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Emails Sent -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="emails_sent">Emails
                                                                                Sent:</label>
                                                                            <input tabindex="100" maxlength="9"
                                                                                   onkeypress="allowNumberOnly(event)"
                                                                                   id="emails_sent"
                                                                                   value="<?php echo $emails_sent; ?>" <?php echo $TouchSpin . $onblur; ?>
                                                                                   placeholder="Emails Sent"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageEmailsSent"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="button" onclick="saveFORM()"
                                                                class="btn btn-primary font-weight-bold mr-2"><?php echo config('lang.button.title.save'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Entry-->
                </div>
                <!--end::Content-->

                <!--begin::Footer-->
                <?php include_once("../includes/footer_statement.php"); ?>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->
<?php
include_once("../includes/footer.php");
include_once("../includes/footer_script.php");
?>
    <script>

        function saveFORM() {

            var validDate = /^(0[1-9]|1\d|2\d|3[01])\-(0[1-9]|1[0-2])\-(19|20)\d{2}$/;

            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';

            var id = document.getElementById('id');

            var date = document.getElementById('date');
            var calls = document.getElementById('calls');
            var follow_up = document.getElementById('follow_up');
            var good_response = document.getElementById('good_response');
            var bad_response = document.getElementById('bad_response');
            var bad_data = document.getElementById('bad_data');
            var lead_conversion = document.getElementById('lead_conversion');
            var no_answer = document.getElementById('no_answer');
            var voice_mails = document.getElementById('voice_mails');
            var emails_sent = document.getElementById('emails_sent');

            var errorMessageDate = document.getElementById('errorMessageDate');
            var errorMessageCalls = document.getElementById('errorMessageCalls');
            var errorMessageFollowUp = document.getElementById('errorMessageFollowUp');
            var errorMessageGoodResponse = document.getElementById('errorMessageGoodResponse');
            var errorMessageBadResponse = document.getElementById('errorMessageBadResponse');
            var errorMessageBadData = document.getElementById('errorMessageBadData');
            var errorMessageLeadConversion = document.getElementById('errorMessageLeadConversion');
            var errorMessageNoAnswer = document.getElementById('errorMessageNoAnswer');
            var errorMessageVoiceMails = document.getElementById('errorMessageVoiceMails');
            var errorMessageEmailsSent = document.getElementById('errorMessageEmailsSent');


            date.style.borderColor = calls.style.borderColor = follow_up.style.borderColor = good_response.style.borderColor = bad_response.style.borderColor = '#E4E6EF';
            bad_data.style.borderColor = lead_conversion.style.borderColor = no_answer.style.borderColor = voice_mails.style.borderColor = emails_sent.style.borderColor = '#E4E6EF';
            errorMessageDate.innerText = errorMessageCalls.innerText = errorMessageFollowUp.innerText = errorMessageGoodResponse.innerText = errorMessageBadResponse.innerText = '';
            errorMessageBadData.innerText = errorMessageLeadConversion.innerText = errorMessageNoAnswer.innerText = errorMessageVoiceMails.innerText = errorMessageEmailsSent.innerText = '';

            var error = '';

            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
                return false;
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
                return false;
            } else if (date.value == '') {
                date.style.borderColor = '#F00';
                error = "Date field is required.";
                toasterTrigger('error', error);
                errorMessageDate.innerText = error;
                return false;
            } else if (!(validDate.test(date.value)) || date.value.length !== 10) {
                date.style.borderColor = '#F00';
                error = "Please select a valid date.";
                toasterTrigger('error', error);
                errorMessageDate.innerText = error;
                return false;
            } else if (calls.value == '') {
                calls.style.borderColor = '#F00';
                error = "Number of Calls field is required.";
                toasterTrigger('error', error);
                errorMessageCalls.innerText = error;
                return false;
            } else if (isNaN(calls.value) === true || calls.value < 1 || calls.value.length > 9) {
                calls.style.borderColor = '#F00';
                error = "Number of Calls are invalid.";
                toasterTrigger('error', error);
                errorMessageCalls.innerText = error;
                return false;
            } else if (follow_up.value == '') {
                follow_up.style.borderColor = '#F00';
                error = "Follow Up Calls field is required.";
                toasterTrigger('error', error);
                errorMessageFollowUp.innerText = error;
                return false;
            } else if (isNaN(follow_up.value) === true || follow_up.value < 0 || follow_up.value.length > 9) {
                follow_up.style.borderColor = '#F00';
                error = "Invalid Number of Follow Up Calls.";
                toasterTrigger('error', error);
                errorMessageFollowUp.innerText = error;
                return false;
            } else if (good_response.value == '') {
                good_response.style.borderColor = '#F00';
                error = "Good Response field is required.";
                toasterTrigger('error', error);
                errorMessageGoodResponse.innerText = error;
                return false;
            } else if (isNaN(good_response.value) === true || good_response.value < 0 || good_response.value.length > 9) {
                good_response.style.borderColor = '#F00';
                error = "Given data is invalid.";
                toasterTrigger('error', error);
                errorMessageGoodResponse.innerText = error;
                return false;
            } else if (bad_response.value == '') {
                bad_response.style.borderColor = '#F00';
                error = "Bad Response field is required.";
                toasterTrigger('error', error);
                errorMessageBadResponse.innerText = error;
                return false;
            } else if (isNaN(bad_response.value) === true || bad_response.value < 0 || bad_response.value.length > 9) {
                bad_response.style.borderColor = '#F00';
                error = "Given data is invalid.";
                toasterTrigger('error', error);
                errorMessageBadResponse.innerText = error;
                return false;
            } else if (bad_data.value == '') {
                bad_data.style.borderColor = '#F00';
                error = "Bad Data field is required.";
                toasterTrigger('error', error);
                errorMessageBadData.innerText = error;
                return false;
            } else if (isNaN(bad_data.value) === true || bad_data.value < 0 || bad_data.value.length > 9) {
                bad_data.style.borderColor = '#F00';
                error = "Given data is invalid.";
                toasterTrigger('error', error);
                errorMessageBadData.innerText = error;
                return false;
            } else if (lead_conversion.value == '') {
                lead_conversion.style.borderColor = '#F00';
                error = "Lead Conversion field is required.";
                toasterTrigger('error', error);
                errorMessageLeadConversion.innerText = error;
                return false;
            } else if (isNaN(lead_conversion.value) === true || lead_conversion.value < 0 || lead_conversion.value.length > 9) {
                lead_conversion.style.borderColor = '#F00';
                error = "Number of Lead Conversion is invalid.";
                toasterTrigger('error', error);
                errorMessageLeadConversion.innerText = error;
                return false;
            } else if (no_answer.value == '') {
                no_answer.style.borderColor = '#F00';
                error = "No Answer field is required.";
                toasterTrigger('error', error);
                errorMessageNoAnswer.innerText = error;
                return false;
            } else if (isNaN(no_answer.value) === true || no_answer.value < 0 || no_answer.value.length > 9) {
                no_answer.style.borderColor = '#F00';
                error = "Given data is invalid.";
                toasterTrigger('error', error);
                errorMessageNoAnswer.innerText = error;
                return false;
            } else if (voice_mails.value == '') {
                voice_mails.style.borderColor = '#F00';
                error = "Voice Mails field is required.";
                toasterTrigger('error', error);
                errorMessageVoiceMails.innerText = error;
                return false;
            } else if (isNaN(voice_mails.value) === true || voice_mails.value < 0 || voice_mails.value.length > 9) {
                voice_mails.style.borderColor = '#F00';
                error = "Given data is invalid.";
                toasterTrigger('error', error);
                errorMessageVoiceMails.innerText = error;
                return false;
            } else if (emails_sent.value == '') {
                emails_sent.style.borderColor = '#F00';
                error = "Emails Sent field is required.";
                toasterTrigger('error', error);
                errorMessageEmailsSent.innerText = error;
                return false;
            } else if (isNaN(emails_sent.value) === true || emails_sent.value < 0 || emails_sent.value.length > 9) {
                emails_sent.style.borderColor = '#F00';
                error = "Given data is invalid.";
                toasterTrigger('error', error);
                errorMessageEmailsSent.innerText = error;
                return false;
            }
            else {
                var continueProcessing = true;
                if (continueProcessing === true) {
                    var postData = {
                        "id": id.value,
                        "date": date.value,
                        "calls": calls.value,
                        "follow_up": follow_up.value,
                        "good_response": good_response.value,
                        "bad_response": bad_response.value,
                        "bad_data": bad_data.value,
                        "lead_conversion": lead_conversion.value,
                        "no_answer": no_answer.value,
                        "voice_mails": voice_mails.value,
                        "emails_sent": emails_sent.value,
                        "user_right_title": '<?php echo $user_right_title; ?>'
                    };
                    loader(true);
                    $.ajax({
                        type: "POST", url: "ajax/bd_lead.php",
                        data: {"postData": postData},
                        success: function (resPonse) {
                            if (resPonse !== undefined && resPonse !== '' && resPonse !== null) {
                                var obj = JSON.parse(resPonse);
                                if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                    if (obj.code === 422) {
                                        if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                            document.getElementById(obj.errorDiv).innerText = obj.errorMessage;
                                            loader(false);
                                            toasterTrigger('error', obj.errorMessage);
                                        }
                                    } else if (obj.code === 405 || obj.code === 200) {
                                        if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                            if (obj.form_reset !== undefined && obj.form_reset) {
                                                document.getElementById("myFORM").reset();
                                                calls.value = 1;
                                                follow_up.value = good_response.value = bad_response.value = bad_data.value = lead_conversion.value = 0;
                                                no_answer.value = voice_mails.value = emails_sent.value = 0;
                                            }
                                            loader(false);
                                            toasterTrigger(obj.toasterClass, obj.responseMessage);
                                        } else {
                                            loader(false);
                                        }
                                    }
                                } else {
                                    loader(false);
                                }
                            } else {
                                loader(false);
                            }
                        },
                        error: function () {
                            loader(false);
                        }
                    });
                }
            }
        }

    </script>
<?php include_once("../includes/endTags.php"); ?>