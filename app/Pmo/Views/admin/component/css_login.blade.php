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
    background-color: rgba(255, 255, 255, .6);
    opacity: 0.9;
    border: 1px solid #809fff;
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
  
  .input100 {
    font-size: 15px;
    line-height: 1.2;
    color: black;
    border:2px solid #f39c12;
    display: block;
    width: 100%;
    background: #fff;
    height: 50px;
    border-radius: 7px;
    padding: 0 30px 0 53px;
  }
  
  .focus-input100 {
    display: block;
    position: absolute;
    border-radius: 7px;
    bottom: 0;
    left: 0;
    z-index: -1;
    width: 100%;
    height: 100%;
    box-shadow: 0px 0px 0px 0px;
    color: #f39c12;
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
    font-size: 15px;
    line-height: 1.5;
    color: white;
    min-width: 50%;
    height: 50px;
    border-radius: 7px;
    background: #f9710c;
    border: 2px solid #FFFFFF;
    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0 25px;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    -moz-transition: all 0.4s;
    transition: all 0.4s;
    position: relative;
    z-index: 1;
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
  
  .login-btn:hover {
    background: transparent;
    color: #fff;
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
    padding-top: 10px;
    padding-bottom: 20px;
}
</style>