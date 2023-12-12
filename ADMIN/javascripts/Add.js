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



function previewImage(inputId, imageId) {
    const input = document.querySelector(`input[name="${inputId}"]`);
    const image = document.getElementById(imageId);

    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            image.src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        // Clear the image source if no file is selected
        image.src = '';
    }
}



///////////////////////////////////////////////////


document.getElementById("libraryDropdown").addEventListener("click", function() {
  document.getElementById("sectionOptions").style.display = "block";
});




/////////////////////////////

