<style>
  a {
    font-size: 14px;
    line-height: 1.7;
    color: #666666;
    margin: 0px;
    transition: all 0.4s;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    -moz-transition: all 0.4s;
  }
  
  a:focus {
    outline: none !important;
  }
  
  a:hover {
    text-decoration: none;
    color: #f39c12;
  }
  
  h1,h2,h3,h4,h5,h6 {
    margin: 0px;
  }
  
  p {
    font-size: 14px;
    line-height: 1.7;
    color: #666666;
    margin: 0px;
  }
  
  ul, li {
    margin: 0px;
    list-style-type: none;
  }
  
  
  input {
    outline: none;
    border: none;
  }
  
  
  input:focus::-webkit-input-placeholder { color:transparent; }
  input:focus:-moz-placeholder { color:transparent; }
  input:focus::-moz-placeholder { color:transparent; }
  input:focus:-ms-input-placeholder { color:transparent; }
  
  
  input::-webkit-input-placeholder { color: #999999; }
  input:-moz-placeholder { color: #999999; }
  input::-moz-placeholder { color: #999999; }
  input:-ms-input-placeholder { color: #999999; }

  button {
    outline: none !important;
    border: none;
    background: transparent;
  }
  
  button:hover {
    cursor: pointer;
  }

  .forgot {
    font-size: 14px;
    color: #424242;
    line-height: 1.4;
    float: right;
    margin-top: 20px;
  }
  .remember{
    margin-top: 20px;
    float: left;
    font-size: 14px;
    color: #424242;
    line-height: 1.4;
  }
  .logo{
    max-width: 150px;
  }
  
  .limiter {
    width: 100%;
    margin: 0 auto;
  }
  
  .container-login100 {
    width: 100%;
    min-height: 100vh;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    padding: 15px;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    position: relative;
    z-index: 1;
  }
  
  .container-login100::before {
    content: "";
    display: block;
    position: absolute;
    z-index: -1;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0.9;
  }
  
  .wrap-login100 {
    width: 350px;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
  }
  
  .login {
    width: 100%;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }
  .input100 {
    padding-left: 50px;
  }
  .login-title-des a {
    font-size: 25px;
    color: #042efb;
    line-height: 2.5;
    text-align: center;
    width: 100%;
    display: block;
    text-shadow: -1px 2px 4px #ffffff;
  }
  
  .login-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto;
  }
  .login-avatar img {
    width: 100%;
  }
  
  .wrap-input100 {
    position: relative;
    width: 100%;
    z-index: 1;
  }
  
  .input100:focus + .focus-input100 {
    -webkit-animation: anim-shadow 0.5s ease-in-out forwards;
    animation: anim-shadow 0.5s ease-in-out forwards;
  }
  
  @-webkit-keyframes anim-shadow {
    to {
      box-shadow: 0px 0px 80px 30px;
      opacity: 0;
    }
  }
  
  @keyframes anim-shadow {
    to {
      box-shadow: 0px 0px 80px 30px;
      opacity: 0;
    }
  }
  
  .symbol-input100 {
    font-size: 15px;
    color: #999999;

    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    align-items: center;
    position: absolute;
    border-radius: 25px;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    padding-left: 30px;
    pointer-events: none;

    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    -moz-transition: all 0.4s;
    transition: all 0.4s;
  }
  
  .input100:focus + .focus-input100 + .symbol-input100 {
    color: #00c6fb;
    padding-left: 23px;
  }
  
  .container-login-btn {
    width: 100%;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }
  
  .login-btn {
    padding: .54rem 1.2rem!important;
    height: 36px;
    line-height: 1.2;
    box-shadow: 0 3px 1px -2px rgba(0,0,0,.05), 0 2px 2px 0 rgba(0,0,0,.05), 0 1px 5px 1px rgba(0,0,0,.05);
    cursor: pointer;
    color: #fff;
    background-color: #495abf;
    border-color: #495abf;
  }
  
  .login-btn::before {
    content: "";
    display: block;
    position: absolute;
    z-index: -1;
    width: 100%;
    height: 100%;
    border-radius: 7px;
    top: 0;
    left: 0;
    background: #005bea;
    background: -webkit-linear-gradient(left, #bd7b28, #bd7b28);
    background: -o-linear-gradient(left, #bd7b28, #bd7b28);
    background: -moz-linear-gradient(left, #bd7b28, #bd7b28);
    background: linear-gradient(left, #bd7b28, #bd7b28);
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    -moz-transition: all 0.4s;
    transition: all 0.4s;
    opacity: 0;
  }
  
  .login-btn:hover:before {
    opacity: 1;
  }
  
  
  .validate-input {
    position: relative;
  }
  
  @media (max-width: 576px) {
    .wrap-login100 {
      padding-top: 80px;
      padding-left: 15px;
      padding-right: 15px;
    }
  }

  .main-login {
    border-radius: 4px;
    -webkit-box-shadow: 0px 3px 5px 3px #000000;
    box-shadow: 0px 5px 5px 3px rgba(0, 0, 0, 0.15);
    background: rgb(245,245,245);
    background: -moz-linear-gradient(top, rgba(245,245,245,1) 0%, rgba(235,235,235,1) 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(245,245,245,1)), color-stop(100%,rgba(235,235,235,1)));
    background: -webkit-linear-gradient(top, rgba(245,245,245,1) 0%,rgba(235,235,235,1) 100%);
    background: -o-linear-gradient(top, rgba(245,245,245,1) 0%,rgba(235,235,235,1) 100%);
    background: -ms-linear-gradient(top, rgba(245,245,245,1) 0%,rgba(235,235,235,1) 100%);
    background: linear-gradient(to bottom, rgba(245,245,245,1) 0%,rgba(235,235,235,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5f5f5', endColorstr='#ebebeb',GradientType=0 );
  }
  .container-login100 {
    background: #42464F;
  }
</style>