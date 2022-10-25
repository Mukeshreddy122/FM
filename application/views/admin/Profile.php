<?php //print_r($_SESSION); 
$userAccess = "";
if ($_SESSION['administrator'] == 1 && $_SESSION['userLimit'] == 0) {
    $userAccess = "Administrator";
} else if ($_SESSION['administrator'] == 1 && $_SESSION['userLimit'] > 0) {
    $userAccess = "Manager";
} else if ($_SESSION['administrator'] == 0 && $_SESSION['userLimit'] == 0) {
    $userAccess = "User";
} else if ($_SESSION['administrator'] == 0 && $_SESSION['readonly'] == true) {
    $userAccess = "ReadOnly";
}
?>
<div class="card">
    <form class="form" role="form" method="post" action="<?php echo base_url() ?>Profile/updateProfile">
        <div class="card-header">
            <h5>Edit <?php echo $title; ?></h5>
        </div>
        <div class="card-body">
            <div class="row form-group">
                <div class="hidden-fields">
                    <input type="hidden" id="employeeId" name="employeeId" />
                </div>
                <div class="col-sm-3">
                    <input type="hidden" id="employeeId" name="employeeId" value="<?php echo (array_key_exists('uId', $_SESSION)) ? $_SESSION['uId'] : ""; ?>" />
                    <label class="form-control-label"><?php $this->lang->line('Name'); ?></label>
                    <input type="text" placeholder="employee Name" id="employeeName" name="employeeName" readonly class="form-control" value="<?php echo (array_key_exists('name', $_SESSION)) ? $_SESSION['name'] : ""; ?>" />
                </div>
                <div class="col-sm-3">
                    <label class="form-control-label"><?php $this->lang->line('MailAddress'); ?></label>
                    <input type="text" placeholder="Mail Address" id="mailAddress" name="mailAddress" class="form-control" value="<?php echo (array_key_exists('Mail Address', $_SESSION)) ? $_SESSION['Mail Address'] : ""; ?>" />
                </div>
                <div class="col-sm-3">
                    <label class="form-control-label"><?php $this->lang->line('MailAddress'); ?></label>
                    <input type="text" placeholder="Phone Number" id="phoneNumber" name="phoneNumber" class="form-control" value="<?php echo (array_key_exists('Phone Number', $_SESSION)) ? $_SESSION['Phone Number'] : ""; ?>" />
                </div>
                <div class="col-sm-3 invisible-section">
                    <label class="form-control-label"><?php $this->lang->line('MailAddress'); ?></label>
                    <input type="text" placeholder="Email" id="emailId" name="emailId" required class="form-control" value="<?php echo $_SESSION['email']; ?>" />
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-3">
                    <label class="form-control-label"><?php $this->lang->line('MailAddress'); ?></label>
                    <input type="text" placeholder="Company Role" id="companyRole" name="companyRole" class="form-control" readonly value="<?php echo (array_key_exists('Company Role', $_SESSION)) ? $_SESSION['Company Role'] : ""; ?>" />
                </div>
                <div class="col-sm-3">
                    <label class="form-control-label"><?php $this->lang->line('MailAddress'); ?></label>
                    <input type="text" placeholder="External Company" id="externalCompany" name="externalCompany" class="form-control" readonly value="<?php echo (array_key_exists('External Company', $_SESSION)) ? $_SESSION['External Company'] : ""; ?>" />
                </div>
                <div class="col-sm-3">
                    <label class="form-control-label"><?php $this->lang->line('MailAddress'); ?></label>
                    <input type="text" placeholder="projectConnection" id="projectConnection" name="projectConnection" class="form-control" readonly value="<?php echo (array_key_exists('Project Connection', $_SESSION)) ? $_SESSION['Project Connection'] : ""; ?>" />
                </div>
                <!--    <div class="col-sm-3">
                    <label class="form-control-label">Access</label>
                    <div class="form-select">
                        <select id="access" name="access" class="custom-select" disabled>
                            &lt;?php foreach ($userTypes as $key => $userType)
                                if ($userType == $userAccess) {
                                    echo "<option value='{$userType}' selected>{$userType}</option>";
                                } else {
                                    echo "<option value='{$userType}'>{$userType}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div> -->
            </div>
            <div class="row form-group">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-3">
                </div>
                <div class="col-sm-3">
                </div>
                <div class="col-sm-3">
                    <label class="form-control-label"></label>
                    <button type="submit" class="btn btn-info">Update</button>
                </div>
            </div>
        </div>
</div>
</form>
</div>