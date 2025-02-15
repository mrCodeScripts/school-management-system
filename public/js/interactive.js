"use strict";

import { login_form, login_loader } from "./dom.js";

export function createErrorMessage(
    _txtElement, 
    _message, 
    _classLists, 
    _add = false
) {
    if (_txtElement instanceof HTMLElement) {
        console.error("Not an element.");
        return false;
    }
    if (
        (typeof _message) !== "string" || 
        (typeof _message) !== "number"
    ) {
        console.error("Not a string or a number.");
        return false;
    }
    if ((typeof _classLists) !== "array") {
        console.error("Not an array.");
        return false;
    }
    if ((typeof _add) !== "boolean") {
        console.error("Not a boolean.");
        return false;
    }
    const _tempClassList = _classLists.join(" ");
    if (_add) {
        toggleClass(_txtElement, _classLists, true);
        _txtElement.innerText = _message;
    } else {
        toggleClass(_txtElement, _classLists);
        _txtElement.innerText = "";
    }
};

export function toggleClass (_element, _classLists, add = false) {
    if (!(_element instanceof HTMLElement)) {
        console.error("Not an element.");
        return false;
    }
    if (!Array.isArray(_classLists)) {
        console.error("Not an array.");
        return false;
    }
    if ((typeof add) !== "boolean") {
        console.error("Not a boolean.");
        return false;
    }
    const _tempClassList = _classLists.join(" ");
    const _elemClassList = _element.className.split(" ");
    const _newClassList = _tempClassList.split(" ").filter(cls => {
        return !_elemClassList.includes(cls)}).join(" ");
        console.log(_newClassList);
    if (add === true && _newClassList !== "") {
        _element.classList.add(_newClassList);
    } else if (add === false && _elemClassList !== "") {
        _elemClassList.forEach(cls => {
            if (_tempClassList.includes(cls)) _element.classList.remove(cls);
        });
    } else {
        return false;
    }
};
