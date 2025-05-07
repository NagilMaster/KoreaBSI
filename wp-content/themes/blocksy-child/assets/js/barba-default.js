// This function helps add and remove js and css files during a page transition
function loadjscssfile(filename, filetype) {
  if (filetype == "js") {
    //if filename is a external JavaScript file
    const existingScript = document.querySelector('script[src="${filename}"]');
    if (existingScript) {
      existingScript.remove();
    }
    var fileref = document.createElement("script");
    fileref.setAttribute("type", "text/javascript");
    fileref.setAttribute("src", filename);
  } else if (filetype == "css") {
    //if filename is an external CSS file
    const existingCSS = document.querySelector(`link[href='${filename}']`);
    if (existingCSS) {
      existingCSS.remove();
    }
    var fileref = document.createElement("link");
    fileref.setAttribute("rel", "stylesheet");
    fileref.setAttribute("type", "text/css");
    fileref.setAttribute("href", filename);
  }
  if (typeof fileref != "undefined")
    document.getElementsByTagName("head")[0].appendChild(fileref);
}
barba.hooks.beforeEnter(({current, next}) => {

                // Set <body> classes for the 'next' page
                if (current.container) {
                    // // only run during a page transition - not initial load
                    let nextHtml = next.html;
                    let response = nextHtml.replace(/(<\/?)body( .+?)?>/gi, "$1notbody$2>", nextHtml);

                    let bodyClasses = jQuery(response).filter("notbody").attr("class");
                    jQuery("body").attr("class", bodyClasses);

                    // ELEMENTOR
                    // Where the magic happens - this loads the new Elementor styles and removes the old styles
                    if (bodyClasses.includes("elementor-page")) {
                        let currentPageId = current.container.querySelector(".elementor").getAttribute("data-elementor-id");
                        let nextPageId = next.container.querySelector(".elementor").getAttribute("data-elementor-id");
                        let oldScriptURL = "/wp-content/uploads/elementor/css/post-" + currentPageId + ".css";
                        let newScriptURL = "/wp-content/uploads/elementor/css/post-" + nextPageId + ".css"; // Add this for cache fix: ?cachebuster=' + new Date().getTime()

//                         console.log('Old css: ' + oldScriptURL);
//                         console.log('New css: ' + newScriptURL);
//                         console.log(current.container);

                        const oldElementorScript = document.querySelector('link[src="' + oldScriptURL + '"]');
                        if (oldElementorScript) {
                            oldElementorScript.remove();
                        }
                        loadjscssfile(newScriptURL, "css");
                    }
                }

            });


barba.init({
  transitions: [{
	  sync: false,
    name: 'opacity-transition',
    leave(data) {
      return gsap.to(data.current.container, {
        opacity: 0,
          duration: 0.5
      });
    },
    enter(data) {
      return gsap.from(data.next.container, {
        opacity: 0,
          duration: 0.5
      });
    }
  }]
});
