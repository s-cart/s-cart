<style>
#summary ul, #summary li {
    margin: 0;
    list-style: none;
    font-size: 11px;
    color: #fff;
    padding: 5px;
}
#summary {
  border-radius: 3px;
  border: 1px dashed #c7626c;
  margin: 10px 2px;
  background: #e9ecef;
}
.footer-static{
  color: #343a40 !important;
}

#summary div:first-child {
    margin-bottom: 4px;
}
#summary .progress {
  height: 3px;
  margin-bottom: 0;
  background: #fff;
}

.progress {
    overflow: hidden;
    height: 18px;
    margin-bottom: 18px;
    background-color: #f5f5f5;
    border-radius: 3px;
    -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
}
.progress-bar {
  height: 50px;
}
.progress-bar-default {
    background-color: #000;
}

@media (min-width: 768px) {
    .sidebar-collapse #summary {
        display: none !important;
        -webkit-transform: translateZ(0);
    }
    .box-body td,.box-body th{
    max-width:150px;word-break:break-all;
    }
}

    .overlay {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    transform: -webkit-translate(-50%, -50%);
    transform: -moz-translate(-50%, -50%);
    transform: -ms-translate(-50%, -50%);
    color:#1f222b;
    z-index: 9999;
    background: rgba(255,255,255,0.7);
  }
  .select2-selection{
    border-radius: inherit  !important;
    border: 1px solid #ccc !important;
  }
  
  .form-group > label.asterisk:after {
      content: " *";
      color: red;
  }
  #loading{
    display: none;
    position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 50;
      background: rgba(255,255,255,0.7);
  }
  .img_holder{
    margin-top:15px;
  }
  .img_holder > img{
    max-height:100px;max-width: 100px;
  }
  .more_info{
      margin-top: 10px;
      margin-left: 5px;
  }
  .breadcrumb{
    margin-right: 30px;
  }
  .action-teplate{
    min-width: 80px;
  }
  .seo{
    font-size: 10px;
    color: #ad3419;
  }
  .menu-left, .menu-right{
    display: inline;
  }
  .sc-old-price {
    text-decoration: line-through;
    color: #a95d5d;
    font-size: 13px;
    padding: 10px;
  }
  .sc-new-price {
    color: #FE980F;
    font-size: 14px;
    padding: 10px 5px;
    font-weight: bold;
  }
  #form-main hr{
    background-color: #afafaf;
    height: 1px;
    margin-bottom: 40px !important;
  }
  .pointer {cursor: pointer;}
  .btn-import{
    font-weight: bold !important;
    border-right: 1px solid #e1eae6;
    border-left: 1px solid #e1eae6;
    box-shadow: -1px -2px 0px 0px #e1eae6;
  }
  .filter-search {
    border: 1px solid #c5c5c5 !important;
  }
  .filter-button{
    border: 1px solid #c5c5c5 !important;
    background: #d2d6de;
  }
  .has-treeview li.active > a:last-child,
  .sidebar-menu > .active.menu-open > a:last-child,
  li.nav-item.active > a:last-child,
  .table-list tr.active {
    background: #c1d2ff !important;
  }
  .has-treeview.active.menu-open > a {
    font-weight: bold;
  }

 .nav-treeview {
   background: #fff !important;
 }
 .btn-primary {
    color: #fff;
    background-color: #3c8dbc !important;
    border-color: #3c8dbc !important;
 }
  .header-fix,.header-fix:hover{
    background: #8cc1dc;
    border-radius: 0px;
    color:#424242;
  }
  .dd-handle{
    border-radius: 0px !important;
  }
  .remove_menu{
    cursor: pointer;
  }
  .active-item{
    background: #c9d3d8 !important;
  }
  .dd-handle:hover{
    background: rgba(0,0,0,.1) !important;
  }

  /* .layout-fixed .main-sidebar{
    background-color: #222d32 !important;
  }
 */

.header {
  border-radius: 0px !important;
}
.sub-header {
  display: inline;
}
.invalid .help-block {
  color:red;
}
 /* lightblue */
 .main-sidebar .sidebar-lightblue  li.header{
  color: #ffffff !important;
    background: #4da0f1 !important;
    padding: 10px 25px 10px 15px;
    font-size: 12px;
  }

  .sidebar-lightblue .nav-item.has-treeview > a {
    color: #3b8ab8 !important;
  }

  /* dark */
  .main-sidebar .sidebar-gray-dark  li.header{
  color: #ffffff !important;
    background: #343a40 !important;
    padding: 10px 25px 10px 15px;
    font-size: 12px;
  }

  .sidebar-gray-dark .nav-item.has-treeview > a {
    color: #343a40 !important;
  }

  /* success */
  .main-sidebar .sidebar-success  li.header{
    color: #ffffff !important;
    background: #28a745 !important;
    padding: 10px 25px 10px 15px;
    font-size: 12px;
  }

  .sidebar-success .nav-item.has-treeview > a {
    color: #28a745 !important;
  }

  /* white */
  .main-sidebar .sidebar-white  li.header{
    color: #000 !important;
    background: #96a3ab !important;
    padding: 10px 25px 10px 15px;
    font-size: 12px;
  }

  .sidebar-white .nav-item.has-treeview > a {
    color: #000 !important;
  }

  /* pink */
  .main-sidebar .sidebar-pink  li.header{
  color: #ffffff !important;
    background: #e83e8c !important;
    padding: 10px 25px 10px 15px;
    font-size: 12px;
  }

  .sidebar-pink .nav-item.has-treeview > a {
    color: #e83e8c !important;
  }

  .brand-link.navbar-secondary {
    background-color: #c7626c !important;
    text-align: center;
    color: #fff !important;
  }
  .sidebar-form{
    background-color: #f4f6f9 !important;
  }
  .sidebar-form .form-control {
    border: 1px solid transparent !important;
  }

  /* .sidebar-form > .input-group:focus{
    background-color: #fff !important;
    color: #666 !important;
  } */

  .sidebar-form  input {
    background-color: transparent !important;
  }
  .tab-action > .nav-item {
    border-right: 1px solid #4da0f1;
  }
  .tab-action > .nav-item:last-child {
    border-right: 0px;
  }
  .tab-action > .nav-item.active {
    background: #e4ebff;
    border-bottom: 2px solid #b72020 80%;
    border: 1px dotted #f00;
    font-weight: bold;
  }
  .card-primary.card-outline-tabs>.card-header a.active {
    border-top: 3px solid #4da0f1 !important;
  }
  /* .navbar-primary {
    background: #386c84 !important;
  } */

  .icheckbox_square-blue {
    vertical-align: inherit !important;
  } 
  .form-text {
    font-size: 12px;
  }
  .filter-api {
    margin-right:5px; 
    vertical-align: text-top !important; 
    display:inline
  }
  .order-info {
    clear: both;
    font-size: 14px;
  }
  .order-info span {
    display: block;
  }
.block-action {
  display: inline;
  margin-right: 10px;
}
</style>