<?php
/**
 * Created by PhpStorm.
 * User: NSC
 * Date: 11/13/2018
 * Time: 11:12 PM
 */
reConfirmAdmin();

//get account system
function getAccountID()
{
    return $_SESSION[DP_ACCOUNT]->acc_num;
}

function getRole()
{
    return $_SESSION[DP_ACCOUNT]->tok_level;
}

function getStaff()
{
    return $_SESSION[DP_ACCOUNT]->tok_key;
}

//Get notifications
function getNotification()
{
    $response = '   <a class="nav-link" href="" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">notifications</i>
                        <span class="notification">1</span>
                        <p class="d-lg-none d-md-block">
                            Some Actions
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Welcome, Always check here for new notifications</a>
                    </div>';
    return $response;
}

//read facilities
//just your only table info
function factExist($key)
{
    $db = new Db();
    $sid = getAccountID();
    $rd = $db->query("select * from moe_facilities where fac_identity='$sid' and fac_key='$key'");
    if ($rd->num_rows > 0) {
        return true;
    }
    return false;
}

//just your only table info
function getAny($table, $col)
{
    $db = new Db();
    $sid = getAccountID();
    $rd = $db->query("select * from " . $table . " where " . $col . "='$sid'");
    return $rd;
}

//get student list filtered
//list range of students students
function getListStudentsQuery($range = 2000, $filter = '', $search = false)
{
    $q = '';
    if ($search) {
        $q = "and (std_name='$filter' OR std_p_phone='$filter')";
    }
    $db = new Db();
    $sid = getAccountID();
    $rd = $db->query("select * from moe_students where std_identity='$sid' '$q' order by `std_id` desc limit $range");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <tr>
                <td><?php echo $table_sn; ?></td>
                <td><?php echo $vl->std_name ?></td>
                <td><?php echo $vl->std_gender ?></td>
                <td><?php echo $vl->std_class ?></td>
                <td><?php echo $vl->std_p_name ?></td>
                <td><?php echo $vl->std_p_phone ?></td>
                <!--                <td>--><?php //echo @$_SESSION[DP_ACCOUNT]->abbre  ?><!--</td>-->
                <td><?php echo $vl->std_sign ?></td>
                <td><a rel="modal:open" href="plug.modal.std?id=<?php echo $vl->std_id ?>"><i
                                style="cursor: pointer; padding: 20px; color: red;" title="Edit"
                                class="fa fa-pencil"></i></a></td>
            </tr>
            <?php
        }
    }
}

//list range of students students
function getListProjectQuery($range = 2000, $filter = '', $search = false)
{
    $q = '';
    if ($search) {
        $q = "and (pro_name='$filter' OR pro_phone='$filter')";
    }
    $db = new Db();
    $sid = getAccountID();
    $rd = $db->query("select * from moe_projects where pro_identity='$sid' '$q' order by `pro_id` desc limit $range");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <tr>
                <td><?php echo $table_sn; ?></td>
                <td><?php echo $vl->pro_name ?></td>
                <td><?php echo $vl->pro_by ?></td>
                <td><?php echo $vl->pro_phone ?></td>
                <td><?php echo $vl->pro_cost ?></td>
                <td><?php echo $vl->pro_s_date . " to " . $vl->pro_e_date ?></td>
                <td>
                    <?php
                    $newname = UPLOADS_FLD . "/" . $vl->pro_identity . "_PRO_" . $vl->pro_id . '.jpg';
                    if (file_exists($newname)) {
                        ?>
                        <a href="<?php echo $newname; ?>" target="_blank">
                            <img style="width: 120px; height: 80px; border-radius: 10px; cursor: pointer;"
                                 title="Click to view large" src="<?php echo $newname; ?>">
                        </a>
                        <?php
                    }
                    ?>
                </td>
                <td><?php echo $vl->pro_sign ?></td>
                <td><a rel="modal:open" href="plug.modal.project?id=<?php echo $vl->pro_id ?>"><i
                                style="cursor: pointer; padding: 20px; color: red;" title="Edit"
                                class="fa fa-pencil"></i></a></td>
            </tr>
            <?php
        }
    }
}

