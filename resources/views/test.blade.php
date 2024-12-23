<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Test Deploy</title>
    @vite('resources/css/app.css')
</head>

<style>
    * {
        background-color: purple;
    }

    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100dvh;
    }

    .box {
        background-color: blueviolet;
        box-shadow: 0 12px 12px 5px black;
        color: aliceblue;
        padding: 15px;
        border-radius: 20px;
        animation: infiniteJump 5s ease-in-out 1s infinite;
    }

    h1,
    h2,
    h3 {
        background-color: blueviolet;
    }

    @keyframes infiniteJump {
        0% {
            transform: translateY(-100%);
        }

        15% {
            transform: translate(0);
        }

        30% {
            transform: translateX(-100%);
        }

        45% {
            transform: translate(0);
        }

        60% {
            transform: translateX(100%);
        }

        75% {
            transform: translate(0);
        }

        100% {
            transform: translateY(100%);
        }
    }
</style>

<body>
    <div class="box">
        <h1>Test Deploy</h1>
        <h2>Saye Upin</h2>
        <h2>Ini Adik Saya Ipin</h2>
        <h3>Ini Kisah Kami Semue</h3>
    </div>
</body>

</html>
