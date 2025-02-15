"use strict";

import { 
    login_form, 
    login_loader, 
    btn_login,
    btn_logout,
} from "./dom.js";
import { 
    createErrorMessage, 
    toggleClass 
} from "./interactive.js";

if (login_form) {
    login_form.addEventListener("submit", async (e) => {

        e.preventDefault();
        const t = e.target;

        btn_login.disabled = true;
        toggleClass(login_loader, ["show-loader"], true);
        toggleClass(login_loader, ["hide-loader"]);

        const _req = await fetch("/api/auth/login", {
            method: "POST",
            body: new FormData(t)
        });

        if (!_req.ok) {
            toggleClass(login_loader, ["show-loader"]);
            console.log("Something went wrong!");
        }

        const _res = await _req.json();
        console.log(_res);

        if (
            _res.status === "successful" && 
            _res.type === "ACCESS_GRANTED" &&
            _res.refresh &&
            _res.stop_load 
        ) { location.reload(); }
        window.onload = () => toggleClass(login_loader, ["hide-loader"]);
        if (_res.error) { console.log(_res.error) }
    });
}

if (btn_logout) {
    btn_logout.addEventListener("click", () => fetch("/logout"));
}