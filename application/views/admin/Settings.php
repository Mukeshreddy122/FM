<section class="content">
    <?php
    // $languageList = explode(',', $_SESSION['systemLanguageOptions'][0]);
    // print_r(explode(',', $_SESSION['systemLanguageOptions'][0])[1]);
    // die;
    if ($_SESSION['permission'] != "ADMIN") {
        redirect(base_url() . 'PM');
    }


    // print_r($SettingsInfo['systemLanguageOptions']);
    // die;
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card card-info card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs active-aqua" id="tabSettingsParent" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" aria-selected="true" id="generalSettings-tab" data-toggle="pill" href="#generalSettings" role="tab" aria-controls="generalSettings"><?php echo $this->lang->line('General Settings'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-selected="true" id="customerSettings-tab" data-toggle="pill" href="#customerSettings" role="tab" aria-controls="customerSettings"><?php echo $this->lang->line('Customer Settings'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-selected="true" class="nav-link " aria-selected="false" id="UserSettings-tab" data-toggle="pill" href="#UserSettings" role="tab" aria-controls="UserSettings"><?php echo $this->lang->line('Employee Settings'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-selected="true" id="fleetSettings-tab" data-toggle="pill" href="#fleetSettings" role="tab" aria-controls="fleetSettings"><?php echo $this->lang->line('Fleet Settings'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-selected="true" id="projectSettings-tab" data-toggle="pill" href="#projectSettings" role="tab" aria-controls="projectSettings"><?php echo $this->lang->line('Project Settings'); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-content-below-tabContent">
                        <div class="tab-pane fade show active" id="customerSettings" role="tabpanel" aria-labelledby="customerSettings-tab">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-info">
                                                <input type="checkbox" checked disabled class="custom-control-input" id="customerNameSwitch">
                                                <label class="custom-control-label" for="customerNameSwitch"><?php echo $this->lang->line('Customer Name'); ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-info">

                                                <?php if ($_SESSION['customerTypeOfCompany'] == 1) {
                                                    echo '<input type="checkbox" checked class="custom-control-input" id="customerTypeOfCompanySwitch">';
                                                    echo '<label class="custom-control-label" for="customerTypeOfCompanySwitch">Type of Company</label>';
                                                } else {
                                                    echo '<input type="checkbox" class="custom-control-input" id="customerTypeOfCompanySwitch">';
                                                    echo '<label class="custom-control-label" for="customerTypeOfCompanySwitch">Type of Company</label>';
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-info">
                                                <?php if ($_SESSION['customerIndustry'] == 1) {
                                                    echo '';
                                                    echo '';
                                                } else {
                                                    echo '';
                                                    echo '';
                                                } ?>
                                                <input type="checkbox" checked class="custom-control-input" id="customerIndustrySwitch">
                                                <label class="custom-control-label" for="customerIndustrySwitch"><?php echo $this->lang->line('Industry'); ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-info">
                                                <?php if ($_SESSION['customerNumOfEmployees'] == 1) {
                                                    echo '';
                                                    echo '';
                                                } else {
                                                    echo '';
                                                    echo '';
                                                } ?>
                                                <input type="checkbox" checked class="custom-control-input" id="customerNoOfEmployeesSwitch">
                                                <label class="custom-control-label" for="customerNoOfEmployeesSwitch"><?php echo $this->lang->line('No. Of Employees'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php
                                            if ($_SESSION['customerVATNumber'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="customerVATNumberSwitch">';
                                                echo '<label class="custom-control-label" for="customerVATNumberSwitch">VAT Number</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="customerVATNumberSwitch">';
                                                echo '<label class="custom-control-label" for="customerVATNumberSwitch">VAT Number</label>';
                                            } ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-info">
                                                <?php if ($_SESSION['customerVisitAddress'] == 1) {
                                                    echo '';
                                                    echo '';
                                                } else {
                                                    echo '';
                                                    echo '';
                                                } ?>
                                                <input type="checkbox" checked class="custom-control-input" id="customerVisitAddressSwitch">
                                                <label class="custom-control-label" for="customerVisitAddressSwitch"><?php echo $this->lang->line('Visit Address'); ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-info">
                                                <?php if ($_SESSION['customerPostAddress'] == 1) {
                                                    echo '';
                                                    echo '';
                                                } else {
                                                    echo '';
                                                    echo '';
                                                } ?>
                                                <input type="checkbox" checked class="custom-control-input" id="customerPostAddressSwitch">
                                                <label class="custom-control-label" for="customerPostAddressSwitch"><?php echo $this->lang->line('Post Address'); ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-switch-on-info">
                                                <?php if ($_SESSION['customerSisterCompanies'] == 1) {
                                                    echo '';
                                                    echo '';
                                                } else {
                                                    echo '';
                                                    echo '';
                                                } ?>
                                                <input type="checkbox" checked class="custom-control-input" id="customerSisterCompaniesSwitch">
                                                <label class="custom-control-label" for="customerSisterCompaniesSwitch"><?php echo $this->lang->line('Sister Comapnies'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="UserSettings" role="tabpanel" aria-labelledby="UserSettings-tab">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <input type="checkbox" checked disabled class="custom-control-input" id="userNameSwitch">
                                            <label class="custom-control-label" for="userNameSwitch"><?php echo $this->lang->line('Employee Name'); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['employeeMailAddress'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked class="custom-control-input" id="userMailingAddressSwitch">
                                            <label class="custom-control-label" for="userMailingAddressSwitch"><?php echo $this->lang->line('Mailing Address'); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['employeePhoneNumber'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked class="custom-control-input" id="userPhoneNumberSwitch">
                                            <label class="custom-control-label" for="userPhoneNumberSwitch"><?php echo $this->lang->line('Phone'); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['employeeCompanyRole'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked class="custom-control-input" id="userCompanyRoleSwitch">
                                            <label class="custom-control-label" for="userCompanyRoleSwitch"><?php echo $this->lang->line('Company Role'); ?></label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['employeeExternalCompany'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked class="custom-control-input" id="userExternalCompanySwitch">
                                            <label class="custom-control-label" for="userExternalCompanySwitch"><?php echo $this->lang->line('External Company'); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['employeeExternalCompany'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked disabled class="custom-control-input" id="userEmailAddressSwitch">
                                            <label class="custom-control-label" for="userEmailAddressSwitch"><?php echo $this->lang->line('Email'); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['employeeExternalCompany'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked disabled class="custom-control-input" id="userPostAddressSwitch">
                                            <label class="custom-control-label" for="userPostAddressSwitch"><?php echo $this->lang->line('Password'); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['customerName'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked class="custom-control-input" id="userSisterCompaniesSwitch">
                                            <label class="custom-control-label" for="userSisterCompaniesSwitch"><?php echo $this->lang->line('Projects List'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="fleetSettings" role="tabpanel" aria-labelledby="fleetSettings-tab">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <input type="checkbox" checked disabled class="custom-control-input" id="fleetNameSwitch">
                                            <label class="custom-control-label" for="fleetNameSwitch"><?php echo $this->lang->line('Fleet Name'); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['deviceWebsite'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="deviceWebsiteSwitch">';
                                                echo '<label class="custom-control-label" for="deviceWebsiteSwitch">Fleet Website</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="deviceWebsiteSwitch">';
                                                echo '<label class="custom-control-label" for="deviceWebsiteSwitch">Fleet Website</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['deviceSerialNumber'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="deviceSerialNumberSwitch">';
                                                echo '<label class="custom-control-label" for="deviceSerialNumberSwitch">Serial Number</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="deviceSerialNumberSwitch">';
                                                echo '<label class="custom-control-label" for="deviceSerialNumberSwitch">Serial Number</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['deviceSenderNumber'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="deviceSenderNumberSwitch">';
                                                echo '<label class="custom-control-label" for="deviceSenderNumberSwitch">Sender Number</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="deviceSenderNumberSwitch">';
                                                echo '<label class="custom-control-label" for="deviceSenderNumberSwitch">Sender Number</label>';
                                            } ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['deviceCategory'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="deviceCategorySwitch">';
                                                echo '<label class="custom-control-label" for="deviceCategorySwitch">Category</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="deviceCategorySwitch">';
                                                echo '<label class="custom-control-label" for="deviceCategorySwitch">Category</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['deviceCategory'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="deviceFabricationSwitch">';
                                                echo '<label class="custom-control-label" for="deviceFabricationSwitch">Fabrication</label>';
                                            } else {
                                                echo '<input type="checkbox"  class="custom-control-input" id="deviceFabricationSwitch">';
                                                echo '<label class="custom-control-label" for="deviceFabricationSwitch">Fabrication</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['deviceCategory'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="deviceContainerNameSwitch">';
                                                echo ' <label class="custom-control-label" for="deviceContainerNameSwitch">Container</label>';
                                            } else {
                                                echo '<input type="checkbox"  class="custom-control-input" id="deviceContainerNameSwitch">';
                                                echo ' <label class="custom-control-label" for="deviceContainerNameSwitch">Container</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['deviceServiceLog'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="deviceServiceLogSwitch">';
                                                echo ' <label class="custom-control-label" for="deviceServiceLogSwitch">Service Log</label>';
                                            } else {
                                                echo '<input type="checkbox"  class="custom-control-input" id="deviceServiceLogSwitch">';
                                                echo ' <label class="custom-control-label" for="deviceServiceLogSwitch">Service Log</label>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['deviceServiceLog'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="deviceNotesSwitch">';
                                                echo '<label class="custom-control-label" for="deviceNotesSwitch">Notes</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="deviceNotesSwitch">';
                                                echo '<label class="custom-control-label" for="deviceNotesSwitch">Notes</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['deviceServiceLog'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="devicePictureSwitch">';
                                                echo '<label class="custom-control-label" for="devicePictureSwitch">Picture</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="devicePictureSwitch">';
                                                echo '<label class="custom-control-label" for="devicePictureSwitch">Picture</label>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Project data -->
                        <div class="tab-pane fade" id="projectSettings" role="tabpanel" aria-labelledby="projectSettings-tab">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <input type="checkbox" checked disabled class="custom-control-input" id="projectNameSwitch">
                                            <label class="custom-control-label" for="projectNameSwitch"><?php echo $this->lang->line('Project Name'); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['projectCustomerName'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="projectCustomerNameSwitch">';
                                                echo '<label class="custom-control-label" for="projectCustomerNameSwitch">Customer Name</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="projectCustomerNameSwitch">';
                                                echo '<label class="custom-control-label" for="projectCustomerNameSwitch">Customer Name</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['projectCost'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="projectCostSwitch">';
                                                echo '<label class="custom-control-label" for="projectCostSwitch">Serial Number</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="projectCostSwitch">';
                                                echo '<label class="custom-control-label" for="projectCostSwitch">Project Cost</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['projectIncome'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="projectIncomeSwitch">';
                                                echo '<label class="custom-control-label" for="projectIncomeSwitch">Project Incomer</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="projectIncomeSwitch">';
                                                echo '<label class="custom-control-label" for="projectIncomeSwitch">Project Income</label>';
                                            } ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['projectStartTime'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="projectStartTimeSwitch">';
                                                echo '<label class="custom-control-label" for="projectStartTimeSwitch">Start-Time</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="projectStartTimeSwitch">';
                                                echo '<label class="custom-control-label" for="projectStartTimeSwitch">Start-Time</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['projectEndTime'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="projectEndTimeSwitch">';
                                                echo '<label class="custom-control-label" for="projectEndTimeSwitch">Fabrication</label>';
                                            } else {
                                                echo '<input type="checkbox"  class="custom-control-input" id="projectEndTimeSwitch">';
                                                echo '<label class="custom-control-label" for="projectEndTimeSwitch">End-Time</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['projectDeviceCount'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="projectDeviceCountSwitch">';
                                                echo ' <label class="custom-control-label" for="projectDeviceCountSwitch">Device Count</label>';
                                            } else {
                                                echo '<input type="checkbox"  class="custom-control-input" id="projectDeviceCountSwitch">';
                                                echo ' <label class="custom-control-label" for="projectDeviceCountSwitch">Device Count</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['projectFleet'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="projectFleetSwitch">';
                                                echo ' <label class="custom-control-label" for="projectFleetSwitch">Project Fleet</label>';
                                            } else {
                                                echo '<input type="checkbox"  class="custom-control-input" id="projectFleetSwitch">';
                                                echo ' <label class="custom-control-label" for="projectFleetSwitch">Project Fleet</label>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['projectManpower'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="projectManpowerSwitch">';
                                                echo '<label class="custom-control-label" for="projectManpowerSwitch">Man Power</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="projectManpowerSwitch">';
                                                echo '<label class="custom-control-label" for="projectManpowerSwitch">Man Power</label>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['projectProfit'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="projectProfitSwitch">';
                                                echo '<label class="custom-control-label" for="projectProfitSwitch">Profit</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="projectProfitSwitch">';
                                                echo '<label class="custom-control-label" for="projectProfitSwitch">Profit</label>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="generalSettings" role="tabpanel" aria-labelledby="generalSettings-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <b>
                                        <p><?php echo $this->lang->line('language'); ?></p>
                                    </b>
                                    <?php
                                    $selectedLanguage = $_SESSION['systemLanguage'];
                                    $languageList = [];
                                    $languageList = explode(',', $_SESSION['systemLanguageOptions'][0]);
                                    // print_r(sizeof($languageList));
                                    // die;
                                    ?>
                                    <select id="language" class="form-control select2">
                                        <?php
                                        $lang_select = "";
                                        // $lang_select = "<option value='{$languageList[0]}'>{$languageList[0]}</option>";
                                        foreach ($languageList as $lang) {
                                            if ($lang == $selectedLanguage) {
                                                $lang_select = $lang_select . "<option value='" . $lang . "' selected='selected'>" . $lang . "</option>";
                                            } else {
                                                $lang_select = $lang_select .  "<option value='" . $lang . "' >" . $lang . "</option>";
                                            }
                                        }
                                        // echo "console.log('VK ' .$lang_select);";

                                        echo "'$lang_select'";
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <b>
                                        <p><?php echo $this->lang->line('Currrency on Cost'); ?></p>
                                    </b>
                                    <select class="form-control select2" id="currencyOnCost">
                                        <?php
                                        $currencyCostList = explode(",", $_SESSION['currencyForCostOptions'][0]);
                                        // print_r($currencyCostList);
                                        $currencyCostSelected = $_SESSION['currencyForCost'];


                                        foreach ($currencyCostList as $currencyCost) {
                                            if ($currencyCost == $currencyCostSelected) {
                                                switch ($currencyCost) {
                                                    case "Dollar":
                                                        echo '<option selected value="Dollar">  ' . $currencyCost . '</option>';
                                                        break;
                                                    case "Pound":
                                                        echo '<option selected value="Pound">  ' . $currencyCost . '</option>';
                                                        break;
                                                    case "Euro":
                                                        echo '<option selected value="Euro">  ' . $currencyCost . '</option>';
                                                        break;
                                                }
                                            } else {
                                                switch ($currencyCost) {
                                                    case "Dollar":
                                                        echo '<option value="Dollar">  ' . $currencyCost . '</option>';
                                                        break;
                                                    case "Pound":
                                                        echo '<option value="Pound">  ' . $currencyCost . '</option>';
                                                        break;
                                                    case "Euro":
                                                        echo '<option value="Euro">  ' . $currencyCost . '</option>';
                                                        break;
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <b>
                                        <p><?php echo $this->lang->line('Currency on Salary'); ?></p>
                                    </b>
                                    <select class="custom-select form-control-border" id="currencyOnCost">
                                        <?php
                                        $currencySalaryList = explode(",", $_SESSION['currencyForSalaryOptions'][0]);
                                        $currencySalarySelected = $_SESSION['currencyForSalary'];
                                        // print_r($currencySalaryList);
                                        foreach ($currencySalaryList as $currencySalary) {
                                            if ($currencySalary == $currencySalarySelected) {
                                                switch ($currencySalary) {
                                                    case "Dollar":
                                                        echo '<option selected>  ' . $currencySalary . '</option>';
                                                        break;
                                                    case "Pound":
                                                        echo '<option selected>  ' . $currencySalary . '</option>';
                                                        break;
                                                    case "Euro":
                                                        echo '<option selected>  ' . $currencySalary . '</option>';
                                                        break;
                                                }
                                            } else {
                                                switch ($currencySalary) {
                                                    case "Dollar":
                                                        echo '<option >  ' . $currencySalary . '</option>';
                                                        break;
                                                    case " Pound":
                                                        echo '<option >  ' . $currencySalary . '</option>';
                                                        break;
                                                    case "Euro":
                                                        echo '<option > ' . $currencySalary    . '</option>';
                                                        break;
                                                }
                                            }
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">&nbsp;</div>
                            <div class="col-sm-4">&nbsp;</div>
                            <div class="col-sm-4">&nbsp;</div>
                            <div class="col-sm-4">
                                <button type="button" class="btn bg-info" onclick="Save()"><?php echo $this->lang->line('Save'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>

<script>
    $(function() {
        $('#language').select2();
        $('#currencyOnCost').select2();
    });
    // save 
    function Save() {

        // customer type
        var customerTypeOfCompanySwitch = document.getElementById("customerTypeOfCompanySwitch")
        if (customerTypeOfCompanySwitch.checked) {
            customerTypeOfCompanySwitch.value = true
        } else {
            
            customerTypeOfCompanySwitch.value = false
        }

        // sister companies
        var customerSisterCompaniesSwitch = document.getElementById("customerSisterCompaniesSwitch")
        if (customerSisterCompaniesSwitch.checked) {
            customerSisterCompaniesSwitch.value = true
        } else {
            customerSisterCompaniesSwitch.checked = false
            customerSisterCompaniesSwitch.value = false
        }
        // industry
        var customerIndustrySwitch = document.getElementById("customerIndustrySwitch")
        if (customerIndustrySwitch.checked) {
            customerIndustrySwitch.value = true
        } else {
            customerIndustrySwitch.checked = false
            customerIndustrySwitch.value = false
        }
        // no of employees
        var customerNoOfEmployeesSwitch = document.getElementById("customerNoOfEmployeesSwitch")
        if (customerNoOfEmployeesSwitch.checked) {
            customerNoOfEmployeesSwitch.value = true
        } else {
            customerNoOfEmployeesSwitch.checked = false
            customerNoOfEmployeesSwitch.value = false
        }
        // VAT Number
        var customerVATNumberSwitch = document.getElementById("customerVATNumberSwitch")
        if (customerVATNumberSwitch.checked) {
            customerVATNumberSwitch.value = true
        } else {
            customerVATNumberSwitch.checked = false
            customerVATNumberSwitch.value = false
        }
        // Visit Address
        var customerVisitAddressSwitch = document.getElementById("customerVisitAddressSwitch")
        if (customerVisitAddressSwitch.checked) {
            customerVisitAddressSwitch.value = true
        } else {
            customerVisitAddressSwitch.checked = false
            customerVisitAddressSwitch.value = false
        }
        // Post Address
        var customerPostAddressSwitch = document.getElementById("customerPostAddressSwitch")
        if (customerPostAddressSwitch.checked) {
            customerPostAddressSwitch.value = true
        } else {
            customerPostAddressSwitch.checked = false
            customerPostAddressSwitch.value = false
        }
        // emp name
        var userNameSwitch = document.getElementById("userNameSwitch")
        if (userNameSwitch.checked) {
            userNameSwitch.value = true
        } else {
            userNameSwitch.checked = false
            userNameSwitch.value = false
        }
        // mailing address
        var userEmailAddressSwitch = document.getElementById("userEmailAddressSwitch")
        if (userEmailAddressSwitch.checked) {
            userEmailAddressSwitch.value = true
        } else {
            userEmailAddressSwitch.checked = false
            userEmailAddressSwitch.value = false
        }
        // phone
        var userPhoneNumberSwitch = document.getElementById("userPhoneNumberSwitch")
        if (userPhoneNumberSwitch.checked) {
            userPhoneNumberSwitch.value = true
        } else {
            userPhoneNumberSwitch.checked = false
            userPhoneNumberSwitch.value = false
        }
        // external company
        var userExternalCompanySwitch = document.getElementById("userExternalCompanySwitch")
        if (userExternalCompanySwitch.checked) {
            userExternalCompanySwitch.value = true
        } else {
            userExternalCompanySwitch.checked = false
            userExternalCompanySwitch.value = false
        }
        // email 
        var userEmailAddressSwitch = document.getElementById("userEmailAddressSwitch")
        if (userEmailAddressSwitch.checked) {
            userEmailAddressSwitch.value = true
        } else {
            userEmailAddressSwitch.checked = false
            userEmailAddressSwitch.value = false
        }
        // fleet name
        var fleetNameSwitch = document.getElementById("fleetNameSwitch")
        if (fleetNameSwitch.checked) {
            fleetNameSwitch.value = true
        } else {
            fleetNameSwitch.checked = false
            fleetNameSwitch.value = false
        }
        // fleet website 
        var deviceWebsiteSwitch = document.getElementById("deviceWebsiteSwitch")
        if (deviceWebsiteSwitch.checked) {
            deviceWebsiteSwitch.value = true
        } else {
            deviceWebsiteSwitch.checked = false
            deviceWebsiteSwitch.value = false
        }
        // serial number
        var deviceSerialNumberSwitch = document.getElementById("deviceSerialNumberSwitch")
        if (deviceSerialNumberSwitch.checked) {
            deviceSerialNumberSwitch.value = true
        } else {
            deviceSerialNumberSwitch.checked = false
            deviceSerialNumberSwitch.value = false
        }
        // sender number 
        var deviceSenderNumberSwitch = document.getElementById("deviceSenderNumberSwitch")
        if (deviceSenderNumberSwitch.checked) {
            deviceSenderNumberSwitch.value = true
        } else {
            deviceSenderNumberSwitch.checked = false
            deviceSenderNumberSwitch.value = false
        }
        // container
        var deviceContainerNameSwitch = document.getElementById("deviceContainerNameSwitch")
        if (deviceContainerNameSwitch.checked) {
            deviceContainerNameSwitch.value = true
        } else {
            deviceContainerNameSwitch.checked = false
            deviceContainerNameSwitch.value = false
        }
        // fabrication
        var deviceFabricationSwitch = document.getElementById("deviceFabricationSwitch")
        if (deviceFabricationSwitch.checked) {
            deviceFabricationSwitch.value = true
        } else {
            deviceFabricationSwitch.checked = false
            deviceFabricationSwitch.value = false
        }
        // service log
        var deviceServiceLogSwitch = document.getElementById("deviceServiceLogSwitch")
        if (deviceServiceLogSwitch.checked) {
            deviceServiceLogSwitch.value = true
        } else {
            deviceServiceLogSwitch.checked = false
            deviceServiceLogSwitch.value = false
        }
        // notes
        var deviceNotesSwitch = document.getElementById("deviceNotesSwitch")
        if (deviceNotesSwitch.checked) {
            deviceNotesSwitch.value = true
        } else {
            deviceNotesSwitch.checked = false
            deviceNotesSwitch.value = false
        }
        // company role 
        var userCompanyRoleSwitch = document.getElementById("userCompanyRoleSwitch")
        if (userCompanyRoleSwitch.checked) {
            userCompanyRoleSwitch.value = true
        } else {
            userCompanyRoleSwitch.checked = false
            userCompanyRoleSwitch.value = false
        }
        // external company
        var userExternalCompanySwitch = document.getElementById("userExternalCompanySwitch")
        if (userExternalCompanySwitch.checked) {
            userExternalCompanySwitch.value = true
        } else {
            userExternalCompanySwitch.checked = false
            userExternalCompanySwitch.value = false
        }
        // device category 
        var deviceCategorySwitch = document.getElementById("deviceCategorySwitch")
        if (deviceCategorySwitch.checked) {
            deviceCategorySwitch.value = true
        } else {
            deviceCategorySwitch.checked = false
            deviceCategorySwitch.value = false
        }
        // project name
        var projectNameSwitch = document.getElementById("projectNameSwitch")
        if (projectNameSwitch.checked) {
            projectNameSwitch.value = true
        } else {
            projectNameSwitch.checked = false
            projectNameSwitch.value = false
        }
        // projectCustomerName
        var projectCustomerNameSwitch = document.getElementById("projectCustomerNameSwitch")
        if (projectCustomerNameSwitch.checked) {
            projectCustomerNameSwitch.value = true
        } else {
            projectCustomerNameSwitch.checked = false
            projectCustomerNameSwitch.value = false
        }
        // projectCost
        var projectCostSwitch = document.getElementById("projectCostSwitch")
        if (projectCostSwitch.checked) {
            projectCostSwitch.value = true
        } else {
            projectCostSwitch.checked = false
            projectCostSwitch.value = false
        }
        // projectIncome
        var projectIncomeSwitch = document.getElementById("projectIncomeSwitch")
        if (projectIncomeSwitch.checked) {
            projectIncomeSwitch.value = true
        } else {
            projectIncomeSwitch.checked = false
            projectIncomeSwitch.value = false
        }
        // projectStartTime
        var projectStartTimeSwitch = document.getElementById("deviceCategorySwitch")
        if (projectStartTimeSwitch.checked) {
            projectStartTimeSwitch.value = true
        } else {
            projectStartTimeSwitch.checked = false
            projectStartTimeSwitch.value = false
        }
        // projectEndTime
        var projectEndTimeSwitch = document.getElementById("projectEndTimeSwitch")
        if (projectEndTimeSwitch.checked) {
            projectEndTimeSwitch.value = true
        } else {
            projectEndTimeSwitch.checked = false
            projectEndTimeSwitch.value = false
        }
        // projectDeviceCount
        var projectDeviceCountSwitch = document.getElementById("projectDeviceCountSwitch")
        if (projectDeviceCountSwitch.checked) {
            projectDeviceCountSwitch.value = true
        } else {
            projectDeviceCountSwitch.checked = false
            projectDeviceCountSwitch.value = false
        }
        // projectFleet
        var projectFleetSwitch = document.getElementById("projectFleetSwitch")
        if (projectFleetSwitch.checked) {
            projectFleetSwitch.value = true
        } else {
            projectFleetSwitch.checked = false
            projectFleetSwitch.value = false
        }
        // projectManpower
        var projectManpowerSwitch = document.getElementById("projectManpowerSwitch")
        if (projectManpowerSwitch.checked) {
            projectManpowerSwitch.value = true
        } else {
            projectManpowerSwitch.checked = false
            projectManpowerSwitch.value = false
        }
        // projectProfit
        var projectProfitSwitch = document.getElementById("projectProfitSwitch")
        if (projectProfitSwitch.checked) {
            projectProfitSwitch.value = true
        } else {
            projectProfitSwitch.checked = false
            projectProfitSwitch.value = false
        }
        console.log(customerTypeOfCompanySwitch.value)
        var USER_API_TOKEN = '<?php echo $_SESSION['USER_API_TOKEN'] ?>'
        const Settings = {
            "setttings_status": false,
            "customerName": true,
            "customerTypeOfCompany": customerTypeOfCompanySwitch.value,
            "customerIndustry": customerIndustrySwitch.value,
            "customerNumOfEmployees": customerNoOfEmployeesSwitch.value,
            "customerVATNumber": customerVATNumberSwitch.value,
            "customerVisitAddress": customerVisitAddressSwitch.value,
            "customerPostAddress": customerPostAddressSwitch.value,
            "customerSisterCompanies": customerSisterCompaniesSwitch.value,
            "employeeName": userNameSwitch.value,
            "employeeMailAddress": userEmailAddressSwitch.value,
            "employeePhoneNumber": userPhoneNumberSwitch.value,
            "employeeCompanyRole": userCompanyRoleSwitch.value,
            "employeeExternalCompany": userExternalCompanySwitch.value,
            "employeeProjectConnection": true,
            "deviceName": fleetNameSwitch.value,
            "deviceWebsite": deviceWebsiteSwitch.value,
            "deviceSerialNumber": deviceSerialNumberSwitch.value,
            "deviceSenderNumber": deviceSenderNumberSwitch.value,
            "deviceSenderType": true,
            "deviceCategory": deviceCategorySwitch.value,
            "deviceFabrication": deviceFabricationSwitch.value,
            "deviceServiceInterval": deviceServiceLogSwitch.value,
            "deviceContainerName": deviceContainerNameSwitch.value,
            "deviceServiceLog": deviceServiceLogSwitch.value,
            "deviceNotes": deviceNotesSwitch.value,
            "devicePicture": true,
            "projectName": projectNameSwitch.value,
            "projectCustomerName": projectCustomerNameSwitch.value,
            "projectCost": projectCostSwitch.value,
            "projectIncome": projectIncomeSwitch.value,
            "projectStartTime": projectStartTimeSwitch.value,
            "projectEndTime": projectEndTimeSwitch.value,
            "projectDeviceCount": projectDeviceCountSwitch.value,
            "projectFleet": projectFleetSwitch.value,
            "projectManpower": projectManpowerSwitch.value,
            "projectProfit": projectProfitSwitch.value,
            "systemLanguageOptions": [
                "English,Danish,Swedish,Norse"
            ],
            "systemLanguage": $("#language option:selected").text(),
            "currencyForCostOptions": [
                "Dollar,Euro,Pound"
            ],
            "currencyForSalaryOptions": [
                "Dollar,Euro,Pound"
            ],
            "currencyForCost": $("#currencyOnCost option:selected").text(),
            "currencyForSalary": $("#currencyOnSalary option:selected").text(),
            "version": "4.15"
        }
        var result = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/settings", "PUT", JSON.stringify(Settings), USER_API_TOKEN);
        console.log(result)
            if (result.status == 'success') {
            toastr.success("Settings Updated!")
        } else {
            toastr.error("Settings not Updated!")
        }
    }
</script>
<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
<script src="assets/plugins/select2/js/select2.js"></script>