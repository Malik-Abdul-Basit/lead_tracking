<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $id = $object->id;
    $date = $object->date;
    $calls = $object->calls;
    $follow_up = $object->follow_up;
    $good_response = $object->good_response;
    $bad_response = $object->bad_response;
    $bad_data = $object->bad_data;
    $lead_conversion = $object->lead_conversion;
    $no_answer = $object->no_answer;
    $voice_mails = $object->voice_mails;
    $emails_sent = $object->emails_sent;
    $user_right_title = $object->user_right_title;

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($date)) {
        echo json_encode(['code' => 422, 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Date field is required.']);
    } else if (!validDate($date) || strlen($date) !== 10) {
        echo json_encode(['code' => 422, 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Please select a valid date.']);
    } else if (empty($calls)) {
        echo json_encode(['code' => 422, 'errorField' => 'calls', 'errorDiv' => 'errorMessageCalls', 'errorMessage' => 'Number of Calls field is required.']);
    } else if (!is_numeric($calls) || strlen($calls) > 9 || $calls < 1) {
        echo json_encode(['code' => 422, 'errorField' => 'calls', 'errorDiv' => 'errorMessageCalls', 'errorMessage' => 'Number of Calls are invalid.']);
    } else if ($follow_up == '') {
        echo json_encode(['code' => 422, 'errorField' => 'follow_up', 'errorDiv' => 'errorMessageFollowUp', 'errorMessage' => 'Follow Up Calls field is required.']);
    } else if (!is_numeric($calls) || strlen($calls) > 9 || $calls < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'follow_up', 'errorDiv' => 'errorMessageFollowUp', 'errorMessage' => 'Invalid Number of Follow Up Calls.']);
    } else if ($good_response == '') {
        echo json_encode(['code' => 422, 'errorField' => 'good_response', 'errorDiv' => 'errorMessageGoodResponse', 'errorMessage' => 'Good Response field is required.']);
    } else if (!is_numeric($good_response) || strlen($good_response) > 9 || $good_response < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'good_response', 'errorDiv' => 'errorMessageGoodResponse', 'errorMessage' => 'Given data is invalid.']);
    } else if ($bad_response == '') {
        echo json_encode(['code' => 422, 'errorField' => 'bad_response', 'errorDiv' => 'errorMessageBadResponse', 'errorMessage' => 'Bad Response field is required.']);
    } else if (!is_numeric($bad_response) || strlen($bad_response) > 9 || $bad_response < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'bad_response', 'errorDiv' => 'errorMessageBadResponse', 'errorMessage' => 'Given data is invalid.']);
    } else if ($bad_data == '') {
        echo json_encode(['code' => 422, 'errorField' => 'bad_data', 'errorDiv' => 'errorMessageBadData', 'errorMessage' => 'Bad Data field is required.']);
    } else if (!is_numeric($bad_data) || strlen($bad_data) > 9 || $bad_data < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'bad_data', 'errorDiv' => 'errorMessageBadData', 'errorMessage' => 'Given data is invalid.']);
    } else if ($lead_conversion == '') {
        echo json_encode(['code' => 422, 'errorField' => 'lead_conversion', 'errorDiv' => 'errorMessageLeadConversion', 'errorMessage' => 'Lead Conversion field is required.']);
    } else if (!is_numeric($lead_conversion) || strlen($lead_conversion) > 9 || $lead_conversion < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'lead_conversion', 'errorDiv' => 'errorMessageLeadConversion', 'errorMessage' => 'Number of Lead Conversion is invalid.']);
    } else if ($no_answer == '') {
        echo json_encode(['code' => 422, 'errorField' => 'no_answer', 'errorDiv' => 'errorMessageNoAnswer', 'errorMessage' => 'No Answer field is required.']);
    } else if (!is_numeric($no_answer) || strlen($no_answer) > 9 || $no_answer < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'no_answer', 'errorDiv' => 'errorMessageNoAnswer', 'errorMessage' => 'Given data is invalid.']);
    } else if ($voice_mails == '') {
        echo json_encode(['code' => 422, 'errorField' => 'voice_mails', 'errorDiv' => 'errorMessageVoiceMails', 'errorMessage' => 'Voice Mails field is required.']);
    } else if (!is_numeric($voice_mails) || strlen($voice_mails) > 9 || $voice_mails < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'voice_mails', 'errorDiv' => 'errorMessageVoiceMails', 'errorMessage' => 'Given data is invalid.']);
    } else if ($emails_sent == '') {
        echo json_encode(['code' => 422, 'errorField' => 'emails_sent', 'errorDiv' => 'errorMessageEmailsSent', 'errorMessage' => 'Emails Sent field is required.']);
    } else if (!is_numeric($emails_sent) || strlen($emails_sent) > 9 || $emails_sent < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'emails_sent', 'errorDiv' => 'errorMessageEmailsSent', 'errorMessage' => 'Given data is invalid.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];

        $date = html_entity_decode(stripslashes(date('Y-m-d', strtotime($date))));

        $continueProcessing = false;
        $message = '';

        $check = mysqli_query($db, "SELECT `id` FROM `sources_lead_details` WHERE `date`='{$date}' AND `user_id`='{$user_id}' AND `id`!='{$id}' ORDER BY `id` ASC LIMIT 1");
        if ($check && mysqli_num_rows($check) > 0) {
            $code = 405;
            $toasterClass = 'error';
            $responseMessage = 'Record already exist of this date.';
            $form_reset = false;
        } else if (!empty($id) && is_numeric($id) && $id > 0 && hasRight($user_right_title, 'edit')) {

            $update = "UPDATE `sources_lead_details` SET `date`='{$date}',`calls`='{$calls}',`follow_up`='{$follow_up}',`good_response`='{$good_response}',`bad_response`='{$bad_response}',`bad_data`='{$bad_data}',`lead_conversion`='{$lead_conversion}',`no_answer`='{$no_answer}',`voice_mails`='{$voice_mails}',`emails_sent`='{$emails_sent}',`updated_by`='{$user_id}' WHERE `id`='{$id}' AND `user_id`='{$user_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
            mysqli_query($db, $update);

            $code = 200;
            $toasterClass = 'success';
            $responseMessage = 'Record successfully saved.';
            $form_reset = false;
        } else if (empty($id) && is_numeric($id) && hasRight($user_right_title, 'add')) {
            $insert = "INSERT INTO `sources_lead_details` (`id`, `date`, `user_id`, `calls`, `follow_up`, `good_response`, `bad_response`, `bad_data`, `lead_conversion`, `no_answer`, `voice_mails`, `emails_sent`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$date}', '{$user_id}', '{$calls}', '{$follow_up}', '{$good_response}', '{$bad_response}', '{$bad_data}', '{$lead_conversion}', '{$no_answer}', '{$voice_mails}', '{$emails_sent}', '{$company_id}', '{$branch_id}', '{$user_id}')";
            mysqli_query($db, $insert);

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
?>