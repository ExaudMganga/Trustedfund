//open and close form
function open_add_form() {
    document.getElementById("add-customer-form").style.zIndex = "3";
}

function close_add_form() {
    document.getElementById("add-customer-form").style.zIndex = "0";
}

function open_edit_form() {
    document.getElementById("edit-customer-form").style.zIndex = "3";
}

function close_edit_form() {
    window.location.href = "http://127.0.0.1/Login_Page/Pages/dashboard/dashboard.php";
    // document.getElementById("edit-customer-form").style.zIndex = "0";
}
//---------------------mouse effect on form ------------------------------
// Get the button element by its ID
var customeradd_add_tm = document.getElementById("add-times");
var customeradd_add_sqr = document.getElementById("add-times-square");
var customeradd_edit_tm = document.getElementById("edit-times");
var customeradd_edit_sqr = document.getElementById("edit-times-square");
// var customeredit = document.getElementById("edit-customer-form");

// --------------------- for add form -----------------------------------
// Add an event listener to change the cursor style to "pointer" when the mouse enters the button
customeradd_add_tm.addEventListener("mouseenter", function() {
    customeradd_add_tm.style.display = "none";
    customeradd_add_sqr.style.display = "block";
});

// Add an event listener to change the cursor style back to the default when the mouse leaves the button
customeradd_add_tm.addEventListener("mouseleave", function() {
    customeradd_add_tm.style.display = "block";
    customeradd_add_sqr.style.display = "none";
});

/// ---------------------- for edit form --------------------------------
// Add an event listener to change the cursor style to "pointer" when the mouse enters the button
customeradd_edit_tm.addEventListener("mouseenter", function() {
    customeradd_edit_tm.style.display = "none";
    customeradd_edit_sqr.style.display = "block";
});

// Add an event listener to change the cursor style back to the default when the mouse leaves the button
customeradd_edit_tm.addEventListener("mouseleave", function() {
    customeradd_edit_tm.style.display = "block";
    customeradd_edit_sqr.style.display = "none";
});