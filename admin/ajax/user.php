<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $id = $object->id;
    $employee_code = $object->employee_code;
    $title = $object->title;
    $first_name = trim($object->first_name);
    $last_name = trim($object->last_name);
    $pseudo_name = trim($object->pseudo_name);
    $email = $object->email;
    $gender = $object->gender;
    $country_id = $object->country_id;
    $state_id = $object->state_id;
    $city_id = $object->city_id;
    $status = $object->status;
    $type = $object->type;
    $user_right_title = $object->user_right_title;

    $title_array = array_values(config('users.title.value'));
    $gender_array = array_values(config('users.gender.value'));
    $status_array = array_values(config('users.status.value'));
    $type_array = array_values(config('users.type.value'));

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($employee_code)) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Employee Code field is required.']);
    } else if (!is_numeric($employee_code) || strlen($employee_code) > 20) {
        echo json_encode(['code' => 422, 'errorField' => 'employee_code', 'errorDiv' => 'errorMessageEmployeeCode', 'errorMessage' => 'Invalid Employee Code.']);
    } else if (empty($title)) {
        echo json_encode(['code' => 422, 'errorField' => 'title', 'errorDiv' => 'errorMessageTitle', 'errorMessage' => 'Title field is required.']);
    } else if (!in_array($title, $title_array) || strlen($title) > 5) {
        echo json_encode(['code' => 422, 'errorField' => 'title', 'errorDiv' => 'errorMessageTitle', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($first_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'first_name', 'errorDiv' => 'errorMessageFirstName', 'errorMessage' => 'First Name field is required.']);
    } else if (!validName($first_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'first_name', 'errorDiv' => 'errorMessageFirstName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (strlen($first_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'first_name', 'errorDiv' => 'errorMessageFirstName', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (!empty($last_name) && !validName($last_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'last_name', 'errorDiv' => 'errorMessageLastName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($last_name) && strlen($last_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'last_name', 'errorDiv' => 'errorMessageLastName', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (!empty($pseudo_name) && !validName($pseudo_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'pseudo_name', 'errorDiv' => 'errorMessagePseudoName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($pseudo_name) && strlen($pseudo_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'pseudo_name', 'errorDiv' => 'errorMessagePseudoName', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (empty($email)) {
        echo json_encode(['code' => 422, 'errorField' => 'email', 'errorDiv' => 'errorMessageEmail', 'errorMessage' => 'Email field is required.']);
    } else if (!validEmail($email)) {
        echo json_encode(['code' => 422, 'errorField' => 'email', 'errorDiv' => 'errorMessageEmail', 'errorMessage' => 'Invalid Email Address.']);
    } else if (empty($gender)) {
        echo json_encode(['code' => 422, 'errorField' => 'gender', 'errorDiv' => 'errorMessageGender', 'errorMessage' => 'Gender field is required.']);
    } else if (!in_array($gender, $gender_array) || strlen($gender) !== 1) {
        echo json_encode(['code' => 422, 'errorField' => 'gender', 'errorDiv' => 'errorMessageGender', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($country_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'country_id', 'errorDiv' => 'errorMessageCountry', 'errorMessage' => 'Country field is required.']);
    } else if (!is_numeric($country_id) || strlen($country_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'country_id', 'errorDiv' => 'errorMessageCountry', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($state_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'state_id', 'errorDiv' => 'errorMessageState', 'errorMessage' => 'State field is required.']);
    } else if (!is_numeric($state_id) || strlen($state_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'state_id', 'errorDiv' => 'errorMessageState', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($city_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'city_id', 'errorDiv' => 'errorMessageCity', 'errorMessage' => 'City field is required.']);
    } else if (!is_numeric($city_id) || strlen($city_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'city_id', 'errorDiv' => 'errorMessageCity', 'errorMessage' => 'Please select a valid option.']);
    } else if ($status == '') {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Status field is required.']);
    } else if (!in_array($status, $status_array) || strlen($status) !== 1) {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Please select a valid option.']);
    } else if ($type == '') {
        echo json_encode(['code' => 422, 'errorField' => 'type', 'errorDiv' => 'errorMessageType', 'errorMessage' => 'Type field is required.']);
    } else if (!in_array($type, $type_array) || strlen($type) !== 1) {
        echo json_encode(['code' => 422, 'errorField' => 'type', 'errorDiv' => 'errorMessageType', 'errorMessage' => 'Please select a valid option.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];

        $select = "SELECT `id` FROM `users` WHERE `company_id`='{$company_id}' AND `id`!='{$id}' AND (`employee_code`='{$employee_code}' OR `email`='{$email}')";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'This user already exist.']);
        } else {
            $employee_code = html_entity_decode(stripslashes(strip_tags($employee_code)));
            $first_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($first_name))));
            $last_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($last_name))));
            $pseudo_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($pseudo_name))));

            if (!empty($id) && $id > 0 && hasRight($user_right_title, 'edit')) {
                $update = "UPDATE `users` SET `employee_code`='{$employee_code}',`title`='{$title}',`first_name`='{$first_name}',`last_name`='{$last_name}',`pseudo_name`='{$pseudo_name}',`gender`='{$gender}',`email`='{$email}',`status`='{$status}',`type`='{$type}',`country_id`='{$country_id}', `state_id`='{$state_id}', `city_id`='{$city_id}',`updated_by`='{$user_id}' WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`='{$id}'";
                if (mysqli_query($db, $update)) {
                    echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.']);
                } else {
                    echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
                }
            } else if (empty($id) && hasRight($user_right_title, 'add')) {
                $password = generatePassword($length = 8, TRUE);
                $password = md5($password);
                $insert = "INSERT INTO `users`(`id`, `employee_code`, `title`, `first_name`, `last_name`, `pseudo_name`, `gender`, `email`, `password`, `email_verified_at`, `status`, `type`, `country_id`, `state_id`, `city_id`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$employee_code}', '{$title}', '{$first_name}', '{$last_name}', '{$pseudo_name}', '{$gender}', '{$email}', '{$password}', NULL,'{$status}','{$type}','{$country_id}','{$state_id}','{$city_id}','{$company_id}','{$branch_id}','{$user_id}')";
                if (mysqli_query($db, $insert)) {
                    echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.', 'form_reset' => TRUE]);
                } else {
                    echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
                }
            } else {
                echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
            }
        }
    }
}
?>