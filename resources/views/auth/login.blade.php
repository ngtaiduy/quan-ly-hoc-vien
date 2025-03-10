<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập bằng Firebase OTP</title>
  <script src="https://www.gstatic.com/firebasejs/11.4.0/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/11.4.0/firebase-auth-compat.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      margin-top: 50px;
    }

    input {
      display: block;
      width: 300px;
      margin: 10px auto;
      padding: 10px;
      font-size: 16px;
    }

    button {
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }
  </style>
</head>

<body>

  <h2>Đăng nhập bằng số điện thoại</h2>

  <!-- Nhập số điện thoại -->
  <input type="text" id="phone" placeholder="Nhập số điện thoại (+84xxxxxxxxx)">
  <div id="recaptcha-container"></div>
  <button onclick="sendOtp()">Gửi OTP</button>

  <!-- Nhập mã OTP -->
  <input type="text" id="otp" placeholder="Nhập mã OTP">
  <button onclick="verifyOtp()">Xác minh OTP</button>

  <p id="result"></p>

  <script>
    // Kiểm tra Firebase đã tải chưa
    if (typeof firebase === "undefined") {
      console.error("🔥 Firebase chưa được tải!");
    } else {
      console.log("✅ Firebase đã được tải!");

      // Cấu hình Firebase
      const firebaseConfig = {
        apiKey: "AIzaSyAiWdJ_-GlK3br029LEasbbi9sJqpWGTUA",
        authDomain: "laravel-otp-login-43a97.firebaseapp.com",
        projectId: "laravel-otp-login-43a97",
        storageBucket: "laravel-otp-login-43a97.appspot.com",
        messagingSenderId: "751329826128",
        appId: "1:751329826128:web:b64895cfca8c05c0b88855",
        measurementId: "G-0LS67TNRCQ"
      };

      // Khởi tạo Firebase
      firebase.initializeApp(firebaseConfig);
      const auth = firebase.auth();
      console.log("🚀 Firebase đã được khởi tạo thành công!");

      // Khởi tạo reCAPTCHA
      window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        'size': 'normal',
        'callback': function(response) {
          console.log("✔️ reCAPTCHA hợp lệ!");
        },
        'expired-callback': function() {
          console.warn("⚠️ reCAPTCHA hết hạn, tải lại trang!");
        }
      });
      recaptchaVerifier.render();
    }

    // Gửi OTP
    function sendOtp() {
      let phoneNumber = document.getElementById("phone").value;
      if (!phoneNumber.startsWith("+")) {
        alert("⚠️ Vui lòng nhập số điện thoại ở định dạng quốc tế (+84...)");
        return;
      }
      console.log("📞 Gửi OTP đến:", phoneNumber);

      firebase.auth().signInWithPhoneNumber(phoneNumber, window.recaptchaVerifier)
        .then((confirmationResult) => {
          window.confirmationResult = confirmationResult;
          alert("✅ OTP đã được gửi!");
        }).catch((error) => {
          console.error("❌ Lỗi gửi OTP:", error);
          alert("Lỗi gửi OTP: " + error.message);
        });
    }

    // Xác minh OTP
    function verifyOtp() {
      let otpCode = document.getElementById("otp").value;
      if (!otpCode) {
        alert("⚠️ Vui lòng nhập mã OTP!");
        return;
      }

      window.confirmationResult.confirm(otpCode)
        .then((result) => {
          let user = result.user;
          console.log("🎉 Đăng nhập thành công! UID:", user.uid);
          document.getElementById("result").innerText = "🎉 Đăng nhập thành công! UID: " + user.uid;
        }).catch((error) => {
          console.error("❌ Lỗi xác minh OTP:", error);
          alert("Lỗi xác minh OTP: " + error.message);
        });
    }
  </script>

</body>

</html>
