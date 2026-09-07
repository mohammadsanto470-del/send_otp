









<?php
// MikroTik Hotspot থেকে রিকোয়েস্ট আসার জন্য প্রয়োজনীয় CORS Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ফর্ম থেকে আসা মোবাইল নম্বর সংগ্রহ
    $phone = $_POST['phone'] ?? '';

    if (empty($phone)) {
        echo "মোবাইল নম্বর পাওয়া যায়নি!";
        exit();
    }

    // ৪ ডিজিটের একটি র‍্যান্ডম OTP তৈরি
    $otp = rand(1000, 9999); 

    // sms.net.bd API তথ্যাদি
    $url = "https://api.sms.net.bd/sendsms";
    $api_key = "xsN64kK6JK90yqroZhJs2H9Xt4eTPj4D0cWLysfl"; // <--- এখানে আপনার আসল API Key-টি বসান
    $msg = "Your Link3 Hotspot OTP is: " . $otp;

    // API Call (POST Method)
    $data = array(
        'api_key' => $api_key,
        'msg'     => $msg,
        'to'      => $phone
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    // মেসেজ পাঠানো সফল হলে কনফার্মেশন দেখাবে
    echo "OTP সফলভাবে পাঠানো হয়েছে: " . htmlspecialchars($phone);
} else {
    echo "Invalid Request";
}
?>