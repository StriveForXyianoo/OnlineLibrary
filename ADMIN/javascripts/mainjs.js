let currentForm = null;

function openForm(formName) {
  // Close the previously open form
  if (currentForm !== null) {
    currentForm.style.display = 'none';
  }

  // Show the selected form
  const selectedForm = document.getElementById(formName + 'Form');
  if (selectedForm) {
    selectedForm.style.display = 'block';
    currentForm = selectedForm;
  }
}

function closeForm(formName) {
  // Hide the selected form
  const selectedForm = document.getElementById(formName + 'Form');
  if (selectedForm) {
    selectedForm.style.display = 'none';
    currentForm = null;
  }
}





function toggleForm() {
    var formContainer = document.getElementById("form-container");
    formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
    
    var overlay = document.querySelector(".overlay");
    overlay.style.display = overlay.style.display === "none" ? "block" : "none";
}

// Function to preview the selected image



function toggleForm() {
    var formContainer = document.getElementById("form-container");
    formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
    
    var overlay = document.querySelector(".overlay");
    overlay.style.display = overlay.style.display === "none" ? "block" : "none";
}

// Function to preview the selected image
function previewImage() {
    var fileInput = document.getElementById("file");
    var imagePreview = document.getElementById("image-preview");
    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = "block";
        };
        reader.readAsDataURL(fileInput.files[0]);
    } else {
        imagePreview.style.display = "none";
    }
}





