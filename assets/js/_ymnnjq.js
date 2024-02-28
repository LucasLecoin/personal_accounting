export default {
    qs(selector, parent) {
        if(!parent) {
            parent = document;
        }
        return parent.querySelector(selector);
    },
    qsa(selector, parent) {
        if(!parent) {
            parent = document;
        }
        return parent.querySelectorAll(selector);
    },
    is_string(object) {
        return (typeof object === "string");
    },
    on(eventName, element, callback) {
        let is_string;
        if (element instanceof EventTarget) {
            element.addEventListener(eventName, callback);
        } else if(element instanceof NodeList || (is_string = this.is_string(element))) {
            if(is_string) {
                element = document.querySelectorAll(element);
            }
            element.forEach(el => el.addEventListener(eventName, callback));
        } else {
            throw new Error("Can't add an event listener to this object of type : " + (typeof element));
        }
    },
    parents(el, selector) {
        const parents = [];
        while ((el = el.parentNode) && el !== document) {
            if (!selector || el.matches(selector)) parents.push(el);
        }
        return parents;
    }
}