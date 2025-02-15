"use strict";

import { login_form, login_loader } from "./dom.js";
import { createErrorMessage } from "./interactive.js";


if (login_form) {
    login_form.addEventListener("submit", async (e) => {

        e.preventDefault();
        const t = e.target;

        if (login_loader) {
            login_loader.classList.add("show-loader");
            if (login_loader.classList.contains("show-loader")) {
                login_loader.classList.remove("show-loader");
                login_loader.ariaColSpan.add("hide-loader");
            } else {
                login_loader.classList.add("show-loader");
                login_loader.ariaColSpan.remove("hide-loader");
            }
        }

        const _req = await fetch("/api/auth/login", {
            method: "POST",
            body: new FormData(t)
        });

        if (!_req.ok) {
            if (login_loader.classList.contains("show-loader") ||
                login_loader.classList.contains("hide-loader")) {
                login_loader.classList.remove("show-loader");
            }
            console.log("Something went wrong!");
        }

        const _res = await _req.json();

        if (_res.status)

            console.log(_res.message);

        if (_res.error) { console.log(_res.error) }
    });
}