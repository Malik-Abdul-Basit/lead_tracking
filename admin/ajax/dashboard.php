<?php
include_once('../../includes/connection.php');

$company_id = $_SESSION['company_id'];
$branch_id = $_SESSION['branch_id'];
$user_id = $_SESSION['user_id'];
global $db;

if (isset($_POST['monthlyLeadsChart'])) {
    $data = $return = [];
    $object = (object)$_POST['monthlyLeadsChart'];
    $checkExist = mysqli_query($db, "SELECT COUNT(l.id) AS total, MONTH(l.date) AS lead_month, c.name AS category_name, category_id FROM leads AS l INNER JOIN categories AS c ON c.id=l.category_id WHERE l.company_id='{$company_id}' AND l.branch_id='{$branch_id}' AND l.deleted_at IS NULL AND c.deleted_at IS NULL AND YEAR(l.date) BETWEEN '{$object->CurrentYear}' AND '{$object->CurrentYear}' GROUP BY MONTH(l.date),l.category_id ORDER BY c.sort_by ASC");
    if (mysqli_num_rows($checkExist) > 0) {
        while ($result = mysqli_fetch_object($checkExist)) {
            $data[$result->category_id]['category_name'] = $result->category_name;
            //$data[$result->category_id]['lead_month'][$result->lead_month] = $result->lead_month;
            $data[$result->category_id]['total_leads'][$result->lead_month] = $result->total;
        }
    }

    if ($data && sizeof($data) > 0 && count($data) > 0) {
        $checkCategories = mysqli_query($db, "SELECT `id`, `name` FROM `categories` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC");
        if (mysqli_num_rows($checkCategories) > 0) {
            while ($category_object = mysqli_fetch_object($checkCategories)) {
                $setArray = [];

                if (array_key_exists($category_object->id, $data)) {
                    $setArray['name'] = $category_object->name;

                    $total_leads = $data[$category_object->id]['total_leads'];
                    //$lead_month = $data[$category_object->id]['lead_month'];

                    if ($total_leads && sizeof($total_leads) > 0 && count($total_leads) > 0) {
                        for ($m = 1; $m <= 12; $m++) {
                            if (array_key_exists($m, $total_leads)) {
                                $setArray['data'][] = (int)$total_leads[$m];
                            } else {
                                $setArray['data'][] = 0;
                            }
                        }
                    }
                    $return[] = $setArray;
                    $setArray = [];
                }
            }
        }
    }

    if ($data && sizeof($data) > 0 && count($data) > 0 && $return && sizeof($return) > 0 && count($return) > 0) {
        echo json_encode(["code" => 200, "data" => $return]);
    } else {
        echo json_encode(["code" => 500, "data" => '<div class="col-md-12"><div class="alert alert-danger text-center">Leads not found.</div></div>']);
    }
}

if (isset($_POST['yearlyLeadsPercentageChart'])) {
    $object = (object)$_POST['yearlyLeadsPercentageChart'];
    $year = $object->BG_Year;
    $pai_chart_data = $drill_down_chart_data = [];

    $sql_total = mysqli_query($db, "SELECT COUNT(l.id) AS total_leads FROM leads AS l INNER JOIN categories AS c ON c.id=l.category_id WHERE l.company_id='{$company_id}' AND l.branch_id='{$branch_id}' AND l.deleted_at IS NULL AND c.deleted_at IS NULL AND YEAR(l.date) = '{$year}' ORDER BY c.sort_by ASC");
    if ($sql_total && mysqli_num_rows($sql_total) > 0) {
        if ($obj_total = mysqli_fetch_object($sql_total)) {
            $total_leads = $obj_total->total_leads;
            if ($total_leads && $total_leads > 0) {
                $checkExist = mysqli_query($db, "SELECT category_id, c.name AS category_name, COUNT(l.id) AS total FROM leads AS l INNER JOIN categories AS c ON c.id=l.category_id WHERE l.company_id='{$company_id}' AND l.branch_id='{$branch_id}' AND l.deleted_at IS NULL AND c.deleted_at IS NULL AND YEAR(l.date) = '{$year}' GROUP BY l.category_id ORDER BY c.sort_by ASC");
                if (mysqli_num_rows($checkExist) > 0) {
                    while ($result = mysqli_fetch_object($checkExist)) {
                        $pai_chart_data[] = ['name' => $result->category_name, 'y' => (int)$result->total];
                        $total_percentage = round((($result->total) / ($total_leads) * 100), 2);
                        $drill_down_chart_data[] = ['name' => $result->category_name, 'y' => $total_percentage];
                    }
                }
                $data = ['year' => $year, 'pai_chart_data' => $pai_chart_data, 'drill_down_chart_data' => $drill_down_chart_data];
                echo json_encode(["code" => 200, "data" => $data]);
            } else {
                echo json_encode(["code" => 500, "data" => '<div class="col-md-12"><div class="alert alert-danger text-center">Leads not found.</div></div>']);
            }
        }
    } else {
        echo json_encode(["code" => 500, "data" => '<div class="col-md-12"><div class="alert alert-danger text-center">Leads not found.</div></div>']);
    }
}

