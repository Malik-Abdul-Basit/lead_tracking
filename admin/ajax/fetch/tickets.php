<?php
include_once('../../../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];

if (isset($_POST['filters']) && !empty($_POST['filters'])) {
    $filters = (object)$_POST['filters'];

    $pageNo = 1;
    $perPage = 20;
    $sortColumn = 'e.employee_code';
    $sortOrder = 'ASC';
    $super_admin = config('users.type.value.super_admin');
    $condition = " WHERE e.company_id='{$global_company_id}' AND e.branch_id='{$global_branch_id}' AND e.deleted_at IS NULL AND u.type!='{$super_admin}' AND u.deleted_at IS NULL ";
    if (isset($filters->SearchQuery) && !empty($filters->SearchQuery) && strlen($filters->SearchQuery) > 0) {
        $condition .= " AND (e.employee_code LIKE '%{$filters->SearchQuery}%' OR CONCAT(eb.first_name,' ',eb.last_name) LIKE '%{$filters->SearchQuery}%' OR eb.pseudo_name LIKE '%{$filters->SearchQuery}%' OR eb.email LIKE '%{$filters->SearchQuery}%' OR eb.official_email LIKE '%{$filters->SearchQuery}%' OR CONCAT('+',eb.dial_code,' ',eb.mobile) LIKE '%{$filters->SearchQuery}%' OR CONCAT('+',eb.o_dial_code,' ',eb.other_mobile) LIKE '%{$filters->SearchQuery}%' OR eb.cnic LIKE '%{$filters->SearchQuery}%') ";
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
    $sql = mysqli_query($db, "SELECT count(e.id) AS total FROM employees AS e INNER JOIN employee_basic_infos AS eb ON e.id = eb.employee_id INNER JOIN users AS u ON e.id = u.employee_id" . $condition);
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


        $select = "SELECT e.id, e.employee_code,
        u.email, u.email_verified_at, u.status, u.type,
        CONCAT(eb.first_name,' ',eb.last_name) AS full_name, eb.pseudo_name
        FROM 
            employees AS e
        INNER JOIN 
            employee_basic_infos AS eb
        ON e.id = eb.employee_id
        INNER JOIN
            users AS u
        ON e.id = u.employee_id" . $condition . $sort . $number_of_record;

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
                            <div class="d-flex justify-content-end">
                                <div class="dropdown dropdown-inline" data-placement="left">
                                    <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ki ki-bold-more-hor"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                        <ul class="navi navi-hover">
                                            <li class="navi-item">
                                                <a href="#" class="text-primary navi-link">
                                                <i class="text-primary la la-edit"></i>
                                                    Edit
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="text-danger navi-link">
                                                <i class="text-danger la la-trash"></i>
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row text-left">
                                <div class="col-md-12">
                                    <span class="text-dark d-block font-weight-bold mt-3 py-2 px-3">
                                        Contrary to popular belief, Lorem Ipsum is not simply random text.
                                        This book is a treatise on the theory of ethics,
                                        very popular during the Renaissance.
                                    </span>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-block mb-3 py-2 px-3">
                                    <span class="float-right">TN-'.$result['employee_code'].'</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            $data .= '</div></td></tr></tbody></table>';
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