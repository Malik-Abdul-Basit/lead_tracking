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
                                                    $Q = "SELECT * FROM `leads` WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $company = html_entity_decode(stripslashes($Result->company));
                                                        $date = html_entity_decode(stripslashes(date('d-m-Y', strtotime($Result->date))));
                                                        $status = html_entity_decode(stripslashes($Result->status));
                                                        $user_id = html_entity_decode(stripslashes($Result->user_id));
                                                        $category_id = html_entity_decode(stripslashes($Result->category_id));
                                                        $sub_category_id = html_entity_decode(stripslashes($Result->sub_category_id));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));
                                                    $id = $user_id = $category_id = $sub_category_id = 0;
                                                    $date = date('d-m-Y');
                                                    $company = $status = '';
                                                }
                                                $DateInput = '  type="text" class="DatePicker e-input form-control" onkeypress="openCalendar(event)" onfocus="openCalendar(event)" onclick="openCalendar(event)" maxlength="10" data-format="dd-MM-yyyy" ';
                                                $TAttrs = ' type="text" class="form-control" ';
                                                $onblur = ' onblur="change_color(this.value, this.id)" ';
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
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="date">* Date:</label>
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
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="company">* Company:</label>
                                                                            <input tabindex="20" maxlength="50"
                                                                                   id="company"
                                                                                   value="<?php echo $company; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                   placeholder="Company"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCompany"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="user_id">* Sales Person:</label>
                                                                            <select tabindex="30"
                                                                                    id="user_id" <?php echo $TAttrs . $onblur; ?>>
                                                                                <option selected="selected" value="0">
                                                                                    Select
                                                                                </option>
                                                                                <?php
                                                                                $select = "SELECT id, CONCAT(first_name,' ',last_name,' (',employee_code,')') AS name FROM `users` WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `employee_code` ASC";
                                                                                $query = mysqli_query($db, $select);
                                                                                if (mysqli_num_rows($query) > 0) {
                                                                                    while ($result = mysqli_fetch_object($query)) {
                                                                                        $selected = '';
                                                                                        if ($user_id == $result->id) {
                                                                                            $selected = 'selected="selected"';
                                                                                        }
                                                                                        ?>
                                                                                        <option <?php echo $selected; ?>
                                                                                                value="<?php echo $result->id; ?>"><?php echo $result->name; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageUserId"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="status">* Status</label>
                                                                            <select tabindex="40"
                                                                                    id="status" <?php echo $TAttrs . $onblur; ?>>
                                                                                <option value="0">Select</option>
                                                                                <?php
                                                                                foreach (config('leads.status.title') as $key => $val) {
                                                                                    $selected = $status == $key ? 'selected="selected"' : '';
                                                                                    echo '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageStatus"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="category_id">* Category:</label>
                                                                            <select tabindex="50"
                                                                                    id="category_id" <?php echo $TAttrs . $onblur; ?>
                                                                                    onchange="getSubCategory(this.value, <?php echo $sub_category_id; ?>)">
                                                                                <option selected="selected" value="0">
                                                                                    Select
                                                                                </option>
                                                                                <?php
                                                                                $select = "SELECT * FROM `categories` WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC";
                                                                                $query = mysqli_query($db, $select);
                                                                                if (mysqli_num_rows($query) > 0) {
                                                                                    while ($result = mysqli_fetch_object($query)) {
                                                                                        $selected = '';
                                                                                        if ($category_id == $result->id) {
                                                                                            $selected = 'selected="selected"';
                                                                                        }
                                                                                        ?>
                                                                                        <option <?php echo $selected; ?>
                                                                                                value="<?php echo $result->id; ?>"><?php echo $result->name; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCategoryId"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="sub_category_id">Sub
                                                                                Category:</label>
                                                                            <select tabindex="60" id="sub_category_id"
                                                                                    class="form-control">
                                                                                <?php
                                                                                if (!empty($category_id)) {
                                                                                    echo getSubCategories($category_id, $sub_category_id);
                                                                                } else {
                                                                                    echo '<option selected="selected" value="">Select
                                                                        </option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <div class="error_wrapper">
                                                                                <span class="text-danger"
                                                                                      id="errorMessageSubCategoryId"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                        Communication <small>(Messages)</small> :</h3>
                                                    <div class="mb-2">
                                                        <div id="Data_Holder_Parent_Div">
                                                            <div class="row">
                                                                <div class="col-md-1 column text-center"><b>Sr.</b>
                                                                </div>
                                                                <div class="col-md-6 column">
                                                                    <b>* Question</b>
                                                                </div>
                                                                <div class="col-md-5 column">
                                                                    <b> Answer</b>
                                                                </div>
                                                            </div>

                                                            <div id="Data_Holder_Child_Div" class="mt-7 mb-7"
                                                                 style="max-height: 100%">
                                                                <?php
                                                                $i = 1;
                                                                if (!empty($id)) {
                                                                    $query_lead_messages = mysqli_query($db, "SELECT * FROM `lead_messages` WHERE `lead_id`='{$id}' ORDER BY `id` ASC");
                                                                    if (mysqli_num_rows($query_lead_messages) > 0) {
                                                                        while ($object_lead_messages = mysqli_fetch_object($query_lead_messages)) {
                                                                            ?>
                                                                            <div class="row">
                                                                                <div class="col-md-1 column">
                                                                                    <div class="form-group text-center mt-3">
                                                                                        <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                                                                                            <input type="checkbox"
                                                                                                   checked="checked"
                                                                                                   class="lineRepresentativeBox"
                                                                                                   value="<?php echo $i; ?>"
                                                                                                   name="lineRepresentativeBox[]"
                                                                                                   id="lineRepresentativeBox<?php echo $i; ?>"/>
                                                                                            <b class="float-left mr-2"><?php echo $i; ?>
                                                                                                . </b>
                                                                                            <span class="float-left"></span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6 column">
                                                                                    <div class="form-group">
                                                                                <textarea class="form-control"
                                                                                          id="question<?php echo $i; ?>"
                                                                                          placeholder="Question"><?php echo $object_lead_messages->question; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-5 column">
                                                                                    <div class="form-group">
                                                                                <textarea class="form-control"
                                                                                          id="answer<?php echo $i; ?>"
                                                                                          placeholder="Answer"><?php echo $object_lead_messages->answer; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                for ($i; $i <= 1; $i++) {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-1 column">
                                                                            <div class="form-group text-center mt-3">
                                                                                <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                                                                                    <input type="checkbox"
                                                                                           class="lineRepresentativeBox"
                                                                                           value="<?php echo $i; ?>"
                                                                                           name="lineRepresentativeBox[]"
                                                                                           id="lineRepresentativeBox<?php echo $i; ?>"/>
                                                                                    <b class="float-left mr-2"><?php echo $i; ?>
                                                                                        . </b>
                                                                                    <span class="float-left"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 column">
                                                                            <div class="form-group">
                                                                                <textarea class="form-control"
                                                                                          id="question<?php echo $i; ?>"
                                                                                          placeholder="Question"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5 column">
                                                                            <div class="form-group">
                                                                                <textarea class="form-control"
                                                                                          id="answer<?php echo $i; ?>"
                                                                                          placeholder="Answer"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <input type="hidden" name="r_rows" id="r_rows"
                                                                   value="<?php echo --$i; ?>">
                                                            <button type="button" class="btn btn-success float-right"
                                                                    onclick="addNewRow()"><?php echo config('lang.button.title.add'); ?>
                                                            </button>
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

            var validName = /[^a-zA-Z0-9-.@_&' ]/;
            var validDate = /^(0[1-9]|1\d|2\d|3[01])\-(0[1-9]|1[0-2])\-(19|20)\d{2}$/;
            var validMesg = /[^a-zA-Z0-9+-._,@&#/' ]/;

            var statusArray = [<?php echo '"' . implode('","', array_values(config('leads.status.value'))) . '"' ?>];

            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';

            var id = document.getElementById('id');
            var date = document.getElementById('date');
            var company = document.getElementById('company');
            var user_id = document.getElementById('user_id');
            var select2_user_id_container = document.querySelector("[aria-labelledby='select2-user_id-container']");
            var status = document.getElementById('status');
            var category_id = document.getElementById('category_id');
            var select2_category_id_container = document.querySelector("[aria-labelledby='select2-category_id-container']");
            var sub_category_id = document.getElementById('sub_category_id');
            var select2_sub_category_id_container = document.querySelector("[aria-labelledby='select2-sub_category_id-container']");

            if (sub_category_id.value != '' && isNaN(sub_category_id.value) === false && sub_category_id.value > 0 && sub_category_id.value.length <= 10) {
                sub_category_id = sub_category_id.value;
            } else {
                sub_category_id = 0;
            }

            var errorMessageDate = document.getElementById('errorMessageDate');
            var errorMessageCompany = document.getElementById('errorMessageCompany');
            var errorMessageUserId = document.getElementById('errorMessageUserId');
            var errorMessageStatus = document.getElementById('errorMessageStatus');
            var errorMessageCategoryId = document.getElementById('errorMessageCategoryId');
            var errorMessageSubCategoryId = document.getElementById('errorMessageSubCategoryId');

            date.style.borderColor = company.style.borderColor = select2_user_id_container.style.borderColor = status.style.borderColor = select2_category_id_container.style.borderColor = select2_sub_category_id_container.style.borderColor = '#E4E6EF';
            errorMessageDate.innerText = errorMessageCompany.innerText = errorMessageUserId.innerText = errorMessageStatus.innerText = errorMessageCategoryId.innerText = errorMessageSubCategoryId.innerText = '';

            var checkedValue = null;
            var error = '';
            var continueProcessing = false;
            var data = [];
            var message = 'Please checked at least one Communication.';
            var inputElements = document.getElementsByClassName('lineRepresentativeBox');


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
            } else if (company.value == '') {
                company.style.borderColor = '#F00';
                error = "Company field is required.";
                toasterTrigger('error', error);
                errorMessageCompany.innerText = error;
                return false;
            } else if (validName.test(company.value)) {
                company.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessageCompany.innerText = error;
                return false;
            } else if (company.value.length > 50) {
                company.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                toasterTrigger('error', error);
                errorMessageCompany.innerText = error;
                return false;
            } else if (user_id.value == '') {
                select2_user_id_container.style.borderColor = '#F00';
                error = "Sales Person field is required.";
                toasterTrigger('error', error);
                errorMessageUserId.innerText = error;
                return false;
            } else if (isNaN(user_id.value) === true || user_id.value.length > 10) {
                select2_user_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageUserId.innerText = error;
                return false;
            } else if (user_id.value < 1) {
                select2_user_id_container.style.borderColor = '#F00';
                error = "Sales Person field is required.";
                toasterTrigger('error', error);
                errorMessageUserId.innerText = error;
                return false;
            } else if (status.value == '' || status.value == 0) {
                status.style.borderColor = '#F00';
                error = "Status field is required.";
                toasterTrigger('error', error);
                errorMessageStatus.innerText = error;
                return false;
            } else if (statusArray.includes(status.value) == false || isNaN(status.value) === true || status.value.length > 3) {
                status.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageStatus.innerText = error;
                return false;
            } else if (category_id.value == '') {
                select2_category_id_container.style.borderColor = '#F00';
                error = "Category field is required.";
                toasterTrigger('error', error);
                errorMessageCategoryId.innerText = error;
                return false;
            } else if (isNaN(category_id.value) === true || category_id.value.length > 10) {
                select2_category_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageCategoryId.innerText = error;
                return false;
            } else if (category_id.value < 1) {
                select2_category_id_container.style.borderColor = '#F00';
                error = "Category field is required.";
                toasterTrigger('error', error);
                errorMessageCategoryId.innerText = error;
                return false;
            } else {
                for (var i = 0; inputElements[i]; ++i) {
                    if (inputElements[i].checked) {
                        checkedValue = inputElements[i].value;
                        var question = document.getElementById('question' + checkedValue);
                        var answer = document.getElementById('answer' + checkedValue);

                        if (question.value == '') {
                            question.style.borderColor = '#F00';
                            message = 'Question field is required, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (validMesg.test(question.value)) {
                            question.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Question field, At line no ' + checkedValue;
                            continueProcessing = false;
                        } else if (answer.value != '' && validMesg.test(answer.value)) {
                            answer.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Answer field, At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else {
                            var obj = {};
                            obj = {
                                "question": question.value,
                                "answer": answer.value,
                            }
                            data.push(obj);
                            continueProcessing = true;
                        }
                    }
                }
                if (continueProcessing === false) {
                    toasterTrigger('error', message);
                    return false;
                } else if (continueProcessing === true && data.length > 0) {
                    var postData = {
                        "id": id.value,
                        "date": date.value,
                        "company": company.value,
                        "user_id": user_id.value,
                        "status": status.value,
                        "category_id": category_id.value,
                        "sub_category_id": sub_category_id,
                        "user_right_title": '<?php echo $user_right_title; ?>',
                        "data": data
                    };
                    loader(true);
                    $.ajax({
                        type: "POST", url: "ajax/lead.php",
                        data: {"postData": postData},
                        success: function (resPonse) {
                            if (resPonse !== undefined && resPonse != '') {
                                var obj = JSON.parse(resPonse);
                                if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                    var title = '';
                                    if (obj.code === 422) {
                                        if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                            if (obj.errorField == 'user_id') {
                                                select2_user_id_container.style.borderColor = '#F00';
                                            } else if (obj.errorField == 'category_id') {
                                                select2_category_id_container.style.borderColor = '#F00';
                                            } else if (obj.errorField == 'sub_category_id') {
                                                select2_sub_category_id_container.style.borderColor = '#F00';
                                            } else {
                                                document.getElementById(obj.errorField).style.borderColor = '#F00';
                                            }
                                            document.getElementById(obj.errorDiv).innerText = obj.errorMessage;
                                            loader(false);
                                            toasterTrigger('warning', obj.errorMessage);
                                        }
                                    } else if (obj.code === 405 || obj.code === 200) {
                                        if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                            if (obj.form_reset !== undefined && obj.form_reset) {
                                                document.getElementById("myFORM").reset();
                                                var select2_userIdContainer = document.getElementById("select2-user_id-container");
                                                var select2_categoryIdContainer = document.getElementById("select2-category_id-container");
                                                var select2_subCategoryIdContainer = document.getElementById("select2-sub_category_id-container");
                                                if (select2_userIdContainer) {
                                                    select2_userIdContainer.removeAttribute("title");
                                                    select2_userIdContainer.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                    user_id.value = 0;
                                                }
                                                if (select2_categoryIdContainer) {
                                                    select2_categoryIdContainer.removeAttribute("title");
                                                    select2_categoryIdContainer.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                    category_id.value = 0;
                                                }
                                                if (select2_subCategoryIdContainer) {
                                                    select2_subCategoryIdContainer.removeAttribute("title");
                                                    select2_subCategoryIdContainer.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                    sub_category_id.value = 0;
                                                }
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

        function addNewRow() {
            var last_row_number = document.getElementById('r_rows');
            var r_rows = last_row_number.value;
            var objDiv = document.getElementById("Data_Holder_Child_Div");
            var innerHTml_c = '';
            r_rows++;
            innerHTml_c += '<div class="row">';
            innerHTml_c += '<div class="col-md-1 column"><div class="form-group text-center mt-3"><label class="checkbox checkbox-outline checkbox-success d-inline-block"><input type="checkbox" class="lineRepresentativeBox" value="' + r_rows + '" name="lineRepresentativeBox[]" id="lineRepresentativeBox' + r_rows + '" checked="checked"><b class="float-left mr-2">' + r_rows + '.</b><span class="float-left"></span></label></div></div>';
            innerHTml_c += '<div class="col-md-6 column"><div class="form-group"><textarea class="form-control" id="question' + r_rows + '" placeholder="Question"></textarea></div></div>';
            innerHTml_c += '<div class="col-md-5 column"><div class="form-group"><textarea class="form-control" id="answer' + r_rows + '" placeholder="Answer"></textarea></div></div>';
            innerHTml_c += '</div>';
            $("#Data_Holder_Child_Div").append(innerHTml_c);
            objDiv.scrollTop = objDiv.scrollHeight;
            last_row_number.value = r_rows;
        }

        function getSubCategory(category_id, sub_category_id) {
            var sub_category_wrapper = document.getElementById('sub_category_id');
            sub_category_wrapper.innerHTML = '';

            loader(true);
            var postData = {
                "category_id": category_id,
                "sub_category_id": sub_category_id
            };
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'getSubCategories': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code === 200) {
                            sub_category_wrapper.innerHTML = obj.data;
                            loader(false);
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
    </script>
<?php include_once("../includes/endTags.php"); ?>