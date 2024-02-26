//open and close form

function open_update_form() {
    document.getElementById("update-customer-form").style.zIndex = "3";
}

function close_update_form() {
    document.getElementById("update-customer-form").style.zIndex = "0";
}

function open_edit_form() {
    document.getElementById("edit-customer-form").style.zIndex = "3";
}

function close_edit_form() {
    document.getElementById("edit-customer-form").style.zIndex = "0";
}

//---------------------mouse effect on form ------------------------------
// Get the button element by its ID
var customeradd_update_tm = document.getElementById("update-times");
var customeradd_update_sqr = document.getElementById("update-times-square");
var customeradd_edit_tm = document.getElementById("edit-times");
var customeradd_edit_sqr = document.getElementById("edit-times-square");

/// ---------------------- for update form --------------------------------
// Add an event listener to change the cursor style to "pointer" when the mouse enters the button
customeradd_update_tm.addEventListener("mouseenter", function() {
    customeradd_update_tm.style.display = "none";
    customeradd_update_sqr.style.display = "block";
});

// Add an event listener to change the cursor style back to the default when the mouse leaves the button
customeradd_update_tm.addEventListener("mouseleave", function() {
    customeradd_update_tm.style.display = "block";
    customeradd_update_sqr.style.display = "none";
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