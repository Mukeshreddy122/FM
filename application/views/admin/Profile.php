<?php //print_r($_SESSION); 
$userAccess = "";
// if ($_SESSION['administrator'] == 1 && $_SESSION['userLimit'] == 0) {
//     $userAccess = "Administrator";
// } else if ($_SESSION['administrator'] == 1 && $_SESSION['userLimit'] > 0) {
//     $userAccess = "Manager";
// } else if ($_SESSION['administrator'] == 0 && $_SESSION['userLimit'] == 0) {
//     $userAccess = "User";
// } else if ($_SESSION['administrator'] == 0 && $_SESSION['readonly'] == true) {
//     $userAccess = "ReadOnly";
// }
?>
<div class="card">

    <div class="card-header">
        <input type="hidden" id="session_token" value="<?php echo $_SESSION['USER_API_TOKEN'] ?>" />
        <h5>Edit <?php echo $title; ?></h5>
    </div>
    <div class="card-body">
        <div class="row form-group">
            <div class="hidden-fields">
                <input type="hidden" id="employeeId" name="employeeId" value="<?php echo $_SESSION['uId'] ?>" />
            </div>
            <div class="col-sm-3">
                <input type="hidden" id="employeeId" name="employeeId" value="<?php echo (array_key_exists('uId', $_SESSION)) ? $_SESSION['uId'] : ""; ?>" />
                <label class="form-control-label"><?php echo $this->lang->line('Name'); ?></label>
                <input type="text" placeholder="employee Name" id="employeeName" name="employeeName" readonly class="form-control" value="<?php echo (array_key_exists('name', $_SESSION)) ? $_SESSION['name'] : ""; ?>" />
            </div>
            <div class="col-sm-3">
                <label class="form-control-label"><?php echo $this->lang->line('MailAddress'); ?></label>
                <input type="text" placeholder="Mail Address" id="mailAddress" name="mailAddress" readonly class="form-control" value="<?php echo (array_key_exists('Mail Address', $_SESSION)) ? $_SESSION['Mail Address'] : ""; ?>" />
            </div>
            <div class="col-sm-3">
                <label class="form-control-label"><?php echo $this->lang->line('Phone'); ?></label>
                <input type="text" placeholder="Phone Number" id="phoneNumber" name="phoneNumber" readonly class="form-control" value="<?php echo (array_key_exists('Phone Number', $_SESSION)) ? $_SESSION['Phone Number'] : ""; ?>" />
            </div>
            <div class="col-sm-3 invisible-section">
                <label class="form-control-label"><?php echo $this->lang->line('Email'); ?></label>
                <input type="text" placeholder="Email" id="emailId" name="emailId" readonly class="form-control" value="<?php echo $_SESSION['email']; ?>" />
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-3">
                <label class="form-control-label"><?php echo $this->lang->line('Company Role'); ?></label>
                <input type="text" placeholder="Company Role" id="companyRole" readonly name="companyRole" class="form-control" readonly value="<?php echo (array_key_exists('Company Role', $_SESSION)) ? $_SESSION['Company Role'] : ""; ?>" />
            </div>
            <div class="col-sm-3">
                <label class="form-control-label"><?php echo $this->lang->line('External Comapany'); ?></label>
                <input type="text" placeholder="External Company" id="externalCompany" readonly name="externalCompany" class="form-control" readonly value="<?php echo (array_key_exists('External Company', $_SESSION)) ? $_SESSION['External Company'] : ""; ?>" />
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
            </div>

            <div class="col-sm-2">
                <input type="submit" id="resetPassword" name="resetPassword" class="form-control bg-info text-light
                    " readonly value="Reset Password" onclick="resetPassword()" />
            </div>
        </div>
    </div>

</div>
<!-- reset password -->
<div class="card col-12" id="changePassword" style="display: none;">
    <div class="card-header">
        <h5> <?php echo $this->lang->line('ChangePassword'); ?></h5>
    </div>
    <div class="card-body">
        <div class="row form-group">
            <!-- <div class="hidden-fields">
                            <input type="hidden" id="employeeId" name="employeeId" />
                        </div> -->
            <div class="col-sm-3">
            </div>
            <div class="col-sm-3">
                <label class="form-control-label"><?php echo $this->lang->line('CurrentPassword'); ?></label>
                <input type="text" placeholder="Current Password" id="currentPassword" name="currentPassword" class="form-control" />
            </div>
        </div>

        <div class="row form-group">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-3 ">
                <label class="form-control-label"><?php echo $this->lang->line('NewPassword'); ?></label>
                <input type="password" placeholder="New Password" id="newPassword" name="newPassword" class="form-control" />
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-3">
                <label class="form-control-label"><?php echo $this->lang->line('ConfirmPassword'); ?></label>
                <input type="text" placeholder="Confirm Password" id="confirmPassword" name="confirmPassword" class="form-control" />
            </div>
        </div>


    </div>
    <div class="row form-group">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-3">
            <input type="submit" placeholder="changePassword" id="changePassword" name="changePassword" class="form-control bg-info text-light
                    " readonly value="Change Password" onclick="changePassword()" />
        </div>
    </div>
</div>
<script>
    function resetPassword() {
        $("#changePassword").show()
    }

    function changePassword() {
        var newPassword = $("#newPassword").val()
        console.log(newPassword)
        var confirmPassword = $("#confirmPassword").val()
        console.log(confirmPassword)
        var empId = $("#employeeId").val()
        console.log(empId)
        var email = $("#emailId").val()
        console.log(email)
        if (newPassword === confirmPassword) {
            var profile = {
                "empId": $("#employeeId").val(),
                "email": $("#emailId").val(),
                "password": md5($("#currentPassword").val()),
                "new_password": md5($("#newPassword").val())
            }
            var res = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/changepassword", "POST", JSON.stringify(profile), document.getElementById("session_token").value)
            console.log(res.status)
            if (res.status == 'success') {
                toastr.success("Password Updated!")
            }
            else{
                toastr.success("Password Not updated!")

            }


        } else {
            toastr.error("Password didnt Match!")


        }
    }
</script>
<script src="assets/js/md5.js"></script>
<script src="assets/js/md5.min.js"></script>
<!-- <script src="assets/js/md5.min.js.map"></script> -->
<script src="assets/js/uiajax.js"></script>