//list range of students students
function getListFactQuery($range = 2000, $filter = '', $search = false)
{
    $q = '';
    if ($search) {
        $q = "and (stf_name='$filter' OR stf_p_phone='$filter')";
    }
    $db = new Db();
    $sid = getAccountID();
    $rd = $db->query("select * from moe_facilities where fac_identity='$sid' '$q' order by `fac_id` desc limit $range");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <tr>
                <td><?php echo $table_sn; ?></td>
                <td><?php echo $vl->fac_key ?></td>
                <td><?php echo $vl->fac_value ?></td>
                <td><?php echo $_SESSION[DP_ACCOUNT]->abbre ?></td>
            </tr>
            <?php
        }
    }
}

//list range of students students
function getListStaffQuery($range = 2000, $filter = '', $search = false)
{
    $q = '';
    if ($search) {
        $q = "and (stf_name='$filter' OR stf_p_phone='$filter')";
    }
    $db = new Db();
    $sid = getAccountID();
    $rd = $db->query("select * from moe_staffs where stf_identity='$sid' '$q' order by `stf_id` desc limit $range");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <tr>
                <td><?php echo $table_sn; ?></td>
                <td><?php echo $vl->stf_name ?></td>
                <td><?php echo $vl->stf_gender ?></td>
                <td><?php echo $vl->stf_phone ?></td>
                <td><?php echo $vl->stf_subject ?></td>
                <td><?php echo $vl->stf_class ?></td>
                <!--                <td>--><?php //echo @$_SESSION[DP_ACCOUNT]->abbre  ?><!--</td>-->
                <td><?php echo $vl->stf_sign ?></td>
                <td><a rel="modal:open" href="plug.modal.staff?id=<?php echo $vl->stf_id ?>"><i
                                style="cursor: pointer; padding: 20px; color: red;" title="Edit"
                                class="fa fa-pencil"></i></a></td>
            </tr>
            <?php
        }
    }
}

//list range of staffs
function getListStaff($range)
{
    $db = new Db();
    $sid = getAccountID();
    $rd = $db->query("select * from moe_staffs where stf_identity='$sid' order by `stf_id` desc limit $range");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <tr>
                <td><?php echo $table_sn; ?></td>
                <td><?php echo $vl->stf_name ?></td>
                <td><?php echo $vl->stf_gender ?></td>
                <td><?php echo $vl->stf_phone ?></td>
                <td><?php echo $vl->stf_subject ?></td>
                <td><?php echo $vl->stf_class ?></td>
            </tr>
            <?php
        }
    }
}

//list range of students students
function getListStudents($range)
{
    $db = new Db();
    $sid = getAccountID();
    $rd = $db->query("select * from moe_students where std_identity='$sid' order by `std_id` desc limit $range");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <tr>
                <td><?php echo $table_sn; ?></td>
                <td><?php echo $vl->std_name ?></td>
                <td><?php echo $vl->std_gender ?></td>
                <td><?php echo $vl->std_class ?></td>
                <td><?php echo @$_SESSION[DP_ACCOUNT]->abbre ?></td>
                <td><?php echo $vl->std_sign ?></td>
            </tr>
            <?php
        }
    }
}

//list range of students students
function getListProject($range)
{
    $db = new Db();
    $sid = getAccountID();
    $rd = $db->query("select * from moe_projects where pro_identity='$sid' order by `pro_id` desc limit $range");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <td><?php echo $table_sn; ?></td>
            <td><?php echo $vl->pro_name ?></td>
            <td><?php echo $vl->pro_by ?></td>
            <td><?php echo $vl->pro_cost ?></td>
            <td><?php echo $vl->pro_s_date . " to " . $vl->pro_e_date ?></td>
            <td>
                <?php
                $newname = UPLOADS_FLD . "/" . $vl->pro_identity . "_PRO_" . $vl->pro_id . '.jpg';
                if (file_exists($newname)) {
                    ?>
                    <a href="<?php echo $newname; ?>" target="_blank">
                        <img style="width: 120px; height: 80px; border-radius: 10px; cursor: pointer;"
                             title="Click to view large" src="<?php echo $newname; ?>">
                    </a>
                    <?php
                }
                ?>
            </td>
            </tr>
            <?php
        }
    }
}

