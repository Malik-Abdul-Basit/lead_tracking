<?php
include_once('../../../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];

if (isset($_POST['filters']) && !empty($_POST['filters'])) {
    $filters = (object)$_POST['filters'];

    $pageNo = 1;
    $perPage = 20;
    $sortColumn = 'u.employee_code';
    $sortOrder = 'ASC';
    $super_admin = config('users.type.value.super_admin');
    $co_active = config('companies.status.value.working');
    $br_active = config('branches.status.value.working');
    $condition = " WHERE u.company_id='{$global_company_id}' AND u.branch_id='{$global_branch_id}' AND u.deleted_at IS NULL AND u.type!='{$super_admin}' AND c.deleted_at IS NULL AND c.status ='{$co_active}' AND b.deleted_at IS NULL AND b.status ='{$br_active}' ";
    if (isset($filters->SearchQuery) && !empty($filters->SearchQuery) && strlen($filters->SearchQuery) > 0) {
        $condition .= " AND (u.employee_code LIKE '%{$filters->SearchQuery}%' OR CONCAT(u.first_name,' ',u.last_name) LIKE '%{$filters->SearchQuery}%' OR u.pseudo_name LIKE '%{$filters->SearchQuery}%' OR u.email LIKE '%{$filters->SearchQuery}%') ";
    }

    if (isset($filters->Filter) && !empty($filters->Filter) && count($filters->Filter) > 0) {
        $queryFilter = (object)$filters->Filter;
        foreach ($queryFilter as $filterRow) {
            $filterCol = $filterRow['field'];
            $filterVal = $filterRow['value'];
            if ($filterVal != '' && $filterVal != '-1') {
                $condition .= " AND " . $filterCol . " = '" . $filterVal . "'";
            }
        }
    }

    $total = 0;
    $data = '';
    $sql = mysqli_query($db, "SELECT count(u.id) AS total FROM users AS u INNER JOIN companies AS c ON c.id = u.company_id INNER JOIN branches AS b ON b.id = u.branch_id " . $condition);
    if (mysqli_num_rows($sql) > 0) {
        $result = mysqli_fetch_object($sql);
        $total = $result->total;
    }

    if (isset($filters->Sort) && !empty($filters->Sort) && sizeof($filters->Sort) > 0) {
        $sort_object = (object)$filters->Sort;
        if (!empty($sort_object->SortColumn)) {
            $sortColumn = $sort_object->SortColumn;
        }
        if (!empty($sort_object->SortOrder)) {
            $sortOrder = $sort_object->SortOrder;
        }
    }

    $data .= '<table class="datatable-table d-block" style="overflow:visible"><thead class="datatable-head"><tr style="left:0" class="datatable-row">';
    $data .= '<th data-field="employee_code" class="datatable-cell-center"><span style="width:100%;">&nbsp;</span></th></tr></thead><tbody class="datatable-body">';

    $not_found = '<tr style="left:0" class="datatable-row"><td class="datatable-cell-center datatable-cell"><div class="card card-custom gutter-b"><div class="card-body">Record Not Found.</div></div></td></tr></tbody></table>';

    if ($total > 0) {

        if (isset($filters->PageNumber) && !empty($filters->PageNumber) && strlen($filters->PageNumber) > 0) {
            $pageNo = $filters->PageNumber;
        }
        if (isset($filters->PageSize) && !empty($filters->PageSize) && strlen($filters->PageSize) > 0) {
            $perPage = $filters->PageSize;
        }

        $offset = round(round($pageNo) * round($perPage)) - round($perPage);
        $sort = " ORDER BY " . $sortColumn . " " . $sortOrder;
        if ($total <= $offset) {
            $number_of_record = " LIMIT 0, " . $total;
            $pageNo = 1;
        } else {
            $number_of_record = " LIMIT " . $offset . ", " . $perPage;
        }


        $select = "SELECT u.id, u.employee_code,
        u.email, u.email_verified_at, u.status, u.type,
        CONCAT(u.first_name,' ',u.last_name) AS full_name, u.pseudo_name
        FROM 
            users AS u 
        INNER JOIN 
            companies AS c 
            ON c.id = u.company_id 
        INNER JOIN 
            branches AS b 
            ON b.id = u.branch_id" . $condition . $sort . $number_of_record;

        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $row_number = 0;
            $data .= '<tr style="left:0" data-row="1" class="datatable-row  datatable-row-even"><td><div class="row">';
            while ($result = mysqli_fetch_assoc($query)) {
                $row_number++;
                $evenOrOdd = ($row_number % 2) == 1 ? 'odd' : 'even';
                $checkImage = getUserImage($result["id"]);
                $image_path = $checkImage['image_path'];
                $img = $checkImage['img'];
                $default_image = $checkImage['default'];
                $email_verified_at = !empty($result['email_verified_at']) ? date('d-M-Y', strtotime($result['email_verified_at'])) : '-';
                $pseudo_name = !empty($result['pseudo_name']) ? $result['pseudo_name'] : '-';
                $email_verification_status = empty($result['email_verified_at']) ? config('users.email_verified_at.unverified') : config('users.email_verified_at.verified');

                $data .= '
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 float-left mt-8" data-item="' . $row_number . '">
                    <div class="card card-custom gutter-b card-stretch">
                        <div class="card-body card-header-right ribbon ribbon-clip ribbon-right text-center pt-5 px-3 pb-9">
                            <div class="ribbon-target" style="top:9px;padding: 3px 1px !important;">
                                <span class="ribbon-inner bg-' . config('users.status.class.' . $result["status"]) . '"></span>' . config('users.status.icon.' . $result["status"]) . '
                            </div>
                        
                            <div class="d-flex justify-content-end"></div>
                            <div style="margin: -40px 0 0 0">
                                <div class="email_verification_status">'.$email_verification_status.'</div>
                                <div class="symbol symbol-circle symbol-lg-75 p-2 bg-white user_image" style="box-shadow: 0px 0px 30px 0px rgba(82, 63, 105, 0.03);">
                                    <img style=" height: 90px; max-width: 90px; width: 90px;" src="' . $image_path . '" alt="' . $img . '"/>
                                </div>
                            </div>
                            <div class="mb-3">
                                <span class="text-dark font-weight-bold font-size-h4 d-block">' . $result['full_name'] . '</span>
                                <small class="d-block">
                                    <a href="mailto:' . $result['email'] . '" class="text-dark text-hover-primary">' . $result['email'] . '</a>
                                </small>
                            </div>';
                $data .= config('users.type.icon.'.$result["type"]);
                if (isset($filters->L)) {
                    if (hasRight($filters->L, 'assign_rights') || hasRight($filters->L, 'edit')) {
                        $data .='<div class="my-4">';
                        if (hasRight($filters->L, 'edit'))
                            $data .='<a href="'.$admin_url.'user?id='.$result['id'].'" class="btn btn-sm btn-light-success font-weight-bolder text-uppercase mr-2" style="font-size: 10px">Edit</a>';

                        if (hasRight($filters->L, 'assign_rights'))
                            $data .='<a href="'.$admin_url.'user_rights?emp_code='.$result['employee_code'].'" class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-2" style="font-size: 10px">Rights</a>';

                        $data .='</div>';
                    }
                }
                $data .=' <div class="row text-left">
                                <div class="col-md-12 mt-4">
                                    <span class="text-dark font-weight-bold col-md-6">Employee Code : </span>' . $result['employee_code'] . '
                                </div>
                            </div>
                            <div class="row text-left">
                                <div class="col-md-12 mt-3">
                                    <span class="text-dark font-weight-bold col-md-6">Pseudo Name : </span> ' . $pseudo_name . '
                                </div>
                            </div>
                            <div class="row text-left">
                                <div class="col-md-12 mt-3">
                                    <span class="text-dark font-weight-bold col-md-6">Email Verified At : </span>' . $email_verified_at . '
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            $data .= '</div></td></tr></tbody></table>';
            //$data.='<input type="hidden" id="BG_SortColumn" value="'.$sortColumn.'"><input type="hidden" id="BG_SortOrder" value="'.$sortOrder.'">';
            //$data.='<input type="hidden" id="BG_FilterColumn" value="'.$sortColumn.'"><input type="hidden" id="BG_FilterValue" value="'.$sortOrder.'">';
            $Pagination = $data .= getPaginationNumbering($pageNo, $perPage, $total, $filters->PageSizeStack);

        } else {
            $data .= $not_found;
        }
    } else {
        $data .= $not_found;
    }
    echo json_encode(['code' => 200, 'data' => $data]);
}
?>