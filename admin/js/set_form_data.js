jQuery(document).ready(function(){
  //initialize Form Builder
   jQuery(function($) {
    var fbTemplate = document.getElementById('build-wrap'),
      options = {
        formData: '',
      };
    $(fbTemplate).formBuilder(options);
    
    // var fbTemplate_main = document.getElementById('main-build-wrap'),
    //   options = {
    //     formData: '',
    //   };
    // $(fbTemplate_main).formBuilder(options);
  });
});