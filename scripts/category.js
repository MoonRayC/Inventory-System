
function openEditModal(categoryID) {
    $.ajax({
        url: 'action/fetchCategory.php',
        type: 'GET',
        data: {
            categoryID: categoryID
        },
        dataType: 'json',
        success: function(data) {
            document.getElementById('categoryID').value = data.categoryID;
            document.getElementById('editCategoryName').value = data.name;
            document.getElementById('status').value = data.status;

            $('#editCategory-form').modal('show');
        },
        error: function() {
            console.log('Error fetching category data.');
        }
    });
}

function addCategory() {
    if (validateAddForm()) {
        document.getElementById("addCategoryForm").submit();
    }
}

function validateAddForm() {
    var categoryName = document.getElementById("addCategoryName").value;
    var categoryErrorSpan = document.getElementById("categoryAddError");

    categoryErrorSpan.innerHTML = "";
    document.getElementById("addCategoryName").classList.remove("is-invalid");

    if (categoryName.trim() === "") {
        categoryErrorSpan.innerHTML = "Please enter a category name.";
        document.getElementById("addCategoryName").classList.add("is-invalid");
        return false;
    }
    return true;
}

function editCategory() {
    if (validateEditForm()) {
        document.getElementById("editCategoryForm").submit();
    }
}

function validateEditForm() {
    var categoryName = document.getElementById("editCategoryName").value;
    var status = document.getElementById("status").value;
    var categoryErrorSpan = document.getElementById("categoryEditError");
    var statusErrorSpan = document.getElementById("statusError");

    categoryErrorSpan.innerHTML = "";
    document.getElementById("editCategoryName").classList.remove("is-invalid");

    statusErrorSpan.innerHTML = "";
    document.getElementById("status").classList.remove("is-invalid");

    if (categoryName.trim() === "") {
        categoryErrorSpan.innerHTML = "Please enter a brand name.";
        document.getElementById("editCategoryName").classList.add("is-invalid");
        return false;
    }

    if (status.trim() === "null") {
        statusErrorSpan.innerHTML = "Please Select a Brand.";
        document.getElementById("status").classList.add("is-invalid");
        return false;
    }
    return true;
}