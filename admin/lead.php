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
                                                        $date = html_entity_decode(stripslashes(date('d-m-Y', strtotime($Result->date))));
                                                        $user_id = html_entity_decode(stripslashes($Result->user_id));
                                                        $category_id = html_entity_decode(stripslashes($Result->category_id));
                                                        $sub_category_id = html_entity_decode(stripslashes($Result->sub_category_id));
                                                        $status = html_entity_decode(stripslashes($Result->status));

                                                        $business_name = html_entity_decode(stripslashes($Result->business_name));
                                                        $email = html_entity_decode(stripslashes($Result->email));
                                                        $country_id = html_entity_decode(stripslashes($Result->country_id));
                                                        $state_id = html_entity_decode(stripslashes($Result->state_id));
                                                        $city_id = html_entity_decode(stripslashes($Result->city_id));
                                                        $dial_code = html_entity_decode(stripslashes($Result->dial_code));
                                                        $mobile = html_entity_decode(stripslashes($Result->mobile));
                                                        $iso = html_entity_decode(stripslashes($Result->iso));
                                                        $phone = html_entity_decode(stripslashes($Result->phone));
                                                        $fax = html_entity_decode(stripslashes($Result->fax));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));
                                                    $id = $user_id = $category_id = $sub_category_id = $state_id = $city_id = 0;
                                                    $date = date('d-m-Y');
                                                    $status = 1;
                                                    $business_name = $email = $mobile = $phone = $fax = '';
                                                    $country_id = 166;
                                                    $dial_code = '92';
                                                    $iso = 'pk';
                                                }
                                                $mobile_no_flag = '<img class="mr-1" src="' . $ct_assets . 'images/flags/' . $iso . '.png">+' . $dial_code;
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

                                                                    <!-- Sales Person -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="user_id">* Sales Person:</label>
                                                                            <select tabindex="20"
                                                                                    id="user_id" <?php echo $Select2 . $onblur; ?>>
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

                                                                </div>

                                                                <div class="row">

                                                                    <!-- Category -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="category_id">* Category:</label>
                                                                            <select tabindex="30"
                                                                                    id="category_id" <?php echo $Select2 . $onblur; ?>
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

                                                                    <!-- Sub Category -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="sub_category_id">Sub
                                                                                Category:</label>
                                                                            <select tabindex="40"
                                                                                    id="sub_category_id" <?php echo $Select2; ?>>
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

                                                                    <!-- Status -->
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="status">* Status</label>
                                                                            <select tabindex="50"
                                                                                    id="status" <?php echo $Select2 . $onblur; ?>>
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

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                        Business Information :</h3>
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="business_name">* Business / Respondent Name
                                                                                :</label>
                                                                            <input tabindex="60" maxlength="50"
                                                                                   id="business_name"
                                                                                   value="<?php echo $business_name; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                   placeholder="Business / Respondent Name"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageBusinessName"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label> Email:</label>
                                                                            <input tabindex="70" id="email"
                                                                                   value="<?php echo $email; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                   placeholder="Email"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageEmail"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>* Select Country:</label>
                                                                            <select tabindex="80"
                                                                                    id="country_id" <?php echo $TAttrs . $onblur; ?>>
                                                                                <option selected="selected" value="">
                                                                                    Select
                                                                                </option>
                                                                                <?php
                                                                                $select = "SELECT * FROM `countries`";
                                                                                $query = mysqli_query($db, $select);
                                                                                if (mysqli_num_rows($query) > 0) {
                                                                                    while ($result = mysqli_fetch_object($query)) {
                                                                                        $selected = '';
                                                                                        if ($country_id == $result->id) {
                                                                                            $selected = 'selected="selected"';
                                                                                        }
                                                                                        ?>
                                                                                        <option data-dial_code="<?php echo $result->dial_code; ?>"
                                                                                                data-iso="<?php echo strtolower($result->iso); ?>" <?php echo $selected; ?>
                                                                                                value="<?php echo $result->id; ?>"><?php echo $result->country_name; ?></option>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCountry"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label> Select State:</label>
                                                                            <select tabindex="90"
                                                                                    onchange="getCities(event)"
                                                                                    id="state_id" <?php echo $TAttrs . $onblur; ?>>
                                                                                <?php
                                                                                if (!empty($country_id)) {
                                                                                    echo getStates($country_id, $state_id);
                                                                                } else {
                                                                                    echo '<option selected="selected" value="">Select
                                                                        </option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageState"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label> Select City:</label>
                                                                            <select tabindex="100"
                                                                                    id="city_id" <?php echo $TAttrs . $onblur; ?>>
                                                                                <?php
                                                                                if (!empty($country_id) && !empty($state_id)) {
                                                                                    echo getCities($state_id, $city_id);
                                                                                } else {
                                                                                    echo '<option selected="selected" value="">Select
                                                                        </option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCity"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label> Mobile No:
                                                                                <small>
                                                                                    <a href="javascript:;">Example
                                                                                        300-777
                                                                                        8888</a>
                                                                                </small>
                                                                            </label>
                                                                            <input tabindex="620" id="dial_code"
                                                                                   class="not-display" type="hidden"
                                                                                   value="<?php echo $dial_code; ?>">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend"><span
                                                                                            class="input-group-text"
                                                                                            id="mobile_no_flag"><?php echo $mobile_no_flag; ?></span>
                                                                                </div>
                                                                                <input tabindex="120" maxlength="12"
                                                                                       id="mobile"
                                                                                       value="<?php echo $mobile; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                                       placeholder="Mobile No"/>
                                                                            </div>
                                                                            <input tabindex="720" id="iso"
                                                                                   class="not-display"
                                                                                   type="hidden"
                                                                                   value="<?php echo $iso; ?>">
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageMobile"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Phone No:
                                                                                <small>
                                                                                    <a href="javascript:;">Example (041)
                                                                                        233-3333</a>
                                                                                </small>
                                                                            </label>

                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend"><span
                                                                                            class="input-group-text"><i
                                                                                                class="la la-phone"></i></span>
                                                                                </div>
                                                                                <input tabindex="130" maxlength="14"
                                                                                       id="phone"
                                                                                       value="<?php echo $phone; ?>" <?php echo $TAttrs; ?>
                                                                                       placeholder="Phone No"/>
                                                                            </div>

                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessagePhone"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Fax:
                                                                                <small>
                                                                                    <a href="javascript:;">Example (041)
                                                                                        233-3333</a>
                                                                                </small>
                                                                            </label>

                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend"><span
                                                                                            class="input-group-text"><i
                                                                                                class="fas fa-fax"></i></span>
                                                                                </div>

                                                                                <input tabindex="140" maxlength="14"
                                                                                       id="fax"
                                                                                       value="<?php echo $fax; ?>" <?php echo $TAttrs; ?>
                                                                                       placeholder="Fax"/>
                                                                            </div>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFax"></span>
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
            var validEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var validContactNumber = /^[\-)( ]*([0-9]{3})[\-)( ]*([0-9]{3})[\-)( ]*([0-9]{4})$/;
            var validMesg = /[^a-zA-Z0-9+-._,@&#/' ]/;

            var statusArray = [<?php echo '"' . implode('","', array_values(config('leads.status.value'))) . '"' ?>];

            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';

            var id = document.getElementById('id');
            var date = document.getElementById('date');
            var user_id = document.getElementById('user_id');
            var select2_user_id_container = document.querySelector("[aria-labelledby='select2-user_id-container']");
            var category_id = document.getElementById('category_id');
            var select2_category_id_container = document.querySelector("[aria-labelledby='select2-category_id-container']");
            var sub_category_id = document.getElementById('sub_category_id');
            var select2_sub_category_id_container = document.querySelector("[aria-labelledby='select2-sub_category_id-container']");
            var status = document.getElementById('status');
            var select2_status_container = document.querySelector("[aria-labelledby='select2-status-container']");

            var business_name = document.getElementById('business_name');
            var email = document.getElementById('email');
            var country_id = document.getElementById('country_id');
            var select2_country_id_container = document.querySelector("[aria-labelledby='select2-country_id-container']");
            var state_id = document.getElementById('state_id');
            var select2_state_id_container = document.querySelector("[aria-labelledby='select2-state_id-container']");
            var city_id = document.getElementById('city_id');
            var select2_city_id_container = document.querySelector("[aria-labelledby='select2-city_id-container']");
            var dial_code = document.getElementById('dial_code');
            var mobile = document.getElementById('mobile');
            var iso = document.getElementById('iso');
            var phone = document.getElementById('phone');
            var fax = document.getElementById('fax');


            if (sub_category_id.value != '' && isNaN(sub_category_id.value) === false && sub_category_id.value > 0 && sub_category_id.value.length <= 10) {
                sub_category_id = sub_category_id.value;
            } else {
                sub_category_id = 0;
            }

            var errorMessageDate = document.getElementById('errorMessageDate');
            var errorMessageUserId = document.getElementById('errorMessageUserId');
            var errorMessageCategoryId = document.getElementById('errorMessageCategoryId');
            var errorMessageSubCategoryId = document.getElementById('errorMessageSubCategoryId');
            var errorMessageStatus = document.getElementById('errorMessageStatus');

            var errorMessageBusinessName = document.getElementById('errorMessageBusinessName');
            var errorMessageEmail = document.getElementById('errorMessageEmail');

            var errorMessageCountry = document.getElementById('errorMessageCountry');
            var errorMessageState = document.getElementById('errorMessageState');
            var errorMessageCity = document.getElementById('errorMessageCity');
            var errorMessageMobile = document.getElementById('errorMessageMobile');
            var errorMessagePhone = document.getElementById('errorMessagePhone');
            var errorMessageFax = document.getElementById('errorMessageFax');

            date.style.borderColor = select2_user_id_container.style.borderColor = select2_category_id_container.style.borderColor = select2_sub_category_id_container.style.borderColor = select2_status_container.style.borderColor = '#E4E6EF';
            business_name.style.borderColor = email.style.borderColor = select2_country_id_container.style.borderColor = select2_state_id_container.style.borderColor = select2_city_id_container.style.borderColor = mobile.style.borderColor = phone.style.borderColor = fax.style.borderColor = '#E4E6EF';
            errorMessageDate.innerText = errorMessageUserId.innerText = errorMessageCategoryId.innerText = errorMessageSubCategoryId.innerText = errorMessageStatus.innerText = '';
            errorMessageBusinessName.innerText = errorMessageEmail.innerText = errorMessageCountry.innerText = errorMessageState.innerText = errorMessageCity.innerText = errorMessageMobile.innerText = errorMessagePhone.innerText = errorMessageFax.innerText = '';

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
            } else if (status.value == '' || status.value == 0) {
                select2_status_container.style.borderColor = '#F00';
                error = "Status field is required.";
                toasterTrigger('error', error);
                errorMessageStatus.innerText = error;
                return false;
            } else if (statusArray.includes(status.value) == false || isNaN(status.value) === true || status.value.length > 3) {
                select2_status_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageStatus.innerText = error;
                return false;
            } else if (business_name.value == '') {
                business_name.style.borderColor = '#F00';
                error = "Business / Respondent Name field is required.";
                toasterTrigger('error', error);
                errorMessageBusinessName.innerText = error;
                return false;
            } else if (validName.test(business_name.value)) {
                business_name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                toasterTrigger('error', error);
                errorMessageBusinessName.innerText = error;
                return false;
            } else if (business_name.value.length > 50) {
                business_name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                toasterTrigger('error', error);
                errorMessageBusinessName.innerText = error;
                return false;
            }/* else if (email.value == '') {
                email.style.borderColor = '#F00';
                error = "Email field is required.";
                toasterTrigger('error', error);
                errorMessageEmail.innerText = error;
                return false;
            }*/ else if (email.value != '' && validEmail.test(email.value) == false) {
                email.style.borderColor = '#F00';
                error = "Invalid Email Address.";
                toasterTrigger('error', error);
                errorMessageEmail.innerText = error;
                return false;
            } else if (country_id.value == '') {
                select2_country_id_container.style.borderColor = '#F00';
                error = "Country field is required.";
                toasterTrigger('error', error);
                errorMessageCountry.innerText = error;
                return false;
            } else if (isNaN(country_id.value) === true || country_id.value <= 0 || country_id.value.length > 10) {
                select2_country_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageCountry.innerText = error;
                return false;
            }/* else if (state_id.value == '') {
                select2_state_id_container.style.borderColor = '#F00';
                error = "State field is required.";
                toasterTrigger('error', error);
                errorMessageState.innerText = error;
                return false;
            }*/ else if (state_id.value != '' && (isNaN(state_id.value) === true || state_id.value <= 0 || state_id.value.length > 10)) {
                select2_state_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageState.innerText = error;
                return false;
            }/* else if (city_id.value == '') {
                select2_city_id_container.style.borderColor = '#F00';
                error = "City field is required.";
                toasterTrigger('error', error);
                errorMessageCity.innerText = error;
                return false;
            }*/ else if (city_id.value != '' && (isNaN(city_id.value) === true || city_id.value <= 0 || city_id.value.length > 10)) {
                select2_city_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                toasterTrigger('error', error);
                errorMessageCity.innerText = error;
                return false;
            } else if (dial_code.value == '' || isNaN(dial_code.value) === true || dial_code.value <= 0 || dial_code.value.length > 9) {
                mobile.style.borderColor = '#F00';
                error = "Invalid country dial code.";
                toasterTrigger('error', error);
                errorMessageMobile.innerText = error;
                return false;
            } /*else if (mobile.value == '') {
                mobile.style.borderColor = '#F00';
                error = "Mobile No field is required.";
                toasterTrigger('error', error);
                errorMessageMobile.innerText = error;
                return false;
            }*/ else if (mobile.value != '' && (validContactNumber.test(mobile.value) == false || mobile.value.length !== 12)) {
                mobile.style.borderColor = '#F00';
                error = "Invalid Mobile No.";
                toasterTrigger('error', error);
                errorMessageMobile.innerText = error;
                return false;
            } else if (iso.value == '' || iso.value.length > 3 || validName.test(iso.value)) {
                mobile.style.borderColor = '#F00';
                error = "Invalid country iso.";
                toasterTrigger('error', error);
                errorMessageMobile.innerText = error;
                return false;
            } else if (phone.value != '' && (validContactNumber.test(phone.value) == false || phone.value.length !== 14)) {
                phone.style.borderColor = '#F00';
                error = "Invalid Phone number.";
                toasterTrigger('error', error);
                errorMessagePhone.innerText = error;
                return false;
            } else if (fax.value != '' && (validContactNumber.test(fax.value) == false || fax.value.length != 14)) {
                fax.style.borderColor = '#F00';
                error = "Invalid Fax number.";
                toasterTrigger('error', error);
                errorMessageFax.innerText = error;
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
                        "user_id": user_id.value,
                        "category_id": category_id.value,
                        "sub_category_id": sub_category_id,
                        "status": status.value,
                        "business_name": business_name.value,
                        "email": email.value,
                        "country_id": country_id.value,
                        "state_id": state_id.value,
                        "city_id": city_id.value,
                        "dial_code": dial_code.value,
                        "mobile": mobile.value,
                        "iso": iso.value,
                        "phone": phone.value,
                        "fax": fax.value,
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
                                    if (obj.code === 422) {
                                        if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                            if (obj.errorField == 'user_id') {
                                                select2_user_id_container.style.borderColor = '#F00';
                                            } else if (obj.errorField == 'category_id') {
                                                select2_category_id_container.style.borderColor = '#F00';
                                            } else if (obj.errorField == 'sub_category_id') {
                                                select2_sub_category_id_container.style.borderColor = '#F00';
                                            } else if (obj.errorField == 'status') {
                                                select2_status_container.style.borderColor = '#F00';
                                            } else if (obj.errorField == 'country_id') {
                                                select2_country_id_container.style.borderColor = '#F00';
                                            } else if (obj.errorField == 'state_id') {
                                                select2_state_id_container.style.borderColor = '#F00';
                                            } else if (obj.errorField == 'city_id') {
                                                select2_city_id_container.style.borderColor = '#F00';
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

                                                var select2_countryId_container = document.getElementById("select2-country_id-container");
                                                var select2_stateId_container = document.getElementById("select2-state_id-container");
                                                var select2_cityId_container = document.getElementById("select2-city_id-container");

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
                                                if (select2_countryId_container && select2_stateId_container && select2_cityId_container) {
                                                    select2_countryId_container.removeAttribute("title");
                                                    select2_stateId_container.removeAttribute("title");
                                                    select2_cityId_container.removeAttribute("title");
                                                    select2_countryId_container.innerHTML = select2_stateId_container.innerHTML = select2_cityId_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                }
                                                country_id.value = '';
                                                state_id.innerHTML = city_id.innerHTML = '';
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