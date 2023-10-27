<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap");
    body {
      font-family: "Ubuntu", sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background-color: #f1f1f1;
      overflow: hidden;
    }
    
    .login-container {
      background-color: #fff;
      border: 1px solid #ddd;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      width: 350px;
    }
    
    .login-container input[type="text"],
    .login-container input[type="password"] {
      width: 95%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    
    .login-container button {
      width: 100%;
      padding: 10px;
      background-color: #D90429;
      color: #fff;
      border: none;
      font-weight: bold;
      font-size: 1rem;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .login-container button:hover {
    
      color: #D90429;
      border: 1px solid #D90429;
      background: transparent;
    }

    .invalid-input{
      border: 1px solid #D90429 !important;
    }

    #error-msg{
      color:#D90429;
      font-size: medium;
    }
  </style>

</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form action="{{ route('login') }}" method="POST">
      @csrf
      <input type="text" id="email" name="email" placeholder="Email" 
        class="@error('email') invalid-input @enderror"
        value="{{ old('email') }}">
  
      @error('email')
        <p id="error-msg">{{ $message }}</p>
      @enderror
  
      <input type="password" placeholder="Password" name="password" 
        class="@error('password') invalid-input @enderror"
        value="{{ old('password') }}">
  
      @error('password')
        <p id="error-msg">{{ $message }}</p>
      @enderror
  
      <button type="submit">Login</button>
    </form>
  </div>
  </body>
</html>
