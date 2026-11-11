<?php

session_start();

require_once "config/database.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username  = trim($_POST["username"]);
    $firstname = trim($_POST["firstname"]);
    $lastname  = trim($_POST["lastname"]);
    $email     = trim($_POST["email"]);
    $password  = $_POST["password"];

    // Validation
    if (
        empty($username) ||
        empty($firstname) ||
        empty($lastname) ||
        empty($email) ||
        empty($password)
    ) {

        $error = "All fields are required.";

    } elseif (
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {

        $error = "Please enter a valid email address.";

    } elseif (
        strlen($password) < 8
    ) {

        $error =
            "Password must contain at least 8 characters.";

    } else {

        // Check username/email
        $stmt = $conn->prepare(
            "SELECT id
             FROM users
             WHERE username = ?
             OR email = ?
             LIMIT 1"
        );

        $stmt->bind_param(
            "ss",
            $username,
            $email
        );

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $error =
                "Username or email already exists.";

        } else {

            // Hash password
            $password_hash =
                password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

            // Insert user
            $stmt = $conn->prepare(
                "INSERT INTO users
                (
                    username,
                    firstname,
                    lastname,
                    email,
                    password
                )
                VALUES (?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "sssss",
                $username,
                $firstname,
                $lastname,
                $email,
                $password_hash
            );

            if ($stmt->execute()) {

                $success =
                    "Registration successful! " .
                    "You can now login.";

            } else {

                $error =
                    "Registration failed.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register - Login System</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen">

<div class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-2xl shadow-xl p-8">

            <div class="text-center mb-8">

                <div class="text-5xl mb-3">
                    🔐
                </div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Create Account
                </h1>

                <p class="text-gray-500 mt-2">
                    Register your account
                </p>

            </div>

            <?php if ($error): ?>

                <div class="
                    bg-red-100
                    border border-red-300
                    text-red-700
                    px-4 py-3
                    rounded-lg
                    mb-5
                ">
                    <?= htmlspecialchars($error) ?>
                </div>

            <?php endif; ?>

            <?php if ($success): ?>

                <div class="
                    bg-green-100
                    border border-green-300
                    text-green-700
                    px-4 py-3
                    rounded-lg
                    mb-5
                ">
                    <?= htmlspecialchars($success) ?>
                </div>

            <?php endif; ?>

            <form method="POST" class="space-y-4">

                <div>

                    <label class="block text-sm font-medium mb-1">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        required
                        class="
                            w-full
                            border border-gray-300
                            rounded-lg
                            px-4 py-3
                            focus:ring-2
                            focus:ring-blue-500
                            focus:outline-none
                        "
                    >

                </div>

                <div class="grid grid-cols-2 gap-3">

                    <div>

                        <label class="block text-sm font-medium mb-1">
                            First Name
                        </label>

                        <input
                            type="text"
                            name="firstname"
                            required
                            class="
                                w-full
                                border border-gray-300
                                rounded-lg
                                px-4 py-3
                                focus:ring-2
                                focus:ring-blue-500
                                focus:outline-none
                            "
                        >

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-1">
                            Last Name
                        </label>

                        <input
                            type="text"
                            name="lastname"
                            required
                            class="
                                w-full
                                border border-gray-300
                                rounded-lg
                                px-4 py-3
                                focus:ring-2
                                focus:ring-blue-500
                                focus:outline-none
                            "
                        >

                    </div>

                </div>

                <div>

                    <label class="block text-sm font-medium mb-1">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        required
                        class="
                            w-full
                            border border-gray-300
                            rounded-lg
                            px-4 py-3
                            focus:ring-2
                            focus:ring-blue-500
                            focus:outline-none
                        "
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium mb-1">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        minlength="8"
                        required
                        class="
                            w-full
                            border border-gray-300
                            rounded-lg
                            px-4 py-3
                            focus:ring-2
                            focus:ring-blue-500
                            focus:outline-none
                        "
                    >

                    <p class="text-xs text-gray-500 mt-1">
                        Minimum 8 characters
                    </p>

                </div>

                <button
                    type="submit"
                    class="
                        w-full
                        bg-blue-600
                        hover:bg-blue-700
                        text-white
                        font-semibold
                        py-3
                        rounded-lg
                        transition
                    "
                >
                    Create Account
                </button>

            </form>

            <div class="text-center mt-6">

                <span class="text-gray-500">
                    Already have an account?
                </span>

                <a
                    href="login.php"
                    class="
                        text-blue-600
                        font-semibold
                        hover:underline
                    "
                >
                    Login
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>