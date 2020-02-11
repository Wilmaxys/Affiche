var listeners = [], 
doc = window.document, 
MutationObserver = window.MutationObserver || window.WebKitMutationObserver,
observer;

var ready = function ready(selector, fn) {
    // Store the selector and callback to be monitored
    listeners.push({
        selector: selector,
        fn: fn
    });
    if (!observer) {
        // Watch for changes in the document
        observer = new MutationObserver(check);
        observer.observe(doc.documentElement, {
            childList: true,
            subtree: true
        });
    }
    // Check if the element is currently in the DOM
    check();
}
    
var check = function check() {
    // Check the DOM for elements matching a stored selector
    for (var i = 0, len = listeners.length, listener, elements; i < len; i++) {
        listener = listeners[i];
        // Query for elements matching the specified selector
        elements = doc.querySelectorAll(listener.selector);
        for (var j = 0, jLen = elements.length, element; j < jLen; j++) {
            element = elements[j];
            // Make sure the callback isn't invoked with the 
            // same element more than once
            if (!element.ready) {
                element.ready = true;
                // Invoke the callback with the element
                listener.fn.call(element, element);
            }
        }
    }
}

ready('.input-textBox', function(element) {
    var input = element;
    var parent = element.parentNode;

    if (input.value) {
        parent.classList.add("active");
    }
});

if (localStorage.getItem("currentActive")) {
    // ready(localStorage.getItem("currentActive"), function(){

    // });
}

