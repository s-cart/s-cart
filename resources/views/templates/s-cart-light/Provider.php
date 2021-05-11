<?php

//This function will be called after the template is installed.
function sc_template_install () {

}

//This function will be called after the template is removed.
function sc_template_uninstall() {

}

//This function will be called during template refresh.
function sc_template_refresh() {
    sc_template_uninstall();
    sc_template_install ();
}