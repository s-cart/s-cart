<style>
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
</style>