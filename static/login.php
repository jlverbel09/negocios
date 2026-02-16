<?php require_once '../db/conexion.php';
session_start();
if (!empty($_SESSION['usuario'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Georking Business - Iniciar Sesión</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de administracion de informacion de todos los negocios asociados">
    <meta name="author" content="GeorkingWeb">
    <meta name="keywords" content="web, business">
    <link rel="shortcut icon" href="img/icons/iconosolo.png" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login2.css">
    <link rel="stylesheet" href="css/style_responsive.css">
</head>

<body class="font-sans antialiased bg-mesh">

    <div class="flex min-h-screen">

        <!-- Lado Izquierdo: Formulario -->
        <div class="flex flex-col justify-center flex-1 px-8 py-12 sm:px-12 lg:flex-none lg:px-24 xl:px-32 bg-[#020617]/80 backdrop-blur-xl z-10">
            <div class="w-full max-w-sm mx-auto lg:w-96">

                <!-- Logo y Encabezado -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-indigo-600 p-1 rounded-md">
                            <img class="w-20" src="./img/icons/iconosolo.png" alt="">
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-white uppercase">
                            Georking <span class="text-indigo-500">Business</span>
                        </span>
                    </div>
                    <h2 class="text-3xl font-extrabold text-white">Bienvenido</h2>
                    <p class="mt-2 text-sm text-slate-400">
                        Ingresa a tu cuenta para gestionar tus resultados.
                    </p>
                </div>

                <!-- Formulario -->
                <form class="space-y-6" action="./index.php" method="get">
                    <div>
                        <label for="user" class="block text-sm font-medium text-slate-300">Usuario</label>
                        <div class="mt-1 relative">
                            <input id="user" name="user" type="text" placeholder="Tu usuario" onkeypress="handleKeyPress(event)"
                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-600 input-focus-effect transition-all">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium text-slate-300">Contraseña</label>
                            <!-- <a href="#" class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors">¿Olvidaste tu contraseña?</a> -->
                        </div>
                        <div class="mt-1 relative">
                            <input id="password" name="password" type="password" placeholder="••••••••" onkeypress="handleKeyPress(event)"
                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 text-white placeholder-slate-600 input-focus-effect transition-all">
                        </div>
                    </div>

                    <!-- <div class="flex items-center">
                        <input id="remember" type="checkbox" class="h-4 w-4 rounded border-slate-800 bg-slate-900 text-indigo-600 focus:ring-indigo-500">
                        <label for="remember" class="ml-2 block text-sm text-slate-400">Mantener sesión iniciada</label>
                    </div> -->

                    <div>
                        <button type="button" onClick="ingresar()" class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all shadow-lg shadow-indigo-500/20">
                            INICIAR SESIÓN
                            <span class="absolute right-4 group-hover:translate-x-1 transition-transform">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Footer del Formulario -->
                <div class="mt-10 border-t border-slate-800 pt-8">
                    <p class="text-center text-sm text-slate-500 italic px-4">
                        "Convierte ventas en estadísticas y estadísticas en ganancias."
                    </p>
                </div>
            </div>
        </div>

        <!-- Lado Derecho: Imagen y Frase -->
        <div class="hidden lg:block relative flex-1 w-0">
            <div class="absolute inset-0 h-full w-full side-image">
                <div class="absolute inset-0 bg-gradient-to-r from-[#020617] via-[#020617]/20 to-transparent"></div>

                <!-- Contenido Flotante sobre la imagen -->
                <div class="absolute bottom-20 left-20 max-w-lg">
                    <div class="bg-indigo-600/10 backdrop-blur-md border border-white/10 p-8 rounded-3xl">
                        <div class="flex gap-1 mb-4">
                            <i class="fas fa-star text-yellow-500 text-xs"></i>
                            <i class="fas fa-star text-yellow-500 text-xs"></i>
                            <i class="fas fa-star text-yellow-500 text-xs"></i>
                            <i class="fas fa-star text-yellow-500 text-xs"></i>
                            <i class="fas fa-star text-yellow-500 text-xs"></i>
                        </div>
                        <p class="text-xl text-white font-medium leading-relaxed">
                            "La mejor herramienta para llevar el control total de mi negocio. El análisis de datos nunca fue tan sencillo."
                        </p>
                        <div class="mt-6 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center">
                                <i class="fas fa-user-tie text-slate-400"></i>
                            </div>
                            <div>
                                <p class="text-white font-bold">Administrador Sede Nazca</p>
                                <p class="text-slate-400 text-sm">Usuario Verificado</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="slider">
        <div class="slide-track">

            <?php for ($i = 1; $i <= 3; $i++) { ?>
                <div class="slide"><a target="_blank" href="#"><img src="./logos/1.png" alt="Logo 1"></a></div>
                <div class="slide"><a target="_blank" href="#"><img src="./logos/2.png" alt="Logo 2"></a></div>
                <!-- <div class="slide"><a target="_blank" href="#"><img src="./logos/3.png" alt="Logo 3"></a></div> -->
                <div class="slide"><a target="_blank" href="#"><img src="./logos/4.png" alt="Logo 4"></a></div>
                <div class="slide"><a target="_blank" href="https://nazcarestaurante.com"><img src="./logos/7.png" alt="Logo 7"></a></div>
                <div class="slide"><a target="_blank" href="#"><img src="./logos/8.png" alt="Logo 8"></a></div>

            <?php } ?>
        </div>
    </div>
    <script src="js/login.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        function handleKeyPress(e) {
            const key = e.keyCode || e.which;

            if (key === 13) {
                ingresar()
                e.preventDefault();
            }
        }
    </script>
    <script src="js/app.js"></script>
</body>

</html>