if (isset($_POST['yearlyLeadsChart'])) {
    $object = (object)$_POST['yearlyLeadsChart'];
    $from = $object->StartYear;
    $to = $object->EndYear;
    $data = $return = $years = $categories = [];

    if ($from <= $to) {
        $sql = mysqli_query($db, "SELECT COUNT(l.id) AS total, YEAR(l.date) AS lead_year, c.name AS category_name, category_id FROM leads AS l INNER JOIN categories AS c ON c.id=l.category_id WHERE l.company_id='{$company_id}' AND l.branch_id='{$branch_id}' AND l.deleted_at IS NULL AND c.deleted_at IS NULL AND YEAR(l.date) BETWEEN '{$from}' AND '{$to}' GROUP BY YEAR(l.date),l.category_id ORDER BY YEAR(l.date) ASC");
        if ($sql && mysqli_num_rows($sql) > 0) {
            while ($result = mysqli_fetch_object($sql)) {
                $categories[$result->category_id] = $result->category_name;
                $data[$result->category_id][$result->lead_year] = $result->total;
            }

            if ($data && sizeof($data) > 0 && count($data) > 0 && $categories && sizeof($categories) > 0 && count($categories) > 0) {
                $categories = array_unique($categories);
                foreach ($categories as $key => $value) {
                    $setArray = [];
                    $setArray['name'] = $value;
                    if (array_key_exists($key, $data)) {
                        for ($y = $from; $y <= $to; $y++) {
                            $years [] = (int)$y;
                            if (array_key_exists($y, $data[$key])) {
                                $setArray['data'][] = (int)$data[$key][$y];
                            } else {
                                $setArray['data'][] = 0;
                            }
                        }
                    } else {
                        for ($y = $from; $y <= $to; $y++) {
                            $setArray['data'][] = 0;
                        }
                    }
                    $return[] = $setArray;
                }
                echo json_encode(["code" => 200, 'return' => $return, 'years' => array_unique($years)]);
            } else {
                echo json_encode(["code" => 500, "data" => '<div class="col-md-12"><div class="alert alert-danger text-center">Leads not found.</div></div>']);
            }
        } else {
            echo json_encode(["code" => 500, "data" => '<div class="col-md-12"><div class="alert alert-danger text-center">Leads not found.</div></div>']);
        }
    } else {
        echo json_encode(["code" => 500, "data" => '<div class="col-md-12"><div class="alert alert-danger text-center">"From" should less than "To".</div></div>']);
    }
}

if (isset($_POST['singleLeadChart'])) {
    $object = (object)$_POST['singleLeadChart'];
    $from = $object->RangeStart;
    $to = $object->RangeEnd;
    $category_id = $object->CategoryFilter;
    $category_name = '';
    $data = $return = [];

    $sql_category = mysqli_query($db, "SELECT `name` FROM `categories` WHERE `id`='{$category_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC LIMIT 1");
    if ($sql_category && mysqli_num_rows($sql_category) > 0) {
        if ($obj = mysqli_fetch_object($sql_category)) {
            $category_name = $obj->name;
            if ($from <= $to) {
                $checkExist = mysqli_query($db, "SELECT COUNT(l.id) AS total, YEAR(l.date) AS lead_year, c.name AS category_name FROM leads AS l INNER JOIN categories AS c ON c.id=l.category_id WHERE l.category_id='{$category_id}' AND l.company_id='{$company_id}' AND l.branch_id='{$branch_id}' AND l.deleted_at IS NULL AND c.deleted_at IS NULL AND YEAR(l.date) BETWEEN '{$from}' AND '{$to}' GROUP BY YEAR(l.date) ORDER BY YEAR(l.date) ASC");
                if (mysqli_num_rows($checkExist) > 0) {
                    while ($result = mysqli_fetch_object($checkExist)) {
                        $data[$result->lead_year] = $result->total;
                    }
                    for ($y = $from; $y <= $to; $y++) {
                        if (array_key_exists($y, $data)) {
                            $return[] = [(int)$y, (int)$data[$y]];
                        } else {
                            $return[] = [(int)$y, 0];
                        }
                    }
                    echo json_encode(["code" => 200, 'RangeStart' => $from, 'RangeEnd' => $to, 'Category' => $category_name, 'data' => $return]);

                } else {
                    echo json_encode(["code" => 500, "data" => '<div class="col-md-12"><div class="alert alert-danger text-center">Leads not found.</div></div>']);
                }
            } else {
                echo json_encode(["code" => 500, "data" => '<div class="col-md-12"><div class="alert alert-danger text-center">"From" should less than "To".</div></div>']);
            }
        }
    } else {
        echo json_encode(["code" => 500, "data" => '<div class="col-md-12"><div class="alert alert-danger text-center">Selected category not exist.</div></div>']);
    }
}

?>