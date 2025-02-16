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

class UserLogsComponent {
    constructor(insertedList, headerColumns, rowNumLimit, selectedRowGP) {
        this.insertedList = insertedList;
        this.list = this.insertedList;
        this.rowNumLimit = rowNumLimit;
        this.headerColumns = headerColumns;
        this.selectedRowGP = selectedRowGP || 1;
    }

    numOfHiddenRows () {
        const currentList = this.list.filter(item => item !== null).length;
        return this.insertedList.length - currentList;
    }

    filterList() {
        if (!this.list) {
            console.error("No list inserted.");
            return this;
        }

        this.list = this.list.map(item => item.rowId === `row${this.selectedRowGP}` ? 
            Object.fromEntries(Object.entries(item).map(([key, value]) => [key, value || "--"]))
            : null
        );

        return this;
    }

    filterByRow() {
        if (!this.list) {
            console.error("No list inserted.");
            return this;
        }

        let rowCount = 1, row = 0;
        this.list = this.list.map(e => {
            if (row >= this.rowNumLimit) {
                rowCount++;
                row = 0;
            }
            row++;
            return { ...e, rowId: `row${rowCount}` };
        });
        return this;
    }

    render(
        parentSelector,
        parentClassList = [],
        tableClassList = [],
        headerRowClassList = [],
        headerColumnClassList = [],
        bodyRowClassList = [],
        bodyColumnClassList = [],
        noRecParagraphClasslist = [],
    ) {
        const parent = document.querySelector(parentSelector);
        if (!parent) {
            console.error("Invalid parent element selector.");
            return;
        }

        parent.innerHTML = "";

        const table = document.createElement("table");
        tableClassList.forEach(cls => table.classList.add(cls));

        const thead = document.createElement("thead");
        const headerRow = document.createElement("tr");
        headerRowClassList.forEach(cls => headerRow.classList.add(cls));

        this.headerColumns.forEach(header => {
            const th = document.createElement("th");
            th.textContent = header;
            headerColumnClassList.forEach(cls => th.classList.add(cls));
            headerRow.appendChild(th);
        });

        thead.appendChild(headerRow);
        table.appendChild(thead);

        const tbody = document.createElement("tbody");

        if (this.list) {
            this.list.forEach(item => {
                if (item) {
                    const row = document.createElement("tr");
                    bodyRowClassList.forEach(cls => row.classList.add(cls));
                    Object.entries(item).forEach(value => {
                        if (value[0] !== "rowId") {
                            const td = document.createElement("td");
                            td.textContent = value[1];
                            bodyColumnClassList.forEach(cls => td.classList.add(cls));
                            row.appendChild(td);
                        }
                    });
                    tbody.appendChild(row);
                }
            });
        } else {
            const p = document.createElement("p");
            p.textContent = "No record selected.";
            noRecParagraphClasslist.forEach(cls => p.classList.add(cls));
            tbody.appendChild(p);
        }

        table.appendChild(tbody);
        parent.appendChild(table);

        parentClassList.forEach(cls => parent.classList.add(cls));

        return this;
    }
}

/*
const component = new UserLogsComponent(list, ["Status", "Activity", "Time", "Date"], 5, 2);
component
.filterByRow()
.filterList()
.render(
    "#logContainer", 
    ["log-container"], 
    ["table", "table-bordered"], 
    ["header-row"], 
    ["header-cell"], 
    ["body-row"], 
    ["body-cell"],
);

console.log(component.numOfHiddenRows());

*/