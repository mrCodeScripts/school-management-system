"use strict";

import { 
    login_form, 
    login_loader, 
    btn_login,
    btn_logout,
    signup_form,
    btn_signup,
    signup_loader,
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
        ) {
            location.reload(); 
        } else {
            toggleClass(login_loader, ["show-loader"]);
            toggleClass(login_loader, ["hide-loader"], true);
            btn_login.disabled = false;
        }
        window.onload = () => toggleClass(login_loader, ["hide-loader"]);
    });
}

if (signup_form) {
    signup_form.addEventListener("submit", async (e) => {

        e.preventDefault();
        const t = e.target;

        btn_signup.disabled = true;
        toggleClass(signup_loader, ["show-loader"], true);
        toggleClass(signup_loader, ["hide-loader"]);

        const _req = await fetch("/api/auth/signup", {
            method: "POST",
            body: new FormData(t)
        });

        if (!_req.ok) {
            toggleClass(signup_loader, ["show-loader"]);
            console.log("Something went wrong!");
        }

        const _res = await _req.json();
        console.log(_res);

        if (
            _res.status === "successful" && 
            _res.type === "ACCESS_GRANTED" &&
            _res.refresh &&
            _res.stop_load 
        ) {
            location.reload(); 
        } else {
            toggleClass(signup_loader, ["show-loader"]);
            toggleClass(signup_loader, ["hide-loader"], true);
            btn_login.disabled = false;
        }
        window.onload = () => toggleClass(signup_loader, ["hide-loader"]);
    });
}

if (btn_logout) {
    btn_logout.addEventListener("click", async () => {
        const _req = await fetch("/api/logout", { method: "POST" });
        if (!_req.ok) {
            console.error("Something went wrong");
        }
        const _res = await _req.json();
        console.log(_res);
        if (
            _res.status === "successful" &&
            _res.type === "LOGOUT_SUCCESS"
        ) {
            location.reload();
        }
    });
}