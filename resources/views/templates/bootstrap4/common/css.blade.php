@php
/*
CSS
*/
@endphp

<style>
/*loading*/
.sc-overlay {
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
  
  #sc-loading{
    display: none;
    position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 50;
      background: rgba(255,255,255,0.7);
  }
  /*end loading */

  /*price*/
  
.sc-new-price{
    color:#FE980F;
    font-size: 20px;
    padding: 10px;
    font-weight:bold;
  }
  .sc-old-price {
    text-decoration: line-through;
    color: #a95d5d;
    font-size: 17px;
    padding: 10px;
  }
  /*end price*/
.sc-product-build{
  font-size: 20px;
  font-weight: bold;
}
.sc-product-build img{
  width: 50px;
}
.sc-product-group  img{
    width: 100px;
    cursor: pointer;
  }
.sc-product-group:hover{
  box-shadow: 0px 0px 2px #999;
}
.sc-product-group:active{
  box-shadow: 0px 0px 2px #ff00ff;
}
.sc-product-group.active{
  box-shadow: 0px 0px 2px #ff00ff;
}

.sc-shipping-address td{
  padding: 3px !important;
}
.sc-shipping-address textarea,
.sc-shipping-address input[type="text"],
.sc-shipping-address option{
  width: 100%;
  padding: 7px !important;
}
.row_cart>td{
  vertical-align: middle !important;
}
input[type="number"]{
  text-align: center;
  padding:2px;
}
.sc-notice{
    clear: both;
}
</style>
