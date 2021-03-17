<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $id = $object->id;
    $date = $object->date;
    $userid = $object->user_id;
    $category_id = $object->category_id;
    $sub_category_id = $object->sub_category_id;
    $status = $object->status;


    $business_name = $object->business_name;
    $email = $object->email;
    $country_id = $object->country_id;
    $state_id = $object->state_id;
    $city_id = $object->city_id;
    $dial_code = $object->dial_code;
    $mobile = $object->mobile;
    $iso = $object->iso;
    $phone = $object->phone;
    $fax = $object->fax;
    $data = $object->data;
    $user_right_title = $object->user_right_title;

    $status_array = array_values(config('leads.status.value'));

    /*echo '<pre>';
    print_r($object);
    echo '<pre>';
    exit();*/

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($date)) {
        echo json_encode(['code' => 422, 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Date field is required.']);
    } else if (!validDate($date) || strlen($date) !== 10) {
        echo json_encode(['code' => 422, 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Please select a valid date.']);
    } else if (empty($userid)) {
        echo json_encode(['code' => 422, 'errorField' => 'user_id', 'errorDiv' => 'errorMessageUserId', 'errorMessage' => 'Sales Person field is required.']);
    } else if (!is_numeric($userid) || strlen($userid) > 10 || $userid < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'user_id', 'errorDiv' => 'errorMessageUserId', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($category_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'category_id', 'errorDiv' => 'errorMessageCategoryId', 'errorMessage' => 'Category field is required.']);
    } else if (!is_numeric($category_id) || strlen($category_id) > 10 || $category_id < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'category_id', 'errorDiv' => 'errorMessageCategoryId', 'errorMessage' => 'Please select a valid option.']);
    } else if (!empty($sub_category_id) && (!is_numeric($sub_category_id) || strlen($sub_category_id) > 10 || $sub_category_id < 0)) {
        echo json_encode(['code' => 422, 'errorField' => 'sub_category_id', 'errorDiv' => 'errorMessageSubCategoryId', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($status)) {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Status field is required.']);
    } else if (!in_array($status, $status_array) || !is_numeric($status) || strlen($status) > 3) {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($business_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'business_name', 'errorDiv' => 'errorMessageBusinessName', 'errorMessage' => 'Business / Respondent Name field is required.']);
    } else if (!validName($business_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'business_name', 'errorDiv' => 'errorMessageBusinessName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (strlen($business_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'business_name', 'errorDiv' => 'errorMessageBusinessName', 'errorMessage' => 'Length should not exceed 50.']);
    } /*else if (empty($email)) {
        echo json_encode(['code' => 422, 'errorField' => 'email', 'errorDiv' => 'errorMessageEmail', 'errorMessage' => 'Email field is required.']);
    }*/ else if (!empty($email) && !validEmail($email)) {
        echo json_encode(['code' => 422, 'errorField' => 'email', 'errorDiv' => 'errorMessageEmail', 'errorMessage' => 'Invalid Email Address.']);
    } else if (empty($country_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'country_id', 'errorDiv' => 'errorMessageCountry', 'errorMessage' => 'Country field is required.']);
    } else if (!is_numeric($country_id) || strlen($country_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'country_id', 'errorDiv' => 'errorMessageCountry', 'errorMessage' => 'Please select a valid option.']);
    }/* else if (empty($state_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'state_id', 'errorDiv' => 'errorMessageState', 'errorMessage' => 'State field is required.']);
    }*/ else if (!empty($state_id) && (!is_numeric($state_id) || strlen($state_id) > 10)) {
        echo json_encode(['code' => 422, 'errorField' => 'state_id', 'errorDiv' => 'errorMessageState', 'errorMessage' => 'Please select a valid option.']);
    }/* else if (empty($city_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'city_id', 'errorDiv' => 'errorMessageCity', 'errorMessage' => 'City field is required.']);
    }*/ else if (!empty($city_id) && (!is_numeric($city_id) || strlen($city_id) > 10)) {
        echo json_encode(['code' => 422, 'errorField' => 'city_id', 'errorDiv' => 'errorMessageCity', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($dial_code) || !is_numeric($dial_code) || strlen($dial_code) > 9) {
        echo json_encode(['code' => 422, 'errorField' => 'mobile', 'errorDiv' => 'errorMessageMobile', 'errorMessage' => 'Invalid country dial code.']);
    } /*else if (empty($mobile)) {
        echo json_encode(['code' => 422, 'errorField' => 'mobile', 'errorDiv' => 'errorMessageMobile', 'errorMessage' => 'Mobile No field is required.']);
    }*/ else if (!empty($mobile) && (!validMobileNumber($mobile) || strlen($mobile) !== 12)) {
        echo json_encode(['code' => 422, 'errorField' => 'mobile', 'errorDiv' => 'errorMessageMobile', 'errorMessage' => 'Invalid Mobile number.']);
    } else if (empty($iso) || !validName($iso) || strlen($iso) > 3) {
        echo json_encode(['code' => 422, 'errorField' => 'mobile', 'errorDiv' => 'errorMessageMobile', 'errorMessage' => 'Invalid country iso.']);
    } else if (!empty($phone) && (!validPhoneNumber($phone) || strlen($phone) !== 14)) {
        echo json_encode(['code' => 422, 'errorField' => 'phone', 'errorDiv' => 'errorMessagePhone', 'errorMessage' => 'Invalid Phone number.']);
    } else if (!empty($fax) && (!validPhoneNumber($fax) || strlen($fax) != 14)) {
        echo json_encode(['code' => 422, 'errorField' => 'fax', 'errorDiv' => 'errorMessageFax', 'errorMessage' => 'Invalid Fax number.']);
    } else if (empty($object->data) || sizeof($object->data) < 1) {
        echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Please provide at least one Communication.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];
        $continueProcessing = false;
        $message = '';

        foreach ($object->data as $row => $data) {
            $row++;
            if (empty($data['question'])) {
                $message = 'Question field is required, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!validAddress($data['question'])) {
                $message = 'Special Characters are not Allowed in Question field, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!empty($data['answer']) && !validAddress($data['answer'])) {
                $message = 'Special Characters are not Allowed in Answer field, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else {
                $continueProcessing = true;
            }
        }

        if ($continueProcessing === false) {
            echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => $message]);
        } else {
            $business_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($business_name))));
            $date = html_entity_decode(stripslashes(date('Y-m-d', strtotime($date))));

            if (!empty($id) && is_numeric($id) && $id > 0 && hasRight($user_right_title, 'edit')) {

                $added_by = $updated_by = $user_id;
                $created_at = $updated_at = date("Y-m-d H:i:s");

                $old_lead_messages_sql = mysqli_query($db, "SELECT `added_by`, `created_at` FROM `lead_messages` WHERE `lead_id`='{$id}' ORDER BY `id` ASC LIMIT 1");
                if ($old_lead_messages_sql && mysqli_num_rows($old_lead_messages_sql) > 0) {
                    if ($result = mysqli_fetch_object($old_lead_messages_sql)) {
                        $added_by = $result->added_by;
                        $created_at = $result->created_at;
                    }
                    mysqli_query($db, "DELETE FROM `lead_messages` WHERE `lead_id`='{$id}'");
                }

                $update = "UPDATE `leads` SET `date`='{$date}',`user_id`='{$userid}',`category_id`='{$category_id}',`sub_category_id`='{$sub_category_id}',`status`='{$status}',`business_name`='{$business_name}',`email`='{$email}',`country_id`='{$country_id}',`state_id`='{$state_id}',`city_id`='{$city_id}',`dial_code`='{$dial_code}',`mobile`='{$mobile}',`iso`='{$iso}',`phone`='{$phone}',`fax`='{$fax}',`updated_by`='{$user_id}' WHERE `id`='{$id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
                mysqli_query($db, $update);
                foreach ($object->data as $row => $data) {
                    $insert = "INSERT INTO `lead_messages`(`id`, `lead_id`, `question`, `answer`, `added_by`, `created_at`, `updated_by`, `updated_at`) VALUES (NULL,'{$id}','{$data['question']}','{$data['answer']}','{$added_by}','{$created_at}','{$updated_by}','{$updated_at}')";
                    mysqli_query($db, $insert);
                }
                $code = 200;
                $toasterClass = 'success';
                $responseMessage = 'Record successfully saved.';
                $form_reset = false;
            } else if (empty($id) && is_numeric($id) && hasRight($user_right_title, 'add')) {
                $insert = "INSERT INTO `leads`(`id`, `date`, `user_id`, `category_id`, `sub_category_id`, `status`, `business_name`, `email`, `country_id`, `state_id`, `city_id`, `dial_code`, `mobile`, `iso`, `phone`, `fax`, `company_id`, `branch_id`, `added_by`) VALUES (NULL,'{$date}','{$userid}','{$category_id}','{$sub_category_id}','{$status}','{$business_name}','{$email}','{$country_id}','{$state_id}','{$city_id}','{$dial_code}','{$mobile}','{$iso}','{$phone}','{$fax}','{$company_id}','{$branch_id}','{$user_id}')";
                mysqli_query($db, $insert);
                $insert_id = mysqli_insert_id($db);
                foreach ($object->data as $row => $data) {
                    $insert = "INSERT INTO `lead_messages`(`id`, `lead_id`, `question`, `answer`, `added_by`) VALUES (NULL,'{$insert_id}','{$data['question']}','{$data['answer']}','{$user_id}')";
                    mysqli_query($db, $insert);
                }
                $code = 200;
                $toasterClass = 'success';
                $responseMessage = 'Record successfully insert.';
                $form_reset = true;
            } else {
                $code = 405;
                $toasterClass = 'warning';
                $responseMessage = 'Sorry! You have no right to this action.';
                $form_reset = true;
            }
            echo json_encode(['code' => $code, "toasterClass" => $toasterClass, "responseMessage" => $responseMessage, 'form_reset' => $form_reset]);
        }
    }
}
?>