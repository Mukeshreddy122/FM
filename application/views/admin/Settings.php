<section class="content">
    <?php
    if ($_SESSION['permission'] != "ADMIN") {
        redirect(base_url() . 'PM');
    }
    print_r($_SESSION['systemLanguageOptions']);
    // die;
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs active-aqua" id="tabSettingsParent" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" aria-selected="true" id="generalSettings-tab" data-toggle="pill" href="#generalSettings" role="tab" aria-controls="generalSettings">General Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-selected="true" id="customerSettings-tab" data-toggle="pill" href="#customerSettings" role="tab" aria-controls="customerSettings">Customer Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-selected="true" class="nav-link " aria-selected="false" id="UserSettings-tab" data-toggle="pill" href="#UserSettings" role="tab" aria-controls="UserSettings">Employee Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-selected="true" id="fleetSettings-tab" data-toggle="pill" href="#fleetSettings" role="tab" aria-controls="fleetSettings">Fleet Settings</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-content-below-tabContent">
                        <div class="tab-pane fade show active" id="customerSettings" role="tabpanel" aria-labelledby="customerSettings-tab">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <input type="checkbox" checked disabled class="custom-control-input" id="customerNameSwitch">
                                            <label class="custom-control-label" for="customerNameSwitch">Customer Name</label>
                                        </div>
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['customerTypeOfCompany'] == 1) {
                                                echo '<input type="checkbox" checked class="custom-control-input" id="customerTypeOfCompanySwitch">';
                                                echo '<label class="custom-control-label" for="customerTypeOfCompanySwitch">Type of Company</label>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="customerTypeOfCompanySwitch">';
                                                echo '<label class="custom-control-label" for="customerTypeOfCompanySwitch">Type of Company</label>';
                                            } ?>
                                        </div>
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['customerIndustry'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked class="custom-control-input" id="customerIndustrySwitch">
                                            <label class="custom-control-label" for="customerIndustrySwitch">Industry</label>
                                        </div>
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['customerNumOfEmployees'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked class="custom-control-input" id="customerNoOfEmployeesSwitch">
                                            <label class="custom-control-label" for="customerNoOfEmployeesSwitch">No. of Employees</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
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
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['customerVisitAddress'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked class="custom-control-input" id="customerVisitAddressSwitch">
                                            <label class="custom-control-label" for="customerVisitAddressSwitch">Visit Address</label>
                                        </div>
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['customerPostAddress'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked class="custom-control-input" id="customerPostAddressSwitch">
                                            <label class="custom-control-label" for="customerPostAddressSwitch">Post Address</label>
                                        </div>
                                        <div class="custom-control custom-switch custom-switch-on-info">
                                            <?php if ($_SESSION['customerSisterCompanies'] == 1) {
                                                echo '';
                                                echo '';
                                            } else {
                                                echo '';
                                                echo '';
                                            } ?>
                                            <input type="checkbox" checked class="custom-control-input" id="customerSisterCompaniesSwitch">
                                            <label class="custom-control-label" for="customerSisterCompaniesSwitch">Sister Companies</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="UserSettings" role="tabpanel" aria-labelledby="UserSettings-tab">
                            <div class="row">
                                <div class="col-4">
                                    <div class="custom-control custom-switch custom-switch-on-info">
                                        <input type="checkbox" checked disabled class="custom-control-input" id="userNameSwitch">
                                        <label class="custom-control-label" for="userNameSwitch">Employee Name</label>
                                    </div>
                                    <div class="custom-control custom-switch custom-switch-on-info">
                                        <?php if ($_SESSION['employeeMailAddress'] == 1) {
                                            echo '';
                                            echo '';
                                        } else {
                                            echo '';
                                            echo '';
                                        } ?>
                                        <input type="checkbox" checked class="custom-control-input" id="userMailingAddressSwitch">
                                        <label class="custom-control-label" for="userMailingAddressSwitch">Mailing Address</label>
                                    </div>
                                    <div class="custom-control custom-switch custom-switch-on-info">
                                        <?php if ($_SESSION['employeePhoneNumber'] == 1) {
                                            echo '';
                                            echo '';
                                        } else {
                                            echo '';
                                            echo '';
                                        } ?>
                                        <input type="checkbox" checked class="custom-control-input" id="userPhoneNumberSwitch">
                                        <label class="custom-control-label" for="userPhoneNumberSwitch">Phone Number</label>
                                    </div>
                                    <div class="custom-control custom-switch custom-switch-on-info">
                                        <?php if ($_SESSION['employeeCompanyRole'] == 1) {
                                            echo '';
                                            echo '';
                                        } else {
                                            echo '';
                                            echo '';
                                        } ?>
                                        <input type="checkbox" checked class="custom-control-input" id="userCompanyRoleSwitch">
                                        <label class="custom-control-label" for="userCompanyRoleSwitch">Company Role</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="custom-control custom-switch custom-switch-on-info">
                                        <?php if ($_SESSION['employeeExternalCompany'] == 1) {
                                            echo '';
                                            echo '';
                                        } else {
                                            echo '';
                                            echo '';
                                        } ?>
                                        <input type="checkbox" checked class="custom-control-input" id="userExternalCompanySwitch">
                                        <label class="custom-control-label" for="userExternalCompanySwitch">External Company</label>
                                    </div>
                                    <div class="custom-control custom-switch custom-switch-on-info">
                                        <?php if ($_SESSION['employeeExternalCompany'] == 1) {
                                            echo '';
                                            echo '';
                                        } else {
                                            echo '';
                                            echo '';
                                        } ?>
                                        <input type="checkbox" checked disabled class="custom-control-input" id="userEmailAddressSwitch">
                                        <label class="custom-control-label" for="userEmailAddressSwitch">Email</label>
                                    </div>
                                    <div class="custom-control custom-switch custom-switch-on-info">
                                        <?php if ($_SESSION['employeeExternalCompany'] == 1) {
                                            echo '';
                                            echo '';
                                        } else {
                                            echo '';
                                            echo '';
                                        } ?>
                                        <input type="checkbox" checked disabled class="custom-control-input" id="userPostAddressSwitch">
                                        <label class="custom-control-label" for="userPostAddressSwitch">Password</label>
                                    </div>
                                    <div class="custom-control custom-switch custom-switch-on-info">
                                        <?php if ($_SESSION['customerName'] == 1) {
                                            echo '';
                                            echo '';
                                        } else {
                                            echo '';
                                            echo '';
                                        } ?>
                                        <input type="checkbox" checked class="custom-control-input" id="userSisterCompaniesSwitch">
                                        <label class="custom-control-label" for="userSisterCompaniesSwitch">Projects List</label>
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
                                            <label class="custom-control-label" for="fleetNameSwitch">Fleet Name</label>
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
                        <div class="tab-pane fade" id="generalSettings" role="tabpanel" aria-labelledby="generalSettings-tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <p>Language</p>
                                    <select id="language" class="form-control select2">
                                        <?php
                                        $languageList = explode(",", $_SESSION['systemLanguageOptions']);
                                        $selectedLanguage = $_SESSION['systemLanguage'];

                                        $lang_select = "";
                                        foreach ($languageList as $lang) {
                                            if ($lang == $selectedLanguage) {
                                                $lang_select += "<option value='" . $lang . "' selected='selected'>" . $lang . "</option>";
                                            } else {
                                                $lang_select +=  "<option value='" . $lang . "' >" . $lang . "</option>";
                                            }
                                        }
                                        echo $lang_select;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <p>Currency on Cost</p>
                                    <select class="form-control select2" id="currencyOnCost">
                                        <?php
                                        $currencyCostList = explode(",", $_SESSION['currencyForCostOptions']);
                                        $currencyCostSelected = $_SESSION['currencyForCost'];

                                        foreach ($currencyCostList as $currencyCost) {
                                            if ($currencyCost == $currencyCostSelected) {
                                                switch ($currencyCost) {
                                                    case "US Dollar":
                                                        echo '<option selected> $ ' . $currencyCost . '</option>';
                                                        break;
                                                    case "GB Pound":
                                                        echo '<option selected> £ ' . $currencyCost . '</option>';
                                                        break;
                                                    case "Euro":
                                                        echo '<option selected> € ' . $currencyCost . '</option>';
                                                        break;
                                                }
                                            } else {
                                                switch ($currencyCost) {
                                                    case "US Dollar":
                                                        echo '<option > $ ' . $currencyCost . '</option>';
                                                        break;
                                                    case "GB Pound":
                                                        echo '<option > £ ' . $currencyCost . '</option>';
                                                        break;
                                                    case "Euro":
                                                        echo '<option > € ' . $currencyCost . '</option>';
                                                        break;
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <p>Currency on Salary</p>
                                    <select class="custom-select form-control-border" id="currencyOnCost">
                                        <?php
                                        $currencySalaryList = explode(",", $_SESSION['currencyForSalaryOptions']);
                                        $currencySalarySelected = $_SESSION['currencyForSalary'];

                                        foreach ($currencySalaryList as $currencySalary) {
                                            if ($currencySalary == $currencySalarySelected) {
                                                switch ($currencySalary) {
                                                    case "US Dollar":
                                                        echo '<option selected> $ ' . $currencySalary . '</option>';
                                                        break;
                                                    case "GB Pound":
                                                        echo '<option selected> £ ' . $currencySalary . '</option>';
                                                        break;
                                                    case "Euro":
                                                        echo '<option selected> € ' . $currencySalary . '</option>';
                                                        break;
                                                }
                                            } else {
                                                switch ($currencySalary) {
                                                    case "US Dollar":
                                                        echo '<option > $ ' . $currencySalary . '</option>';
                                                        break;
                                                    case "GB Pound":
                                                        echo '<option > £ ' . $currencySalary . '</option>';
                                                        break;
                                                    case "Euro":
                                                        echo '<option > € ' . $currencySalary    . '</option>';
                                                        break;
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">&nbsp;</div>
        <div class="col-sm-4">&nbsp;</div>
        <div class="col-sm-4">
            <button type="button" class="btn bg-info">Save</button>
        </div>
    </div>
</section>

<script>
    $(function() {
        $('#language').select2();
        $('#currencyOnCost').select2();
    });
</script>
<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
<script src="assets/plugins/select2/js/select2.js"></script>