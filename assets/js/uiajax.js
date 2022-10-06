var global_api_url = "http://vghar.ddns.net:6060/ZFMS/";
$(document).ready(function () {
	//Edit customer

	// $("#customerRecords > tbody > tr td:not(:last-child)").click(function () {
	$(".editCustomer").click(function () {
		//alert("Hi");
		custId = $(this).closest("tr").attr("id");
		custName = $(this).closest("tr").find(".custName").text();
		groupId = $(this).closest("tr").find(".groupId").text();
		custIndustry = $(this).closest("tr").find(".custIndustry").text();
		custEmployees = $(this).closest("tr").find(".custEmployees").text();
		custVatNumber = $(this).closest("tr").find(".custVatNumber").text();
		custVisitAddress = $(this).closest("tr").find(".custVisitAddress").text();
		custPostAddress = $(this).closest("tr").find(".custPostAddress").text();
		custSisterCompanies = $(this)
			.closest("tr")
			.find(".custSisterCompanies")
			.text();
		custType = $(this).closest("tr").find(".custType").text();
		$("#customerId").val(custId);
		$("#customerName").val(custName);
		$("#typeOfCompany").val(custType);
		$("#industry").val(custIndustry);
		$("#vatNumber").val(custVatNumber);
		$("#visitAdress").val(custVisitAddress);
		$("#postAdress").val(custPostAddress);
		$("#numberOfEmployees").val(custEmployees);

		$("#emailId").removeAttr("required");
		$("#password").removeAttr("required");
		$("#employeeName").removeAttr("required");
		$("#mailAddress").removeAttr("required");
		$("#companyRole").removeAttr("required");

		$(".invisible-section").hide();
		$("#form-title").text("Update Customer");
		$("#NewCustomerModel").modal("show");
	});

	//Edit Emplyoee
	$(".editEmployee").click(function () {
		empId = $(this).closest("tr").attr("id");
		empName = $(this).closest("tr").find(".empName").text();
		mailAddress = $(this).closest("tr").find(".mailAddress").text();
		phoneNo = $(this).closest("tr").find(".phoneNo").text();
		companyRole = $(this).closest("tr").find(".companyRole").text();
		extCompany = $(this).closest("tr").find(".extCompany").text();
		access = $(this).closest("tr").find(".access").text();
		customerId = $(this).closest("tr").find(".customerId").text();
		$("#employeeId").val(empId);
		$("#employeeName").val(empName);
		$("#mailAddress").val(mailAddress);
		$("#phoneNumber").val(phoneNo);
		$("#companyRole").val(companyRole);
		$("#externalCompany").val(extCompany);
		$("#customerId").val(customerId);
		$('#customerId').attr("disabled", true);
		$("#access").val(access);
		$("#emailId").removeAttr("required");
		$("#password").removeAttr("required");
		$(".invisible-section").hide();
		$("#form-title").text("Update Employee");
		$("#newEmployeeModel").modal("show");
	});

	//Edit Device
	$(".editDevice").click(function () {
		deviceId = $(this).closest("tr").attr("id");
		deviceName = $(this).closest("tr").find(".name").text();
		website = $(this).closest("tr").find(".website").text();
		serialNo = $(this).closest("tr").find(".serialNo").text();
		senderNo = $(this).closest("tr").find(".senderNo").text();
		senderType = $(this).closest("tr").find(".senderType").text();
		objectCategory = $(this).closest("tr").find(".objectCategory").text();
		fabrication = $(this).closest("tr").find(".fabrication").text();
		serviceInterval = $(this).closest("tr").find(".serviceInterval").text();
		serviceArray = serviceInterval.split(" ");
		servicePrefix = serviceArray[0];
		serviceSuffix = serviceArray[1];
		console.log(serviceSuffix);
		$("#deviceId").val(deviceId);
		$("#deviceName").val(deviceName);
		$("#deviceWebsite").val(website);
		$("#deviceTool").removeAttr("required");
		$("#serialNumber").val(serialNo);
		$("#senderNumber").val(senderNo);
		$("#senderType").val(senderType);
		$("#objectCategory").val(objectCategory);
		$("#fabrication").val(fabrication);
		$("#intervalPrefix").val(servicePrefix);
		$("#intervalSuffix").val(serviceSuffix);
		$("#serviceLog").removeAttr("required");
		$("#Notes").removeAttr("required");
		$("#pictureOfProduct").removeAttr("required");
		$(".invisible-section").hide();
		$("#form-title").text("Update");
		$("#newDeviceModal").modal("show");
	});
});
function resetProjectFormData()
	{
		$("startDate").val("-1");
		$("endDate").val("-1");
		$("customerName").val("-1");
		$("projectCost").val("-1");
		$("projectIncome").val("-1");
		$("projectManpower").val("-1");
		$("projectFleet").val("-1");
		$("projectName").val("-1");

	}