//List admin staffs
function getAllAdmins()
{
    $response = '';
    $db = new Db();
    $sid = getAccountID();
    //read from db
    $rd = $db->query("select * from moe_tokens where tok_identity='$sid' limit 5");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <tr>
                <td><?php echo $table_sn; ?></td>
                <td><?php echo $vl->tok_name ?></td>
                <td><?php echo $vl->tok_phone ?></td>
                <td><?php echo ($vl->tok_level == 1) ? 'Global Admin' : 'Admin' ?></td>
                <td>
                    <?php
                    if (getRole() == 1 && $vl->tok_level == 0) {
                        echo '<button onclick="removeAdmin(' . "'" . $vl->tok_phone . "'" . ')" type="button" rel="tooltip" title="Remove Access"
                            class="btn btn-danger btn-link btn-sm">
                        <i class="fa fa-times"></i>
                    </button>';
                    } else {
                        echo '<button type="button" rel="tooltip" title="Cannot Remove Global Admin"
                            class="btn btn-success btn-link btn-sm">
                        <i class="fa fa-check"></i>
                    </button>';
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
    }
}


//////////////////////////////////////ADMINISTRATOR FUNCTIONS HERE///////////////////////////////////////
/// //list range of students students
function getListSchoolQuery($range)
{
    $db = new Db();
    $rd = $db->query("select * from accounts INNER JOIN moe_tokens on accounts.acc_num=moe_tokens.tok_identity WHERE moe_tokens.tok_level=1 order by `id` desc limit $range");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <td><?php echo $table_sn; ?></td>
            <td><?php echo $vl->name ?></td>
            <td><?php echo $vl->acc_num ?></td>
            <td><?php echo $vl->phone ?></td>
            <td><?php echo $vl->email ?></td>
            <td><?php echo $vl->state ?></td>
            <td><?php echo (($vl->status) == 1) ? 'Active' : 'Need Review'; ?></td>
            <td><?php echo $vl->tok_name ?></td>
            <td><?php echo $vl->tok_key ?></td>
            <td><?php echo time_elapsed_string($vl->lastseen); ?></td>
            <td>
                <a rel="modal:open" class="btn btn-danger"
                   href="plug.adm.view.school?acc=<?php echo $vl->acc_num; ?>"><i class="fa fa-pencil"></i> View</a>
            </td>
            </tr>
            <?php
        }
    }
}

//Get list of schools for active and disable
function getListSchoolQueryToken($range)
{
    $db = new Db();
    $rd = $db->query("select * from accounts INNER JOIN moe_tokens on accounts.acc_num=moe_tokens.tok_identity WHERE moe_tokens.tok_level=1 order by `id` desc limit $range");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <td><?php echo $table_sn; ?></td>
            <td><?php echo $vl->name ?></td>
            <td><?php echo $vl->acc_num ?></td>
            <td><?php echo (($vl->status) == 1) ? 'Active' : 'Need Review'; ?></td>
            <td>
                <a onclick="activateD('<?php echo $vl->email; ?>','<?php echo $vl->acc_num; ?>','<?php echo $vl->status; ?>')"
                   class="btn btn-danger" href="javascript:void();"><i class="fa fa-pencil"></i> Enable / Disable</a>
            </td>
            </tr>
            <?php
        }
    }
}

/**Get list of used code
 * @param $range
 */
function getListAccessCodes($range)
{
    $db = new Db();
    $rd = $db->query("select * from accounts INNER JOIN moe_access on accounts.acc_num=moe_access.acc_code order by `id` desc limit $range");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <td><?php echo $table_sn; ?></td>
            <td><?php echo $vl->acc_code ?></td>
            <td><?php echo ($vl->acc_used == 1) ? 'Used' : 'Valid'; ?></td>
            <td><?php echo $vl->name ?></td>
            <td>
                <a onclick="window.open('request.login?acc=<?php echo $vl->acc_code ?>&key=<?php echo $vl->pass ?>', '_blank', 'location=yes,height=800,width=1800,scrollbars=yes,status=yes');" class="btn btn-danger" href="javascript:void();"><i class="fa fa-pencil"></i> Login To School Portal</a>
            </td>
            </tr>
            <?php
        }
    }
}

function getListAccessCodesNew($range)
{
    $db = new Db();
    $rd = $db->query("select * from moe_access where acc_used=0 order by `acc_id` desc limit $range");
    if ($rd->num_rows > 0) {
        $table_sn = 0;
        foreach ($rd as $key => $value) {
            $vl = (object)$value;
            $table_sn++;
            ?>
            <td><?php echo $table_sn; ?></td>
            <td><?php echo $vl->acc_code ?></td>
            <td><?php echo ($vl->acc_used == 1) ? 'Invalid' : 'Valid'; ?></td>
            </tr>
            <?php
        }
    }
}