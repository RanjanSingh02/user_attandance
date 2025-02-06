@echo off

:: Create the main directories
mkdir project
mkdir project\admin
mkdir project\employee
mkdir project\includes
mkdir project\assets
mkdir project\assets\css
mkdir project\assets\js
mkdir project\assets\images

:: Create files in the project root
type nul > project\index.php
type nul > project\database.sql

:: Create files in the admin directory
type nul > project\admin\index.php
type nul > project\admin\dashboard.php
type nul > project\admin\manage_users.php
type nul > project\admin\attendance.php
type nul > project\admin\reports.php
type nul > project\admin\logout.php

:: Create files in the employee directory
type nul > project\employee\index.php
type nul > project\employee\dashboard.php
type nul > project\employee\mark_attendance.php
type nul > project\employee\leave.php
type nul > project\employee\logout.php

:: Create files in the includes directory
type nul > project\includes\config.php
type nul > project\includes\header.php
type nul > project\includes\footer.php
type nul > project\includes\functions.php

:
