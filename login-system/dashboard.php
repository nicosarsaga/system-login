<?php

session_start();

if (
    !isset($_SESSION["logged_in"]) ||
    $_SESSION["logged_in"] !== true
) {

    header("Location: login.php");
    exit;
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

    <title>Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-white shadow-sm">

    <div class="
        max-w-6xl
        mx-auto
        px-6
        py-4
        flex
        justify-between
        items-center
    ">

        <div>

            <h1 class="text-xl font-bold">
                Login System
            </h1>

        </div>

        <a
            href="logout.php"
            class="
                bg-red-600
                hover:bg-red-700
                text-white
                px-4
                py-2
                rounded-lg
            "
        >
            Logout
        </a>

    </div>

</nav>

<main class="
    max-w-6xl
    mx-auto
    px-6
    py-10
">

    <div class="
        bg-white
        rounded-2xl
        shadow
        p-8
    ">

        <div class="mb-8">

            <p class="text-blue-600 font-medium">
                Authentication successful
            </p>

            <h2 class="
                text-3xl
                font-bold
                text-gray-800
                mt-2
            ">

                Welcome,
                <?= htmlspecialchars(
                    $_SESSION["firstname"]
                ) ?>!

            </h2>

            <p class="
                text-gray-500
                mt-2
            ">
                You successfully authenticated using
                Email/Password + Gmail OTP.
            </p>

        </div>

        <div class="
            grid
            md:grid-cols-2
            gap-5
        ">

            <div class="
                bg-gray-50
                border
                rounded-xl
                p-5
            ">

                <p class="
                    text-sm
                    text-gray-500
                ">
                    Username
                </p>

                <p class="
                    text-lg
                    font-semibold
                    mt-1
                ">
                    <?= htmlspecialchars(
                        $_SESSION["username"]
                    ) ?>
                </p>

            </div>

            <div class="
                bg-gray-50
                border
                rounded-xl
                p-5
            ">

                <p class="
                    text-sm
                    text-gray-500
                ">
                    Email
                </p>

                <p class="
                    text-lg
                    font-semibold
                    mt-1
                ">
                    <?= htmlspecialchars(
                        $_SESSION["email"]
                    ) ?>
                </p>

            </div>

            <div class="
                bg-gray-50
                border
                rounded-xl
                p-5
            ">

                <p class="
                    text-sm
                    text-gray-500
                ">
                    First Name
                </p>

                <p class="
                    text-lg
                    font-semibold
                    mt-1
                ">
                    <?= htmlspecialchars(
                        $_SESSION["firstname"]
                    ) ?>
                </p>

            </div>

            <div class="
                bg-gray-50
                border
                rounded-xl
                p-5
            ">

                <p class="
                    text-sm
                    text-gray-500
                ">
                    Last Name
                </p>

                <p class="
                    text-lg
                    font-semibold
                    mt-1
                ">
                    <?= htmlspecialchars(
                        $_SESSION["lastname"]
                    ) ?>
                </p>

            </div>

        </div>

        <div class="
            mt-8
            bg-green-50
            border
            border-green-200
            rounded-xl
            p-5
        ">

            <div class="flex items-center gap-3">

                <div class="text-2xl">
                    ✓
                </div>

                <div>

                    <h3 class="
                        font-semibold
                        text-green-800
                    ">
                        Two-Factor Authentication Complete
                    </h3>

                    <p class="
                        text-sm
                        text-green-700
                        mt-1
                    ">
                        Password authentication and
                        email OTP verification were successful.
                    </p>

                </div>

            </div>

        </div>

    </div>

</main>

</body>
</html>