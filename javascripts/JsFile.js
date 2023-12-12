var responsiveSlider = function() {

    var slider = document.getElementById("slider");
    var sliderWidth = slider.offsetWidth;
    var slideList = document.getElementById("slideWrap");
    var count = 1;
    var items = slideList.querySelectorAll("li").length;
    var prev = document.getElementById("prev");
    var next = document.getElementById("next");
    
    window.addEventListener('resize', function() {
      sliderWidth = slider.offsetWidth;
    });
    
    var prevSlide = function() {
      if(count > 1) {
        count = count - 2;
        slideList.style.left = "-" + count * sliderWidth + "px";
        count++;
      }
      else if(count = 1) {
        count = items - 1;
        slideList.style.left = "-" + count * sliderWidth + "px";
        count++;
      }
    };
    
    var nextSlide = function() {
      if(count < items) {
        slideList.style.left = "-" + count * sliderWidth + "px";
        count++;
      }
      else if(count = items) {
        slideList.style.left = "0px";
        count = 1;
      }
    };
    
    next.addEventListener("click", function() {
      nextSlide();
    });
    
    prev.addEventListener("click", function() {
      prevSlide();
    });
    
    setInterval(function() {
      nextSlide()
    }, 8000);
    
    };
    
    window.onload = function() {
    responsiveSlider();  
    }


    //   CONTACT BTN     
    const dropdownBtn = document.getElementById("btn");
    const dropdownMenu = document.getElementById("dropdown");
    const toggleArrow = document.getElementById("arrow");
    
    // Toggle dropdown function
    const toggleDropdown = function () {
      dropdownMenu.classList.toggle("show");
      toggleArrow.classList.toggle("arrow");
    };
    
    // Toggle dropdown open/close when dropdown button is clicked
    dropdownBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      toggleDropdown();
    });
    
    // Close dropdown when dom element is clicked
    document.documentElement.addEventListener("click", function () {
      if (dropdownMenu.classList.contains("show")) {
        toggleDropdown();
      }
      
    }
      
    );

    
 
    // ABOUT US BTN
    

    const dropdownBtn2 = document.getElementById("btn2");
    const dropdownMenu2 = document.getElementById("dropdown2");
    const toggleArrow2 = document.getElementById("arrow");
    
    // Toggle dropdown function
    const toggleDropdown2 = function () {
      dropdownMenu2.classList.toggle("show");
      toggleArrow2.classList.toggle("arrow");
    };
    
    // Toggle dropdown open/close when dropdown button is clicked
    dropdownBtn2.addEventListener("click", function (e) {
      e.stopPropagation();
      toggleDropdown2();
    });
    
    // Close dropdown when dom element is clicked
    document.documentElement.addEventListener("click", function () {
      if (dropdownMenu2.classList.contains("show")) {
        toggleDropdown2();
      }
    
    }
      
    );



  // SIDE NAV

  function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
  }
  
  function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
    document.body.style.backgroundColor = "white";
  }

   // BOOOK HISTORY
   const openFormBtn = document.getElementById("openFormBtn");
   const closeFormBtn = document.getElementById("closeFormBtn");
   const formOverlay = document.getElementById("formOverlay");
 
   openFormBtn.addEventListener("click", () => {
     formOverlay.style.display = "flex";
   });
 
   closeFormBtn.addEventListener("click", () => {
     formOverlay.style.display = "none";
   });



// for IMAGE SLIDER


// for UPLOAD UPDATES


  // JavaScript to show and hide the pop-up
