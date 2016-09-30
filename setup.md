---
layout: page
title: Set Up
weight: 3
---

<p>The first time Process Labs is run, you will see a start page asking several questions including: the name of the application, LTI consumer name, key & secret (required if using LTI or would like to access the status report via API), Admin’s name, email & password. This is required to initialize the application. These settings can be updated later in the Administrative Area.</p>

<p>Additional setup is required using a .env file. In the source, is an .env.example file. Copy this file and name it .env. In this file you can connect to your mySQL database and also add in settings for caching and mail sending. For mail, please note that the system has only been tested using gmail but <a href="https://laravel.com/docs/5.2/mail" target="_blank">Laravel does include several other options</a> for this.</p>

<h4>Self-standing</h4>

<p>The Process Lab can be run as a self-standing web application. It has the capability to register users and for users to login. The status API can be used as long as there is a consumer key & secret stored in settings. Please note that at this time, there can only be one combination of consumer key & secret per installation.</p>

<h4>Plugin</h4>

<p>Once set up, the process lab can be used as a plugin to an existing web application via <a href="https://www.imsglobal.org/specs/ltiv1p1/implementation-guide" target="_blank">LTI (Learning Tools Interoperability)</a> 1.0 compatibility. If used with LTI as a plugin, it’s important to note that any user data sent via LTI will override user data managed in the Administration Area. Please see <a href="/lti-requirements.html">LTI requirements</a>.</p>