function resetCustomerFormData() {
	$("#customerId").val("-1");
	$("#form-title").text("New Customer");
	$(".invisible-section").show();
	$(".form").trigger("reset");
}

function resetFormData() {
	$(".invisible-section").show();
	$(".form").trigger("reset");
}

function resetEmployeeFormData() {
	$('#customerId').removeAttr("disabled");
	$("#form-title").text("New Employee");

	var project_result = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project", "GET", "", "");
	console.log(JSON.parse(project_result).length);
	const project_json = JSON.parse(project_result);
	project_json.forEach(obj => renameKey(obj, 'name', 'text'));

	var customer_result = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer", "GET", "", "");
	console.log(JSON.parse(customer_result).length);
	const customer_json = JSON.parse(customer_result);
	customer_json.forEach(obj => renameKey(obj, 'name', 'text'));

	$('#customerId').select2({
		theme: 'bootstrap4',
		dropdownParent: $('#newEmployeeModel'),
		placeholder: 'Select a Customer',
		tags: true,
		multiple: false,
		tokenSeparators: [',', ' '],
		data: customer_json
	});
	$('#projectId').select2({
		theme: 'bootstrap4',
		dropdownParent: $('#newEmployeeModel'),
		placeholder: 'Select a Project',
		tags: true,
		multiple: true,
		tokenSeparators: [',', ' '],
		// minimumInputLength: 2,
		// minimumResultsForSearch: 3,
		data: project_json
	});

	$(".invisible-section").show();
	$(".form").trigger("reset");
}

function GetProjectsForCustomer(customerId) {
	var customerData = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/customer/" + customerId, "GET", "", "");
	console.log("Customer Data " + customerData);
	var project_list = JSON.parse(customerData)["projectList"].toString().trim();

	if (project_list == null || project_list === "") { } else {
		console.log("Project List:" + project_list + ":");
		var project_list_arr = project_list.split(/\s*,\s*/);

		var project_output = [];
		for (let pi = 0; pi < project_list_arr.length; pi++) {
			var project_details = performAPIAJAXCall("http://vghar.ddns.net:6060/ZFMS/project/" + project_list_arr[pi], "GET", "", "");
			// console.log("project details: " + project_details);
			project_output.push(project_details);
		}

	}
	// console.log("project_output " + project_output);
	return project_output;
}

function performAPIAJAXCall(base_url, request_type, req_body, headers) {
	// console.log("Req body: " + req_body);
	var response_text = "";
	var ajax_call = $.ajax({
		type: request_type,
		url: base_url,
		data: req_body,
		dataType: "json",
		crossDomain: true,
		async: false
		,
		headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json',
			'Access-Control-Allow-Origin': '*',
			"USER_API_TOKEN": headers
		}
	});
	ajax_call.done(function (req, status, resultData) {
		// console.log("Success in API AJAX call!");
		// console.log(" req " + req);
		// console.log("Status: " + resultData.status);
		// console.log("Success " + resultData.responseText);
		// response_text = resultData.responseText;
		response_text={
			"status":status,
			"responsedata":resultData
		}
	});
	ajax_call.fail(function (req, status, errorData) {
		// console.log("Error req " + req.responseText);
		// response_text = req.responseText;
		// console.log("Error status: " + req.status);
		// console.log("Error in API AJAX call: " + errorData);
		// response_text = "failed: " + errorData;
		response_text={
			"status":status,
			"responsedata":errorData
		}
	});
	return response_text;
}

function performAPIAJAXCallGeneric(base_url, request_type, req_body, headers) {
	// console.log("Req body: " + req_body);
	var response_text = "";
	var ajax_call = $.ajax({
		type: request_type,
		url: base_url,
		data: req_body,
		// dataType: "json",
		crossDomain: true,
		async: false,
		headers: {
			// 'Accept': 'application/json',
			// 'Content-Type': 'application/json',
			'Access-Control-Allow-Origin': '*',
			"USER_API_TOKEN": headers
		}
	});
	ajax_call.done(function (req, status, resultData) {
		response_text={
			"status":status,
			"responsedata":resultData
		}
	});
	ajax_call.fail(function (req, status, errorData) {
		response_text={
			"status":status,
			"responsedata":errorData
		}
	});
	return response_text;
}

function createCustomer() {
	var cust = document.getElementById("newCustomerForm");
	// cust.
}

function getProjectsList(projectId, customerId) {
	ajax_response = performAPIAJAXCall("", "GET", "", "");
	if (ajax_response.indexOf("failed: ") !== -1) {
		// HTTP request failed
		return "";
	}
	else {
		return ajax_response;
	}
}

function renameKey(obj, oldKey, newKey) {
	obj[newKey] = obj[oldKey];
	delete obj[oldKey];
}








