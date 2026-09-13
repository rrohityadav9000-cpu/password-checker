<?php
$strength = "";
$message = "";
$password = "";

$checks = [
    "Minimum 8 characters" => false,
    "Uppercase letter (A-Z)" => false,
    "Lowercase letter (a-z)" => false,
    "Digit (0-9)" => false,
    "Special character (!@#$%^&*)" => false
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST["password"] ?? "";

    $checks["Minimum 8 characters"] = strlen($password) >= 8;
    $checks["Uppercase letter (A-Z)"] = preg_match('/[A-Z]/', $password) === 1;
    $checks["Lowercase letter (a-z)"] = preg_match('/[a-z]/', $password) === 1;
    $checks["Digit (0-9)"] = preg_match('/[0-9]/', $password) === 1;
    $checks["Special character (!@#$%^&*)"] = preg_match('/[^A-Za-z0-9]/', $password) === 1;

    $score = count(array_filter($checks));

    if ($password === "") {
        $message = "Please enter a password.";
    } elseif ($score <= 2) {
        $strength = "Weak";
        $message = "Your password needs improvement.";
    } elseif ($score <= 4) {
        $strength = "Medium";
        $message = "Good start! Add the missing requirements.";
    } else {
        $strength = "Strong";
        $message = "Excellent! Your password meets all requirements.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Strength Checker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="card">

        <div class="header">
            <div class="lock">🔐</div>
            <h1>Password Strength Checker</h1>
            <p>Check your password strength using PHP</p>
        </div>

        <form method="POST">
            <label for="password">Enter Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                value="<?php echo htmlspecialchars($password); ?>"
                required
            >

            <button type="submit" class="check-btn">Check Password</button>
        </form>

        <?php if ($password !== ""): ?>
            <div class="strength-box">
                <div class="strength-heading">
                    <span>Password Strength</span>
                    <strong class="<?php echo strtolower($strength); ?>">
                        <?php echo htmlspecialchars($strength); ?>
                    </strong>
                </div>

                <div class="strength-bar">
                    <div class="<?php echo strtolower($strength); ?>"></div>
                </div>
            </div>
        <?php endif; ?>

        <div class="requirements">
            <h2>Password Requirements</h2>

            <?php foreach ($checks as $label => $passed): ?>
                <div class="requirement">
                    <span class="<?php echo $passed ? 'pass' : 'fail'; ?>">
                        <?php echo $passed ? '✓' : '✗'; ?>
                    </span>
                    <span><?php echo htmlspecialchars($label); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($message !== ""): ?>
            <div class="result <?php echo strtolower($strength); ?>">
                <strong>
                    <?php echo htmlspecialchars($strength); ?>
                </strong>
                <p><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php endif; ?>

        <div class="tips">
            <h2>💡 Suggestions for Improvement</h2>
            <ul>
                <li>Use at least 8–12 characters.</li>
                <li>Use uppercase and lowercase letters.</li>
                <li>Include numbers.</li>
                <li>Include special characters.</li>
                <li>Avoid names, birthdays, and common words.</li>
                <li>Use a different password for each account.</li>
            </ul>
        </div>

        

    </div>
</div>
</body>
</html>