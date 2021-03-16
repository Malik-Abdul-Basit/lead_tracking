<?php
include_once("header/check_login.php");
include_once("../includes/head.php");
include_once("../includes/mobile_menu.php");
$current_year = date('Y');
$starting_year = round($current_year - 20);
$last_five_year = round($current_year - 5);
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

                <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
                        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center flex-wrap mr-2">
                                <!--begin::Page Title-->
                                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                                    Dashboard </h5>
                                <!--end::Page Title-->
                            </div>
                            <!--end::Info-->

                            <!--begin::Toolbar-->
                            <div class="d-flex align-items-center">
                                <div class="dropdown dropdown-inline" data-toggle="tooltip" title="Quick actions"
                                     data-placement="left">
                                    <a href="#" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <span class="svg-icon svg-icon-success svg-icon-lg">
                                            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,
                                                    2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,
                                                    21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,
                                                    3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000"
                                                          fill-rule="nonzero" opacity="0.3"/>
                                                    <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,
                                                    10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,
                                                    12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,
                                                    17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right py-3">
                                        <!--begin::Navigation-->
                                        <ul class="navi navi-hover py-5">
                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                    <span class="navi-icon"><i class="flaticon2-drop"></i></span>
                                                    <span class="navi-text">New Group</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                    <span class="navi-icon"><i class="flaticon2-list-3"></i></span>
                                                    <span class="navi-text">Contacts</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                    <span class="navi-icon"><i class="flaticon2-rocket-1"></i></span>
                                                    <span class="navi-text">Groups</span>
                                                    <span class="navi-link-badge">
                                                        <span class="label label-light-primary label-inline font-weight-bold">new</span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                    <span class="navi-icon"><i class="flaticon2-bell-2"></i></span>
                                                    <span class="navi-text">Calls</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                    <span class="navi-icon"><i class="flaticon2-gear"></i></span>
                                                    <span class="navi-text">Settings</span>
                                                </a>
                                            </li>

                                            <li class="navi-separator my-3"></li>

                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                    <span class="navi-icon"><i
                                                                class="flaticon2-magnifier-tool"></i></span>
                                                    <span class="navi-text">Help</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                    <span class="navi-icon"><i class="flaticon2-bell-2"></i></span>
                                                    <span class="navi-text">Privacy</span>
                                                    <span class="navi-link-badge">
                                                        <span class="label label-light-danger label-rounded font-weight-bold">5</span>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <!--end::Navigation-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column-fluid">
                        <div class="container">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-custom card-stretch gutter-b">
                                        <div class="card-header pt-6">
                                            <div class="col-sm-9 my-2 my-md-0"></div>
                                            <div class="col-sm-3 my-2 my-md-0">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="BG_CurrentYear">Year</label>
                                                    <select class="form-control"
                                                            id="BG_CurrentYear"
                                                            onchange="callMonthlyLeadsData()">
                                                        <?php
                                                        for ($y = $starting_year; $y <= $current_year; $y++) {
                                                            $s = ($y == $current_year) ? 'selected="selected"' : '';
                                                            echo '<option value="' . $y . '" ' . $s . '>' . $y . '</option>';
                                                        }
                                                        //$months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
                                                        //$transposed = array_slice($months, date('n'), 12, true) + array_slice($months, 0, date('n'), true);
                                                        //$last8 = array_reverse(array_slice($transposed, -8, 12, true), true);
                                                        /*foreach ($months as $num => $name) {
                                                            printf('<option value="%u">%s</option>', $num, $name);
                                                        }*/
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column px-2 py-4">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div id="monthlyLeadsHistogramChartWrapper"
                                                         class="HighChartWrapper"></div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div id="monthlyLeadsChartWrapper" class="HighChartWrapper"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-custom card-stretch gutter-b">
                                        <div class="card-header pt-6">
                                            <div class="col-sm-6 my-2 my-md-0"></div>
                                            <div class="col-sm-3 my-2 my-md-0">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="BG_StartYear">From</label>
                                                    <select class="form-control"
                                                            id="BG_StartYear"
                                                            onchange="callYearlyLeadChartData()">
                                                        <?php
                                                        for ($y = $starting_year; $y <= $current_year; $y++) {
                                                            $s = ($y == $last_five_year) ? 'selected="selected"' : '';
                                                            echo '<option value="' . $y . '" ' . $s . '>' . $y . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 my-2 my-md-0">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="BG_EndYear">To</label>
                                                    <select class="form-control"
                                                            id="BG_EndYear"
                                                            onchange="callYearlyLeadChartData()">
                                                        <?php
                                                        for ($y = $starting_year; $y <= $current_year; $y++) {
                                                            $s = ($y == $current_year) ? 'selected="selected"' : '';
                                                            echo '<option value="' . $y . '" ' . $s . '>' . $y . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column px-2 py-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="yearlyLeadsChartWrapper"
                                                         class="HighChartWrapper"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-custom card-stretch gutter-b">
                                        <div class="card-header pt-6"><!--border-0-->
                                            <div class="col-sm-2 my-2 my-md-0"></div>
                                            <div class="col-sm-4 my-2 my-md-0">
                                                <div class="form-group">
                                                    <label class="font-weight-bold"
                                                           for="BG_CategoryFilter">Category</label>
                                                    <select class="form-control"
                                                            id="BG_CategoryFilter"
                                                            onchange="callSingleLeadChartData()">
                                                        <?php
                                                        $select = "SELECT c.id, c.name FROM categories AS c INNER JOIN leads AS l ON c.id=l.category_id WHERE c.company_id='{$global_company_id}' AND c.branch_id='{$global_branch_id}' AND c.deleted_at IS NULL GROUP BY c.id ORDER BY c.sort_by ASC";
                                                        $query = mysqli_query($db, $select);
                                                        if (mysqli_num_rows($query) > 0) {
                                                            while ($result = mysqli_fetch_object($query)) {
                                                                ?>
                                                                <option value="<?php echo $result->id; ?>"><?php echo $result->name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 my-2 my-md-0">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="BG_RangeStart">From</label>
                                                    <select class="form-control"
                                                            id="BG_RangeStart"
                                                            onchange="callSingleLeadChartData()">
                                                        <?php
                                                        for ($y = $starting_year; $y <= $current_year; $y++) {
                                                            $s = ($y == $last_five_year) ? 'selected="selected"' : '';
                                                            echo '<option value="' . $y . '" ' . $s . '>' . $y . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 my-2 my-md-0">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="BG_RangeEnd">To</label>
                                                    <select class="form-control"
                                                            id="BG_RangeEnd"
                                                            onchange="callSingleLeadChartData()">
                                                        <?php
                                                        for ($y = $starting_year; $y <= $current_year; $y++) {
                                                            $s = ($y == $current_year) ? 'selected="selected"' : '';
                                                            echo '<option value="' . $y . '" ' . $s . '>' . $y . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div id="singleLeadChartWrapper" class="HighChartWrapper"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <!--begin::Footer Statement-->
                <?php include_once("../includes/footer_statement.php"); ?>
                <!--end::Footer Statement-->
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
    <script type="text/javascript">
        getAllPageData();

        function getAllPageData() {
            var BG_StartYear = document.getElementById('BG_StartYear');
            var BG_EndYear = document.getElementById('BG_EndYear');
            var BG_CategoryFilter = document.getElementById('BG_CategoryFilter');
            var BG_RangeStart = document.getElementById('BG_RangeStart');
            var BG_RangeEnd = document.getElementById('BG_RangeEnd');
            var BG_CurrentYear = document.getElementById('BG_CurrentYear');

            var filter = {
                'StartYear': BG_StartYear.value,
                'EndYear': BG_EndYear.value,
                'CategoryFilter': BG_CategoryFilter.value,
                'RangeStart': BG_RangeStart.value,
                'RangeEnd': BG_RangeEnd.value,
                'CurrentYear': BG_CurrentYear.value,
            };
            getMonthlyLeadsData(filter);
            getSingleLeadChartData(filter);
            getYearlyLeadChartData(filter);
        }

        function callYearlyLeadChartData() {
            var BG_StartYear = document.getElementById('BG_StartYear');
            var BG_EndYear = document.getElementById('BG_EndYear');

            var filter = {
                'StartYear': BG_StartYear.value,
                'EndYear': BG_EndYear.value,
            };
            getYearlyLeadChartData(filter);
        }
        function getYearlyLeadChartData(filter) {
            loader(true);
            $.ajax({
                type: "POST", url: "ajax/dashboard.php",
                data: {'yearlyLeadsChart': filter},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var ParseResponse = JSON.parse(resPonse);
                        console.log(ParseResponse);
                        yearlyLeadsChart(ParseResponse);
                        loader(false);
                    } else {
                        loader(false);
                    }
                },
                error: function () {
                    loader(false);
                }
            });
        }
        function yearlyLeadsChart(ParseResponse) {
            Highcharts.chart('yearlyLeadsChartWrapper', {
                chart: {
                    type: 'area'
                },
                title: {
                    text: 'Yearly Leads Chart'
                },
                subtitle: {
                    text: 'For all sources'
                },
                xAxis: {
                    categories: ParseResponse.years,
                    tickmarkPlacement: 'on',
                    title: {
                        enabled: false
                    }
                },
                yAxis: {
                    title: {
                        text: null
                    },
                    labels: {
                        formatter: function () {
                            //return this.value;
                            return '';
                        }
                    }
                },
                tooltip: {
                    split: true,
                    valueSuffix: ''
                },
                plotOptions: {
                    area: {
                        stacking: 'normal',
                        lineColor: '#666666',
                        lineWidth: 1,
                        marker: {
                            lineWidth: 1,
                            lineColor: '#666666'
                        }
                    }
                },
                series: ParseResponse.return
            });
        }

        function callSingleLeadChartData() {
            var BG_CategoryFilter = document.getElementById('BG_CategoryFilter');
            var BG_RangeStart = document.getElementById('BG_RangeStart');
            var BG_RangeEnd = document.getElementById('BG_RangeEnd');

            var filter = {
                'CategoryFilter': BG_CategoryFilter.value,
                'RangeStart': BG_RangeStart.value,
                'RangeEnd': BG_RangeEnd.value,
            };
            getSingleLeadChartData(filter);
        }
        function getSingleLeadChartData(filter) {
            loader(true);
            $.ajax({
                type: "POST", url: "ajax/dashboard.php",
                data: {'singleLeadChart': filter},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var ParseResponse = JSON.parse(resPonse);
                        singleLeadChart(ParseResponse);
                        loader(false);
                    } else {
                        loader(false);
                    }
                },
                error: function () {
                    loader(false);
                }
            });
        }
        function singleLeadChart(ParseResponse) {

            Highcharts.chart('singleLeadChartWrapper', {
                chart: {
                    type: 'area',
                    zoomType: 'x',
                    panning: true,
                    panKey: 'shift',
                    scrollablePlotArea: {
                        minWidth: 600
                    }
                },

                title: {
                    text: ParseResponse.Category + ' Leads'
                },

                subtitle: {
                    text: 'Leads From ' + ParseResponse.RangeStart + ' To ' + ParseResponse.RangeEnd
                },

                xAxis: {
                    labels: {
                        format: '{value}'
                    },
                    minRange: 2,
                    title: {
                        text: 'Years'
                    }
                },

                yAxis: {
                    startOnTick: true,
                    endOnTick: false,
                    maxPadding: 0.35,
                    title: {
                        text: 'Number of Leads'
                    },
                    labels: {
                        format: '{value}'
                    }
                },

                tooltip: {
                    headerFormat: 'Year: {point.x}<br>',
                    pointFormat: 'Total: {point.y}',
                    shared: true
                },

                legend: {
                    enabled: false
                },

                series: [{
                    data: ParseResponse.data,
                    lineColor: Highcharts.getOptions().colors[1],
                    color: Highcharts.getOptions().colors[2],
                    fillOpacity: 0.5,
                    name: 'Elevation',
                    marker: {
                        enabled: true
                    },
                    threshold: null
                }]

            });
        }

        function callMonthlyLeadsData() {
            var BG_CurrentYear = document.getElementById('BG_CurrentYear');

            var filter = {
                'CurrentYear': BG_CurrentYear.value,
            };
            getMonthlyLeadsData(filter);
        }
        function getMonthlyLeadsData(filter) {
            loader(true);
            $.ajax({
                type: "POST", url: "ajax/dashboard.php",
                data: {'monthlyLeadsChart': filter},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var ParseResponse = JSON.parse(resPonse);
                        monthlyLeadsChart(ParseResponse);
                        loader(false);
                    } else {
                        loader(false);
                    }
                },
                error: function () {
                    loader(false);
                }
            });
        }
        function monthlyLeadsChart(ParseResponse) {
            Highcharts.chart('monthlyLeadsChartWrapper', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Monthly Leads Chart'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    title: {
                        text: 'Number of Leads'
                    },
                    labels: {
                        formatter: function () {
                            return this.value;
                        }
                    }
                },
                tooltip: {
                    crosshairs: true,
                    shared: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#666666',
                            lineWidth: 1
                        }
                    }
                },
                series: ParseResponse
            });
            Highcharts.chart('monthlyLeadsHistogramChartWrapper', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Monthly Leads Chart'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Number of Leads'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: ParseResponse
            });
        }

    </script>

<?php include_once("../includes/endTags.php"); ?>