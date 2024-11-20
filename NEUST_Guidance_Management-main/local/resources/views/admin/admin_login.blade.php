<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

    * {
        box-sizing: border-box;
    }

    body {
        background: #f6f5f7;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-family: 'Montserrat', sans-serif;
        height: 100vh;
        margin: -20px 0 50px;
    }

    h1 {
        font-weight: bold;
        margin: 0;
        margin-bottom: 20px;
        
    }
    

    button {
        border-radius: 20px;
        border: 1px solid rgb(0, 0, 0);
        background-color: #18471d;
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        /* transition: transform 80ms ease-in; */
        margin-top: 20px;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.25),
            0 10px 10px rgba(0, 0, 0, 0.22);
    }

    button:hover {
        background-color: #589c52; 
        color: black;
    }

    form {
        background-color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
    }

    input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.25),
            0 4px 4px rgba(0, 0, 0, 0.22);
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25),
            0 10px 10px rgba(0, 0, 0, 0.22);
        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        min-height: 480px;
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
    }

    .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
    }

    @keyframes show {

        0%,
        49.99% {
            opacity: 0;
            z-index: 1;
        }

        50%,
        100% {
            opacity: 1;
            z-index: 5;
        }
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .overlay {
        background: rgb(0,54,2);
        background: linear-gradient(90deg, rgb(1, 106, 5) 0%, rgb(5, 87, 0) 45%, rgba(8, 180, 2, 0.73) 100%);
        /* background: #FF416C; */
        /* background: -webkit-linear-gradient(to right, #1a237e, #0d47a1); */
        /* background: linear-gradient(to right, #171c4a, #4b539c); */
        /* background-image: url("../../img/neust2.jpg"); */
        background-repeat: no-repeat;
        /* background-size: cover; */
        background-position: 0 0;
        color: black;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-right {
        right: 0;
    } 

</style>
<title>ADMIN LOGIN</title>
<link rel="icon" href="img/logo.png"></link>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<div class="container" id="container">
    <div class="form-container sign-in-container">
        <form  id="login-form" action="#">
            <h1 style="color: #184722;">ADMIN SIGN IN</h1>
            <input type="text" id="username" name="username"  placeholder="Username" required>
            <input  type="password" id="password" name="password" class="form-input" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <img src="img/logo.png" alt="" style="width:100px;">
                <h1 style="text-shadow: 0 10px 24px rgba(0, 0, 0, 0.25),
            0 10px 10px rgba(0, 0, 0, 0.22); color: #f7f7f7;">Welcome Back Admin!</h1>
            </div>
        </div>
    </div>
</div>