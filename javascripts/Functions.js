                // Function to scroll to the content
                function scrollToContent() {
                  const content = document.getElementById('content');
                  content.scrollIntoView({ behavior: 'smooth' });
              }
        
              // Function to scroll to the top
              function scrollToTop() {
                  window.scrollTo({ top: 0, behavior: 'smooth' });
              }
        
              // Show/hide scroll-to-top button based on scroll position
              window.onscroll = function() {
                  const scrollButton = document.getElementById('scrollButton');
                  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                      scrollButton.style.display = 'block';
                  } else {
                      scrollButton.style.display = 'none';
                  }
              };




              document.addEventListener("DOMContentLoaded", function () {
                const navToggle = document.getElementById("navToggle");
                const sideNav = document.getElementById("sideNav");
                const closeButton = document.getElementById("closeButton");
            
                navToggle.addEventListener("click", function () {
                    if (sideNav.classList.contains("open-nav")) {
                        sideNav.classList.remove("open-nav");
                    } else {
                        sideNav.classList.add("open-nav");
                    }
                });
            
                closeButton.addEventListener("click", function () {
                    sideNav.classList.remove("open-nav");
                });
            });
            
 


            let activeForm = null;

            function openForm(id) {
                if (activeForm !== null) {
                    return; // Only one form can be open at a time
                }
                activeForm = id;
                const form = document.getElementById(`form${id}`);
                form.style.display = "block";
                disableOtherBoxes(id);
    
                // Add the 'active' class to the form to show the backdrop
                form.classList.add("active");
            }
    
            function closeForm(id) {
                const form = document.getElementById(`form${id}`);
                form.style.display = "none";
                enableAllBoxes();
                activeForm = null;
    
                // Remove the 'active' class to hide the backdrop
                form.classList.remove("active");
            }
    
            function disableOtherBoxes(id) {
                const boxes = document.querySelectorAll(".box");
                for (const box of boxes) {
                    if (!box.classList.contains(`box${id}`)) {
                        box.style.pointerEvents = "none";
                    }
                }
            }
    
            function enableAllBoxes() {
                const boxes = document.querySelectorAll(".box");
                for (const box of boxes) {
                    box.style.pointerEvents = "auto";
                }
            }


            